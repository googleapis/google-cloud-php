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

use Google\Auth\Cache\InvalidArgumentException;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupEncryptionConfig;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseEncryptionConfig;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\EncryptionConfig;
use Google\Cloud\Spanner\Admin\Database\V1\EncryptionInfo\Type;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Date;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 */
class BackupTest extends SpannerTestCase
{
    use ExpectException;

    const BACKUP_PREFIX = 'spanner_backup_';

    protected static $backupId1;
    protected static $backupId2;
    protected static $copyBackupId;
    protected static $backupOperationName;
    protected static $restoreOperationName;
    protected static $createDbOperationName;
    protected static $createTime1;
    protected static $createTime2;

    protected static $dbName1;
    protected static $dbName2;

    protected static $project;

    private static $hasSetUp = false;

    public static function set_up_before_class()
    {
        self::skipEmulatorTests();

        parent::set_up_before_class();
        if (self::$hasSetUp) {
            return;
        }

        self::$project = self::parseName(self::$instance->name(), 'project');

        self::$dbName1 = uniqid(self::TESTING_PREFIX);
        $op = self::$instance->createDatabase(self::$dbName1);
        self::$createDbOperationName = $op->name();
        $op->pollUntilComplete();

        $db1 = self::getDatabaseInstance(self::$dbName1);

        self::$deletionQueue->add(function () use ($db1) {
            $db1->drop();
        });

        $db1->updateDdl(
            'CREATE TABLE '. self::TEST_TABLE_NAME .' (
                id INT64 NOT NULL,
                name STRING(MAX) NOT NULL,
                birthday DATE NOT NULL
            ) PRIMARY KEY (id)'
        )->pollUntilComplete();

        self::$dbName2 = uniqid(self::TESTING_PREFIX);
        $op = self::$instance->createDatabase(self::$dbName2);
        $op->pollUntilComplete();

        $db2 = self::getDatabaseInstance(self::$dbName2);

        self::$deletionQueue->add(function () use ($db2) {
            $db2->drop();
        });

