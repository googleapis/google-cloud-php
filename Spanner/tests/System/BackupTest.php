<?php
/**
 * Copyright 2020 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Spanner\Tests\System;

use Google\ApiCore\ApiException;

use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\Exception\FailedPreconditionException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupEncryptionConfig;
use Google\Cloud\Spanner\Admin\Database\V1\EncryptionInfo\Type;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseEncryptionConfig;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Rpc\Code;

/**
 * @group spanner
 * @group flakey
 */

class BackupTest extends SystemTestCase
{
    use SystemTestCaseTrait;

    const BACKUP_PREFIX = 'spanner_backup_';

    // Set a much longer timeout for waiting on the LRO to complete.
    // Example: 4 hours (4 * 3600 seconds)
    const LONG_TIMEOUT_SECONDS = 4 * 3600;

    // EXPIRE_TIME is initialized in setUpTestFixtures to support older PHP versions

    protected static $backupId;
    protected static $cancelBackupId;
    protected static $copyBackupId;
    protected static $backupOperationName;
    protected static $restoreOperationName;
    protected static $restoreDbName;
    protected static $createTime;
    protected static $expireTime;
    protected static $backupDbName;
    protected static $project;

    private static $hasSetUpBackup = false;

    private float $testStartTime;

    /**
     * @before
     */
    public function startTestTimer(): void
    {
        $this->testStartTime = microtime(true);
    }

    /**
     * @after
     */
    public function logTestDuration(): void
    {
        $duration = microtime(true) - $this->testStartTime;
        
        self::debugLog($this->getName(), sprintf('Time taken: %.2f seconds', $duration));
    }

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        self::skipEmulatorTests();

        self::setUpTestDatabase();
        if (self::$hasSetUpBackup) {
            return;
        }

        self::$expireTime = new \DateTime('+7 hours');

        self::$project = self::parseName(self::$instance->name(), 'project');

        if (!self::$backupDbName = getenv('GOOGLE_CLOUD_SPANNER_TEST_BACKUP_DATABASE')) {
            self::$backupDbName = uniqid(self::TESTING_PREFIX);
            self::$deletionQueue->add(function () {
                self::getDatabaseInstance(self::$backupDbName)->drop();
            });
        } else {
            self::cancelPendingBackups(self::$backupDbName);
        }

        $db = self::getDatabaseInstance(self::$backupDbName);

        if (!$db->exists()) {
            $statements = [
                'CREATE TABLE ' . self::TEST_TABLE_NAME . ' (
                    id INT64 NOT NULL,
                    name STRING(MAX) NOT NULL,
                    birthday DATE NOT NULL
                ) PRIMARY KEY (id)'
            ];
            $dbOp = self::$instance->createDatabase(self::$backupDbName, ['statements' => $statements]);
            $dbOp->pollUntilComplete();
            self::insertData(5, self::$backupDbName);
        }

        self::$backupId = uniqid(self::BACKUP_PREFIX);
        self::$cancelBackupId = uniqid('cancel-');
        self::$copyBackupId = uniqid('copy-');
        self::$hasSetUpBackup = true;
    }

    /**
     * Tests that attempting to delete a backup that does not exist
     * is safe and does not throw an exception.
     */
    public function testDeleteNonExistantBackup()
    {
        $backup = self::$instance->backup('does_not_exis');

        $this->assertFalse($backup->exists());

        $backup->delete();
    }

    /**
     * Tests the successful creation of a backup.
     * We start the long-running operation, verify the initial metadata (CREATING state),
     * and then poll until the backup is READY.
     * This primary backup is used as a fixture by many subsequent read-only tests.
     */
    public function testCreateBackupAndInitCopyAndRestore(): array
    {
        $encryptionConfig = [
            'encryptionType' => CreateBackupEncryptionConfig\EncryptionType::GOOGLE_DEFAULT_ENCRYPTION,
        ];

        $backup = self::$instance->backup(self::$backupId);
        $db = self::getDatabaseInstance(self::$backupDbName);

        self::$createTime = gmdate('"Y-m-d\TH:i:s\Z"');
        $op = $backup->create(self::$backupDbName, self::$expireTime, [
            'encryptionConfig' => $encryptionConfig,
        ]);

        self::$deletionQueue->add(function () use ($backup) {
            if ($backup->exists()) {
                $backup->delete();
            }
        });

        self::$backupOperationName = $op->name();

        $metadata = null;
        foreach (self::$instance->backupOperations() as $lro) {
            if ($lro->name() == $op->name()) {
                $lro->reload();
                $metadata = $lro->info()['metadata'];
                break;
            }
        }

        $this->assertArrayHasKey('progress', $metadata);
        $this->assertArrayHasKey('progressPercent', $metadata['progress']);
        $this->assertArrayHasKey('startTime', $metadata['progress']);

        $this->assertNotNull($metadata);

        $this->assertTrue($backup->exists());
        $this->assertInstanceOf(Backup::class, $backup);
        $this->assertEquals(self::$backupId, DatabaseAdminClient::parseName($backup->info()['name'])['backup']);
        $this->assertEquals(
            self::$backupDbName,
            DatabaseAdminClient::parseName($backup->info()['database'])['database']
        );
        $this->assertEquals(self::$expireTime->format('Y-m-d\TH:i:s.u\Z'), $backup->info()['expireTime']);
        $this->assertTrue(is_string($backup->info()['createTime']));

        if (!getenv('GOOGLE_CLOUD_SPANNER_TEST_BACKUP_DATABASE')) {
            // earliestVersionTime deviates from backup's versionTime by a couple of minutes
            $expectedDateTime = \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $db->info()['earliestVersionTime']);
            $actualDateTime = \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $backup->info()['versionTime']);
            $this->assertEqualsWithDelta($expectedDateTime->getTimestamp(), $actualDateTime->getTimestamp(), 300);
        }
        $this->assertEquals(Type::GOOGLE_DEFAULT_ENCRYPTION, $backup->info()['encryptionInfo']['encryptionType']);

        // Poll for completion with the extended timeout
        $this->pollWithExtendedTimeout($op, __FUNCTION__);

        $backup->reload();
        $this->assertEquals(Backup::STATE_READY, $backup->state());
        $this->assertTrue($backup->info()['sizeBytes'] > 0);

        return [
            'copy' => $this->createBackupCopy(),
            'restore' => $this->restoreToNewDatabase()
        ];
    }

    /**
     * Tests that attempting to create a backup with an expiration time in the past fails.
     * It expects a BadRequestException or FailedPreconditionException to be thrown,
     * and verifies that the backup is not created.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testCreateBackupRequestFailed()
    {
        $backupId = uniqid(self::BACKUP_PREFIX);
        $expireTime = new \DateTime('-2 hours');

        $backup = self::$instance->backup($backupId);

        $e = null;
        $max_retries = 3;
        for ($i = 0; $i < $max_retries; $i++) {
            try {
                $backup->create(self::$backupDbName, $expireTime);
                break;
            } catch (BadRequestException | FailedPreconditionException $e) {
                break;
            } catch (ServiceException | ApiException $ex) {
                $allowed = [Code::UNAVAILABLE, Code::DEADLINE_EXCEEDED];
                if ($i === 2 || !in_array($ex->getCode(), $allowed)) {
                    throw $ex;
                }
                self::debugLog(
                    __FUNCTION__,
                    'Caught ' . \get_class($ex) . ' with Code '
                    . Code::name($ex->getCode()) . ' on retry attempt ' . ($i + 1)
                    . ' out of ' . $max_retries
                );
                sleep(2);
            }
        }

        $this->assertNotNull($e);
        $this->assertTrue($e instanceof BadRequestException || $e instanceof FailedPreconditionException);
        $this->assertFalse($backup->exists());
    }

    /**
     * Tests that providing invalid arguments (like an invalid version time type
     * or a malformed KMS key name) when creating a backup fails with the expected exceptions.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testCreateBackupInvalidArgument()
    {
        $backupId = uniqid(self::BACKUP_PREFIX);
        $expireTime = new \DateTime('-2 hours');

        $backup = self::$instance->backup($backupId);

        $e = null;
        try {
            $backup->create(self::$backupDbName, $expireTime, [
                'versionTime' => 'invalidType',
            ]);
        } catch (\InvalidArgumentException $e) {
        }

        $this->assertInstanceOf(\InvalidArgumentException::class, $e);
        $this->assertFalse($backup->exists());

        $e = null;
        try {
            $backup->create(self::$backupDbName, $expireTime, [
                'encryptionConfig' => ['kmsKeyName' => 'validKeyName'],
            ]);
        } catch (BadRequestException $e) {
        }

        $this->assertInstanceOf(BadRequestException::class, $e);
        $this->assertFalse($backup->exists());
    }

    /**
     * Tests that providing an invalid KMS key name when restoring a database
     * from a backup results in a BadRequestException.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testRestoreInvalidArgument()
    {
        $restoreDbName = uniqid('restored_db_');

        $e = null;
        try {
            $this::$instance->createDatabaseFromBackup(
                $restoreDbName,
                self::fullyQualifiedBackupName(self::$backupId),
                [
                    'encryptionConfig' => [
                        'kmsKeyName' => 'validKmsKey'
                    ]
                ]
            );
        } catch (BadRequestException $e) {
        }
        $database = self::$instance->database($restoreDbName);

        $this->assertInstanceOf(BadRequestException::class, $e);
        $this->assertFalse($database->exists());
    }

    /**
     * Tests successfully updating the expiration time of an existing backup.
     * This modifies the primary backup's expiration to 10 days in the future,
     * which is later relied upon by expiration filtering tests to differentiate backups.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testUpdateExpirationTime()
    {
        $backup = self::$instance->backup(self::$backupId);

        $currentExpireTime = $backup->info()['expireTime'];

        $newExpireTime = new \DateTime('+10 days');

        $backup->updateExpireTime($newExpireTime);

        $this->assertNotEquals($currentExpireTime, $backup->info()['expireTime']);
        $this->assertEquals($newExpireTime->format('Y-m-d\TH:i:s.u\Z'), $backup->info()['expireTime']);
    }

    /**
     * Tests that attempting to update a backup's expiration time to a value
     * that is too soon (e.g. 5 minutes from now) fails, as Spanner requires
     * backups to be retained for a longer minimum duration.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testUpdateExpirationTimeFailed()
    {
        $backup = self::$instance->backup(self::$backupId);

        $currentExpireTime = $backup->info()['expireTime'];

        $newExpireTime = new \DateTime('+5 minutes');

        $e = null;
        try {
            $backup->updateExpireTime($newExpireTime);
        } catch (BadRequestException $e) {
        }

        $this->assertInstanceOf(BadRequestException::class, $e);
        $backup->reload();

        $this->assertNotEquals($newExpireTime->format('Y-m-d\TH:i:s.u\Z'), $backup->info()['expireTime']);
        $this->assertEquals($currentExpireTime, $backup->info()['expireTime']);
    }

        /**
     * Tests that listing backups scoped to a specific database
     * successfully returns the expected backups.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testListAllBackupsOfDatabase()
    {
        $database = self::$instance->database(self::$backupDbName);
        $backups = iterator_to_array($database->backups());

        $this->assertTrue(count($backups) > 0);

        foreach ($backups as $b) {
            $this->assertEquals($database->name(), $b->info()['database']);
        }
    }

    /**
     * Tests that we can successfully list backup operations and filter
     * them by the specific operation name from our backup creation.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testListAllBackupOperations()
    {
        $backupOps = iterator_to_array($this::$instance->backupOperations([
            'filter' => sprintf('name="%s"', self::$backupOperationName)
        ]));

        $backupOpsNames = array_map(function ($bOp) {
            return $bOp->name();
        }, $backupOps);

        $this->assertTrue(count($backupOps) > 0);
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $backupOps);
        $this->assertTrue(in_array(self::$backupOperationName, $backupOpsNames));
    }

    /**
     * Tests that we can successfully cancel an in-progress backup creation operation.
     * It starts a backup creation, immediately cancels it, and waits for the cancellation
     * to complete to ensure the pending backup slot is freed.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testCancelBackupOperation()
    {
        $backup = self::$instance->backup(self::$cancelBackupId);

        $op = $backup->create(self::$backupDbName, self::$expireTime);

        try {
            $op->cancel();
        } catch (ServiceException | ApiException $e) {
            if ($e->getCode() !== Code::DEADLINE_EXCEEDED) {
                throw $e;
            }
            self::debugLog(
                __FUNCTION__,
                'Caught ' . \get_class($e) . ' with Code ' . Code::name($e->getCode())
            );
        }

        $this->pollWithExtendedTimeout($op, __FUNCTION__);

        $error = $op->info()['error'] ?? null;
        $this->assertNotNull($error);
        $this->assertEquals(Code::CANCELLED, $error['code']);
    }


    /**
     * Tests listing all backups globally (across the instance) with a database filter,
     * ensuring it returns instances of the Backup class.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testListAllBackups()
    {
        $allBackups = iterator_to_array(
            self::$instance->backups(['filter' => 'database:' . self::$backupDbName]),
            false
        );
        $this->assertTrue(count($allBackups) > 0);
        $this->assertContainsOnlyInstancesOf(Backup::class, $allBackups);
    }

    /**
     * Tests listing backups with a name filter to retrieve exactly the primary backup.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testListAllBackupsContainsName()
    {
        $backups = iterator_to_array(self::$instance->backups(['filter' => 'name:' . self::$backupId]));
        $this->assertTrue(count($backups) == 1);
        $this->assertEquals(self::$backupId, DatabaseAdminClient::parseName($backups[0]->info()['name'])['backup']);
    }

    /**
     * Tests filtering backups by their state to ensure that the primary backup
     * is returned when querying for READY backups.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testListAllBackupsReady()
    {
        $backups = iterator_to_array(self::$instance->backups(['filter' => 'state:READY']));

        $backupNames = [];
        foreach ($backups as $b) {
            $backupNames[] = $b->name();
        }

        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$backupId), $backupNames));
    }

    /**
     * Tests filtering backups by a creation timestamp. Since the primary backup
     * was created at or after the test's recorded create time, it should be included.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testListAllBackupsCreatedAfterTimestamp()
    {
        $filter = sprintf('create_time >= %s', self::$createTime);

        $backups = iterator_to_array(self::$instance->backups(['filter' => $filter]));

        $backupNames = [];
        foreach ($backups as $b) {
            $backupNames[] = $b->name();
        }
        $this->assertTrue(count($backupNames) > 0);
        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$backupId), $backupNames));
    }

    /**
     * Tests creating a copy of an existing backup.
     * It polls until the copy operation finishes. The resulting backup copy
     * is used as a secondary fixture for subsequent listing and pagination tests.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testCreateBackupCopy(array $ops)
    {
        $op = $ops['copy'];
        $newBackup = self::$instance->backup(self::$copyBackupId);

        $metadata = null;
        foreach (self::$instance->backupOperations() as $lro) {
            if ($lro->name() == $op->name()) {
                $metadata = $lro->info()['metadata'];
                break;
            }
        }

        $this->assertNotNull($metadata);
        $this->assertArrayHasKey('progress', $metadata);
        $this->assertArrayHasKey('progressPercent', $metadata['progress']);
        $this->assertArrayHasKey('startTime', $metadata['progress']);

        $this->assertTrue($newBackup->exists());
        $this->assertInstanceOf(Backup::class, $newBackup);
        $this->assertEquals(self::$copyBackupId, DatabaseAdminClient::parseName($newBackup->info()['name'])['backup']);
        $this->assertEquals(
            self::$backupDbName,
            DatabaseAdminClient::parseName($newBackup->info()['database'])['database']
        );
        $this->assertTrue(is_string($newBackup->info()['createTime']));
        $this->assertEquals(Type::GOOGLE_DEFAULT_ENCRYPTION, $newBackup->info()['encryptionInfo']['encryptionType']);

        $this->pollWithExtendedTimeout($op, __FUNCTION__);

        $newBackup->reload();
        $this->assertEquals(Backup::STATE_READY, $newBackup->state());
        $this->assertTrue($newBackup->info()['sizeBytes'] > 0);
    }

    /**
     * Tests filtering backups by their expiration timestamp.
     * Relies on testUpdateExpirationTime() having modified the primary backup to
     * expire in 10 days, while the backup copy expires in 7 hours.
     * Filtering by < 9 hours should therefore exclude the primary backup
     * but include the copy.
     *
     * @depends testCreateBackupCopy
     */
    public function testListAllBackupsExpireBeforeTimestamp()
    {
        $filter = 'expire_time < ' . gmdate('"Y-m-d\TH:i:s\Z"', strtotime('+9 hours'));

        $backups = iterator_to_array(self::$instance->backups(['filter' => $filter]));

        $backupNames = [];
        foreach ($backups as $b) {
            $backupNames[] = $b->name();
        }
        $this->assertTrue(count($backupNames) > 0);
        $this->assertFalse(in_array(self::fullyQualifiedBackupName(self::$backupId), $backupNames));
        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$copyBackupId), $backupNames));
    }

    /**
     * Tests filtering backups by size. Since the copy is exact, both the primary
     * backup and the copy will have sizes >= the primary backup's size,
     * so both should be returned.
     *
     * @depends testCreateBackupCopy
     */
    public function testListAllBackupsWithSizeGreaterOrEqualToSomeBytes()
    {
        $backup = self::$instance->backup(self::$backupId);
        $size = $backup->info()['sizeBytes'];
        $filter = 'size_bytes >= ' . $size;

        $backups = iterator_to_array(self::$instance->backups(['filter' => $filter]));

        $backupNames = [];

        foreach ($backups as $b) {
            $backupNames[] = $b->name();
        }
        $this->assertTrue(count($backupNames) > 0);
        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$backupId), $backupNames));
        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$copyBackupId), $backupNames));
    }

    /**
     * @depends testCreateBackupCopy
     */
    public function testPagination()
    {
        $backupsfirstPage = self::$instance->backups(['pageSize' => 1]);
        $page = $backupsfirstPage->iterateByPage()->current();
        $this->assertEquals(1, count($page));

        $backupsSecondPage = self::$instance->backups(
            ['pageToken' => $backupsfirstPage->nextResultToken(), 'pageSize' => 1]
        );
        $page = $backupsSecondPage->iterateByPage()->current();
        $this->assertEquals(1, count($page));

        $backupsPageSizeTwo = self::$instance->backups(['pageSize' => 2])->iterateByPage()->current();
        $this->assertEquals(2, count($backupsPageSizeTwo));
    }

    /**
     * Tests that a backup can be successfully deleted.
     * This cleans up the secondary backup copy that was used for the list/pagination tests.
     *
     * @depends testCreateBackupCopy
     */
    public function testDeleteBackup()
    {
        $backup = self::$instance->backup(self::$copyBackupId);

        $this->assertTrue($backup->exists());

        $backup->delete();

        $this->assertFalse($backup->exists());
    }

    /**
     * Tests restoring a database from a backup.
     * This starts the restore LRO, verifies the metadata while restoring,
     * and blocks until the restore completes.
     *
     * @depends testCreateBackupAndInitCopyAndRestore
     */
    public function testRestoreToNewDatabase(array $ops)
    {
        $op = $ops['restore'];

        $metadata = null;
        foreach (self::$instance->databaseOperations() as $lro) {
            if (basename($lro->info()['metadata']['name']) == self::$restoreDbName) {
                $metadata = $lro->info()['metadata'];
                break;
            }
        }
        $restoredDb = $this::$instance->database(self::$restoreDbName);

        $this->assertNotNull($metadata);
        $this->assertArrayHasKey('progress', $metadata);
        $this->assertArrayHasKey('progressPercent', $metadata['progress']);
        $this->assertArrayHasKey('startTime', $metadata['progress']);

        $this->assertTrue($restoredDb->exists());

        $backup = $this::$instance->backup(self::$backupId);

        $this->assertEquals(
            $backup->info()['versionTime'],
            $restoredDb->info()['restoreInfo']['backupInfo']['versionTime']
        );
        $this->assertEquals(
            Type::GOOGLE_DEFAULT_ENCRYPTION,
            current($restoredDb->info()['encryptionInfo'])['encryptionType']
        );

        $this->pollWithExtendedTimeout($op, __FUNCTION__);

        $restoredDb->reload();
        $this->assertContains($restoredDb->state(), [
            Database::STATE_READY,
            Database::STATE_READY_OPTIMIZING
        ]);
    }

    /**
     * Tests that the database restore operation appears in the list
     * of database operations when filtered by its operation name.
     *
     * @depends testRestoreToNewDatabase
     */
    public function testRestoreAppearsInListDatabaseOperations()
    {
        $databaseOps = iterator_to_array($this::$instance->databaseOperations([
            'filter' => sprintf('name="%s"', self::$restoreOperationName)
        ]));
        $databaseOpsNames = array_map(function ($dOp) {
            return $dOp->name();
        }, $databaseOps);

        $this->assertTrue(count($databaseOps) > 0);
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $databaseOps);
        $this->assertTrue(in_array(self::$restoreOperationName, $databaseOpsNames));
    }

    /**
     * Tests that attempting to restore a backup over an existing database fails
     * with a ConflictException, as restores must target newly created databases.
     *
     * @depends testRestoreToNewDatabase
     */
    public function testRestoreBackupToAnExistingDatabase()
    {
        $existingDb = self::$instance->database(self::$backupDbName);
        $this->assertTrue($existingDb->exists());

        $e = null;
        $retries = 3;
        while ($retries > 0) {
            try {
                $this::$instance->createDatabaseFromBackup(
                    self::$backupDbName,
                    self::fullyQualifiedBackupName(self::$backupId)
                );
                break;
            } catch (ConflictException $e) {
                break;
            } catch (ServiceException | ApiException $ex) {
                if ($ex->getCode() === Code::UNAVAILABLE && $retries > 0) {
                    self::debugLog(
                        __FUNCTION__,
                        'Caught ' . \get_class($ex) . ' with Code '
                        . Code::name($ex->getCode()) . '. ' . $retries . ' attempts left'
                    );
                    $retries--;
                    sleep(2);
                    continue;
                }
                throw $ex;
            }
        }

        $this->assertInstanceOf(ConflictException::class, $e);
    }


    private function createBackupCopy(): LongRunningOperation
    {
        $backup = self::$instance->backup(self::$backupId);
        $newBackup = self::$instance->backup(self::$copyBackupId);
        $op = $backup->createCopy($newBackup, self::$expireTime);

        self::$deletionQueue->add(function () use ($newBackup) {
            if ($newBackup->exists()) {
                $newBackup->delete();
            }
        });

        return $op;
    }

    private function restoreToNewDatabase(): LongRunningOperation
    {
        self::$restoreDbName = uniqid('restored_db_');
        $encryptionConfig = [
            'encryptionType' => RestoreDatabaseEncryptionConfig\EncryptionType::GOOGLE_DEFAULT_ENCRYPTION
        ];

        $op = $this::$instance->createDatabaseFromBackup(
            self::$restoreDbName,
            self::fullyQualifiedBackupName(self::$backupId),
            ['encryptionConfig' => $encryptionConfig]
        );

        $restoredDb = $this::$instance->database(self::$restoreDbName);

        self::$deletionQueue->add(function () use ($restoredDb) {
            if ($restoredDb->exists()) {
                $restoredDb->drop();
            }
        });

        self::$restoreOperationName = $op->name();

        return $op;
    }

    private static function fullyQualifiedBackupName($backupId)
    {
        return DatabaseAdminClient::backupName(self::$project, self::INSTANCE_NAME, $backupId);
    }

    private static function insertData($rows, $dbname)
    {
        $rows = self::generateRows($rows);
        self::fill($dbname, self::TEST_TABLE_NAME, $rows);
    }

    private static function fill($dbName, $tbl, array $rows)
    {
        $db = self::$instance->database($dbName);
        $db->insertBatch($tbl, $rows);
    }

    private static function generateRows($number)
    {
        $rows = [];

        for ($id = 1; $id <= $number; $id++) {
            $rows[] = self::generateRow($id, uniqid(self::TESTING_PREFIX), new Date(new \DateTime()));
        }
        return $rows;
    }

    private static function generateRow($id, $field1, $field2)
    {
        return [
            'id' => $id,
            'name' => $field1,
            'birthday' => $field2
        ];
    }

    private static function parseName($name, $id)
    {
        return DatabaseAdminClient::parseName($name)[$id];
    }
    private function pollWithExtendedTimeout($op, $func)
    {
        $timeout = time() + self::LONG_TIMEOUT_SECONDS;
        while (time() < $timeout) {
            try {
                $op->pollUntilComplete([
                    'maxPollingDurationSeconds' => $timeout - time()
                ]);
                break;
            } catch (ServiceException | ApiException $e) {
                if ($e->getCode() !== Code::DEADLINE_EXCEEDED) {
                    throw $e;
                }
                self::debugLog(
                    $func,
                    'Caught ' . \get_class($e) . ' with Code ' . Code::name($e->getCode())
                );
            }
        }

        return $op;
    }

    private static function cancelPendingBackups($dbName)
    {
        $dbFullName = self::getDatabaseInstance($dbName)->name();
        try {
            foreach (self::$instance->backupOperations() as $op) {
                if ($op->done()) {
                    continue;
                }

                $metadata = $op->info()['metadata'] ?? [];
                if (!isset($metadata['database']) || $metadata['database'] !== $dbFullName) {
                    continue;
                }

                try {
                    $op->cancel();
                    $op->pollUntilComplete(['maxPollingDurationSeconds' => 120]);
                } catch (\Exception $e) {
                    self::debugLog(
                        __FUNCTION__,
                        'Ignored ' . \get_class($e) . ' while cancelling backup operation: ' . $e->getMessage()
                    );
                }
            }
        } catch (\Exception $e) {
            self::debugLog(
                __FUNCTION__,
                'Ignored ' . \get_class($e) . ' during overall backup cancellation cleanup: ' . $e->getMessage()
            );
        }
    }
    private static function debugLog($functionName, $message)
    {
        error_log('Debug [' . $functionName . ']: ' . $message);
    }
}