        $db2->updateDdl(
            'CREATE TABLE '. self::TEST_TABLE_NAME .' (
                id INT64 NOT NULL,
                name STRING(MAX) NOT NULL,
                birthday DATE NOT NULL
            ) PRIMARY KEY (id)'
        )->pollUntilComplete();

        self::insertData(5, self::$dbName1);
        self::insertData(10, self::$dbName2);

        self::$backupId1 = uniqid(self::BACKUP_PREFIX);
        self::$backupId2 = uniqid("users-");
        self::$copyBackupId = uniqid("copy-");
        self::$hasSetUp = true;
    }

    public function testListAllInstances()
    {
        $allInstances = self::$client->instances();

        foreach ($allInstances as $i) {
            print(PHP_EOL);
            print_R($i->name());
        }
    }

    public function testCreateBackup()
    {
        $expireTime = new \DateTime('+7 hours');
        $versionTime = new \DateTime('-5 seconds');
        $encryptionConfig = [
            'encryptionType' => CreateBackupEncryptionConfig\EncryptionType::GOOGLE_DEFAULT_ENCRYPTION,
        ];

        $backup = self::$instance->backup(self::$backupId1);
        $db1 = self::getDatabaseInstance(self::$dbName1);

        self::$createTime1 = gmdate('"Y-m-d\TH:i:s\Z"');
        $op = $backup->create(self::$dbName1, $expireTime, [
            'versionTime' => $versionTime,
            'encryptionConfig' => $encryptionConfig,
        ]);
        self::$backupOperationName = $op->name();

        $metadata = null;
        foreach (self::$instance->backupOperations() as $listItem) {
            if ($listItem->name() == $op->name()) {
                $metadata = $listItem->info()['metadata'];
                break;
            }
        }

        $op->pollUntilComplete();

        self::$deletionQueue->add(function () use ($backup) {
            $backup->delete();
        });

        $this->assertTrue($backup->exists());
        $this->assertInstanceOf(Backup::class, $backup);
        $this->assertEquals(self::$backupId1, DatabaseAdminClient::parseName($backup->info()['name'])['backup']);
        $this->assertEquals(self::$dbName1, DatabaseAdminClient::parseName($backup->info()['database'])['database']);
        $this->assertEquals($expireTime->format('Y-m-d\TH:i:s.u\Z'), $backup->info()['expireTime']);
        $this->assertTrue(is_string($backup->info()['createTime']));
        $this->assertEquals(Backup::STATE_READY, $backup->state());
        $this->assertTrue($backup->info()['sizeBytes'] > 0);
        $this->assertEquals($db1->info()['earliestVersionTime'], $backup->info()['versionTime']);
        $this->assertEquals(Type::GOOGLE_DEFAULT_ENCRYPTION, $backup->info()['encryptionInfo']['encryptionType']);

        $this->assertNotNull($metadata);
        $this->assertArrayHasKey('progress', $metadata);
        $this->assertArrayHasKey('progressPercent', $metadata['progress']);
        $this->assertArrayHasKey('startTime', $metadata['progress']);
    }

    public function testCreateBackupRequestFailed()
    {
        $backupId = uniqid(self::BACKUP_PREFIX);
        $expireTime = new \DateTime('-2 hours');

        $backup = self::$instance->backup($backupId);

        $e = null;
        try {
            $backup->create(self::$dbName1, $expireTime);
        } catch (BadRequestException $e) {
        }

        $this->assertInstanceOf(BadRequestException::class, $e);
        $this->assertFalse($backup->exists());
    }

    public function testCreateBackupInvalidArgument()
    {
        $backupId = uniqid(self::BACKUP_PREFIX);
        $expireTime = new \DateTime('-2 hours');

        $backup = self::$instance->backup($backupId);

        $e = null;
        try {
            $backup->create(self::$dbName1, $expireTime, [
                'versionTime' => "invalidType",
            ]);
        } catch (\InvalidArgumentException $e) {
        }

        $this->assertInstanceOf(\InvalidArgumentException::class, $e);
        $this->assertFalse($backup->exists());

        $e = null;
        try {
            $backup->create(self::$dbName1, $expireTime, [
                'encryptionConfig' => ['kmsKeyName' => 'validKeyName'],
            ]);
        } catch (\InvalidArgumentException $e) {
        }

        $this->assertInstanceOf(\InvalidArgumentException::class, $e);
        $this->assertFalse($backup->exists());
    }

    public function testCancelBackupOperation()
    {
        $expireTime = new \DateTime('+7 hours');
        $backup = self::$instance->backup(self::$backupId2);

        self::$createTime2 = gmdate('"Y-m-d\TH:i:s\Z"');
        $op = $backup->create(self::$dbName2, $expireTime);
        $op->pollUntilComplete();

        self::$deletionQueue->add(function () use ($backup) {
            $backup->delete();
        });

        $op->cancel();

        $this->assertTrue($backup->exists());
    }

    public function testCreateBackupCopy()
    {
        $backup = self::$instance->backup(self::$backupId1);
        $newBackup = self::$instance->backup(self::$copyBackupId);
        $expireTime = new \DateTime('+7 hours');
        $op = $backup->createCopy($newBackup, $expireTime);

        $metadata = null;
        foreach (self::$instance->backupOperations() as $listItem) {
            if ($listItem->name() == $op->name()) {
                $metadata = $listItem->info()['metadata'];
                break;
            }
        }

        $op->pollUntilComplete();

        self::$deletionQueue->add(function () use ($newBackup) {
            $newBackup->delete();
        });

        $this->assertTrue($newBackup->exists());
        $this->assertInstanceOf(Backup::class, $newBackup);
        $this->assertEquals(self::$copyBackupId, DatabaseAdminClient::parseName($newBackup->info()['name'])['backup']);
        $this->assertEquals(self::$dbName1, DatabaseAdminClient::parseName($newBackup->info()['database'])['database']);
        $this->assertEquals($expireTime->format('Y-m-d\TH:i:s.u\Z'), $newBackup->info()['expireTime']);
        $this->assertTrue(is_string($newBackup->info()['createTime']));
        $this->assertEquals(Backup::STATE_READY, $newBackup->state());
        $this->assertTrue($newBackup->info()['sizeBytes'] > 0);
        $this->assertEquals(Type::GOOGLE_DEFAULT_ENCRYPTION, $newBackup->info()['encryptionInfo']['encryptionType']);

        $this->assertNotNull($metadata);
        $this->assertArrayHasKey('progress', $metadata);
        $this->assertArrayHasKey('progressPercent', $metadata['progress']);
        $this->assertArrayHasKey('startTime', $metadata['progress']);
    }

    public function testReloadBackup()
    {
        $backup = self::$instance->backup(self::$backupId1);
        $backup->reload();

        $this->assertEquals(self::$backupId1, DatabaseAdminClient::parseName($backup->info()['name'])['backup']);
        $this->assertEquals(self::$dbName1, DatabaseAdminClient::parseName($backup->info()['database'])['database']);
        $this->assertTrue(is_string($backup->info()['expireTime']));
        $this->assertTrue(is_string($backup->info()['createTime']));
        $this->assertEquals(Backup::STATE_READY, $backup->state());
        $this->assertTrue($backup->info()['sizeBytes'] > 0);
    }

    public function testUpdateExpirationTime()
    {
        $backup = self::$instance->backup(self::$backupId1);

        $currentExpireTime = $backup->info()['expireTime'];

        $newExpireTime = new \DateTime('+10 days');

        $backup->updateExpireTime($newExpireTime);

        $this->assertNotEquals($currentExpireTime, $backup->info()['expireTime']);
        $this->assertEquals($newExpireTime->format('Y-m-d\TH:i:s.u\Z'), $backup->info()['expireTime']);
    }

    public function testUpdateExpirationTimeFailed()
    {
        $backup = self::$instance->backup(self::$backupId1);

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

    public function testListAllBackups()
    {
        $allBackups = iterator_to_array(self::$instance->backups(), false);

        $backupNames = [];
        foreach ($allBackups as $b) {
            $backupNames[] = $b->name();
        }
        $this->assertTrue(count($allBackups) > 0);
        $this->assertContainsOnlyInstancesOf(Backup::class, $allBackups);
    }

    public function testListAllBackupsContainsName()
    {
        $backups = iterator_to_array(self::$instance->backups(['filter' => 'name:' . self::$backupId1]));
        $this->assertTrue(count($backups) == 1);
        $this->assertEquals(self::$backupId1, DatabaseAdminClient::parseName($backups[0]->info()['name'])['backup']);
    }

    public function testListAllBackupsReady()
    {
        $backups = iterator_to_array(self::$instance->backups(['filter'=>'state:READY']));

        $backupNames = [];
        foreach ($backups as $b) {
            $backupNames[] = $b->name();
        }

        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$backupId1), $backupNames));
    }

    public function testListAllBackupsOfDatabase()
    {
        $database = self::$instance->database(self::$dbName1);
        $backups = iterator_to_array($database->backups());

        $this->assertTrue(count($backups) > 0);

        foreach ($backups as $b) {
            $this->assertEquals($database->name(), $b->info()['database']);
        }
    }

    public function testListAllBackupsCreatedAfterTimestamp()
    {
        $filter = sprintf("create_time >= %s", self::$createTime2);

        $backups = iterator_to_array(self::$instance->backups(['filter'=>$filter]));

        $backupNames = [];
        foreach ($backups as $b) {
            $backupNames[] = $b->name();
        }
        $this->assertTrue(count($backupNames) > 0);
        $this->assertFalse(in_array(self::fullyQualifiedBackupName(self::$backupId1), $backupNames));
        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$backupId2), $backupNames));
    }

    public function testListAllBackupsExpireBeforeTimestamp()
    {
        $filter = "expire_time < " . gmdate('"Y-m-d\TH:i:s\Z"', strtotime('+9 hours'));

        $backups = iterator_to_array(self::$instance->backups(['filter'=>$filter]));

        $backupNames = [];
        foreach ($backups as $b) {
            $backupNames[] = $b->name();
        }
        $this->assertTrue(count($backupNames) > 0);
        $this->assertFalse(in_array(self::fullyQualifiedBackupName(self::$backupId1), $backupNames));
        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$backupId2), $backupNames));
    }

    public function testListAllBackupsWithSizeGreaterThanSomeBytes()
    {
        $backup = self::$instance->backup(self::$backupId1);
        $size = $backup->info()['sizeBytes'];
        $filter = "size_bytes > " . $size;

        $backups = iterator_to_array(self::$instance->backups(['filter' => $filter]));

        $backupNames = [];

        foreach ($backups as $b) {
            $backupNames[] = $b->name();
        }
        $this->assertTrue(count($backupNames) > 0);
        $this->assertFalse(in_array(self::fullyQualifiedBackupName(self::$backupId1), $backupNames));
        $this->assertTrue(in_array(self::fullyQualifiedBackupName(self::$backupId2), $backupNames));
    }

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

    public function testListAllBackupOperations()
    {
        $backupOps = iterator_to_array($this::$instance->backupOperations());

        $backupOpsNames = array_map(function ($bOp) {
            return $bOp->name();
        }, $backupOps);

        $this->assertTrue(count($backupOps) > 0);
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $backupOps);
        $this->assertTrue(in_array(self::$backupOperationName, $backupOpsNames));
    }

    public function testDeleteBackup()
    {
        $backupId = uniqid(self::BACKUP_PREFIX);
        $expireTime = new \DateTime('+7 hours');

        $backup = self::$instance->backup($backupId);

        $op = $backup->create(self::$dbName1, $expireTime);
        $op->pollUntilComplete();

        $this->assertTrue($backup->exists());

        $backup->delete();

        $this->assertFalse($backup->exists());
    }

    public function testDeleteNonExistantBackup()
    {
        $backup = self::$instance->backup("does_not_exis");

        $this->assertFalse($backup->exists());

        $backup->delete();
    }

    public function testRestoreInvalidArgument()
    {
        $restoreDbName = uniqid('restored_db_');

        $e = null;
        try {
            $this::$instance->createDatabaseFromBackup(
                $restoreDbName,
                self::fullyQualifiedBackupName(self::$backupId1),
                [
                    'encryptionConfig' => [
                        'kmsKeyName' => 'validKmsKey'
                    ]
                ]
            );
        } catch (\InvalidArgumentException $e) {
        }
        $database = self::$instance->database($restoreDbName);

        $this->assertInstanceOf(\InvalidArgumentException::class, $e);
        $this->assertFalse($database->exists());
    }

    public function testRestoreToNewDatabase()
    {
        $restoreDbName = uniqid('restored_db_');
        $encryptionConfig = [
            'encryptionType' => RestoreDatabaseEncryptionConfig\EncryptionType::GOOGLE_DEFAULT_ENCRYPTION
        ];

        $op = $this::$instance->createDatabaseFromBackup(
            $restoreDbName,
            self::fullyQualifiedBackupName(self::$backupId1),
            ['encryptionConfig' => $encryptionConfig]
        );
        self::$restoreOperationName = $op->name();

        $metadata = null;
        foreach (self::$instance->databaseOperations() as $listItem) {
            if (basename($listItem->info()['metadata']['name']) == $restoreDbName) {
                $metadata = $listItem->info()['metadata'];
                break;
            }
        }

        $op->pollUntilComplete();
        $restoredDb = $this::$instance->database($restoreDbName);

        self::$deletionQueue->add(function () use ($restoredDb) {
            $restoredDb->drop();
        });

        $backup = $this::$instance->backup(self::$backupId1);

        $this->assertTrue($restoredDb->exists());
        $this->assertEquals(
            $backup->info()['versionTime'],
            $restoredDb->info()['restoreInfo']['backupInfo']['versionTime']
        );
        $this->assertEquals(
            new EncryptionConfig(),
            $restoredDb->info()['encryptionConfig']
        );

        $this->assertNotNull($metadata);
        $this->assertArrayHasKey('progress', $metadata);
        $this->assertArrayHasKey('progressPercent', $metadata['progress']);
        $this->assertArrayHasKey('startTime', $metadata['progress']);
    }

    public function testRestoreAppearsInListDatabaseOperations()
    {
        $databaseOps = iterator_to_array($this::$instance->databaseOperations());
        $databaseOpsNames = array_map(function ($dOp) {
            return $dOp->name();
        }, $databaseOps);

        $this->assertTrue(count($databaseOps) > 0);
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $databaseOps);
        $this->assertTrue(in_array(self::$restoreOperationName, $databaseOpsNames));
    }

    public function testRestoreBackupToAnExistingDatabase()
    {
        $existingDb = self::$instance->database(self::$dbName2);
        $this->assertTrue($existingDb->exists());

        $this->expectException(ConflictException::class);

        $this::$instance->createDatabaseFromBackup(
            self::$dbName2,
            self::fullyQualifiedBackupName(self::$backupId1)
        );
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

        for ($id=1; $id <= $number; $id++) {
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
}
