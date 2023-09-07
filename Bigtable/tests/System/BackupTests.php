<?php
/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Bigtable\Tests\System;

use Exception;
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\Backup;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\StorageType;
use Google\Protobuf\Timestamp;

/**
 * @group bigtable
 * @group bigatable-backup
 */
class BackupTests extends BigtableTestCase
{
    private const DESTINATION_LOCATION_ID = 'us-central1-b';
    private const SECONDS_IN_A_DAY = 86400;

    /**
     * @var string Backup id of the backup created for the table.
     */
    private static $backupId;

    /**
     * @var string Formatted backup name of the backup created for the table.
     */
    private static $backupName;

    /**
     * @var string Copy Backup id of the copy backup.
     */
    private static $copyBackupId;

    /**
     * @var string Cluster id where copy of a backup would reside.
     */
    private static $copyBackupClusterId;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$backupId = uniqid('backup');
        self::$copyBackupId = 'copy' . self::$backupId;
        self::$backupName = self::$tableAdminClient->backupName(
            self::$projectId,
            self::$instanceId,
            self::$clusterId,
            self::$backupId
        );
        self::$copyBackupClusterId = uniqid(self::CLUSTER_ID_PREFIX);
    }

    public static function tearDownAfterClass(): void
    {
        // Delete the base backup
        self::deleteBackupIfExists(self::$tableAdminClient, self::$backupName);

        // Delete copy backup created in test
        $backupName = self::$tableAdminClient->backupName(
            self::$projectId,
            self::$instanceId,
            self::$copyBackupClusterId,
            self::$copyBackupId
        );
        self::deleteBackupIfExists(self::$tableAdminClient, $backupName);
    }

    public function testCreateBackup(): void
    {
        $backup = new Backup();

        $sourceTableName = self::$tableAdminClient->tableName(
            self::$projectId,
            self::$instanceId,
            self::TABLE_ID
        );
        $backup->setSourceTable($sourceTableName);
        // Set 20 days expiration time
        $backup->setExpireTime(new Timestamp([
            'seconds' => time() + self::SECONDS_IN_A_DAY * 20
        ]));

        $parentName = self::$instanceAdminClient->clusterName(
            self::$projectId,
            self::$instanceId,
            self::$clusterId
        );
        $operationResponse = self::$tableAdminClient->createBackup(
            $parentName,
            self::$backupId,
            $backup
        );
        $operationResponse->pollUntilComplete();
        $result = $operationResponse->getResult();
        $this->assertStringContainsString(self::$backupName, $result->getName());
        $this->assertEquals("", $result->getSourceBackup());
    }

    /**
     * @depends testCreateBackup
     */
    public function testCopyBackupSameProjectDifferentCluster(): void
    {
        // Cluster creation
        $clusterName = $this->createCustomCluster(
            self::$instanceAdminClient,
            self::$copyBackupClusterId,
            self::DESTINATION_LOCATION_ID
        );

        $ex = null;
        try {
            $operationResponse = self::$tableAdminClient->copyBackup(
                $clusterName,
                self::$copyBackupId,
                self::$backupName,
                // Setting 10 days expiration time
                new Timestamp(['seconds' => time() + self::SECONDS_IN_A_DAY * 10])
            );
            $operationResponse->pollUntilComplete();
            $copyBackup = $operationResponse->getResult();

            $expectedResponse = self::$tableAdminClient->backupName(
                self::$projectId,
                self::$instanceId,
                self::$copyBackupClusterId,
                self::$copyBackupId
            );
            self::assertStringContainsString($expectedResponse, $copyBackup->getName());
            self::assertStringContainsString(self::$backupName, $copyBackup->getSourceBackup());
        } catch (Exception $th) {
            $ex = $th->getMessage();
            $this->fail($ex);
        }
    }

    /**
     * @depends testCreateBackup
     */
    public function testCopyBackupInDifferentProject(): void
    {
        // Create secondary client of a different project id
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);
        $instanceId = uniqid(self::INSTANCE_ID_PREFIX);
        $clusterId = uniqid(self::CLUSTER_ID_PREFIX);
        $projectId = $keyFileData['project_id'];
        $copyBackupId = uniqid('copybackup-');

        $instanceClient = new BigtableInstanceAdminClient([
            'credentials' => $keyFilePath
        ]);
        $tableClient = new BigtableTableAdminClient([
            'credentials' => $keyFilePath
        ]);
        $projectName = $instanceClient->projectName($projectId);
        $clusterName = $instanceClient->clusterName($projectId, $instanceId, $clusterId);
        $copyBackupName = $tableClient->backupName(
            $projectId,
            $instanceId,
            $clusterId,
            $copyBackupId
        );

        // Create instance with destination instance client
        $instance = new Instance();
        $instance->setDisplayName($instanceId);
        $cluster = new Cluster();
        $cluster->setLocation($instanceClient->locationName($projectId, self::LOCATION_ID));
        $cluster->setServeNodes(3);
        $clusters = [$clusterId => $cluster];

        $ex = null;
        try {
            $operationResponse = $instanceClient->createInstance(
                $projectName,
                $instanceId,
                $instance,
                $clusters
            );
            $operationResponse->pollUntilComplete();
            if (!$operationResponse->operationSucceeded()) {
                $this->fail("Secondary project's instance creation failed");
            }

            $operationResponse = $tableClient->copyBackup(
                $clusterName,
                $copyBackupId,
                self::$backupName,
                new Timestamp(['seconds' => time() + self::SECONDS_IN_A_DAY * 10])
            );
            $operationResponse->pollUntilComplete();
            $result = $operationResponse->getResult();

            $this->assertStringContainsString($copyBackupName, $result->getName());
            $this->assertStringContainsString(self::$backupName, $result->getSourceBackup());
        } catch (Exception $th) {
            $ex = $th->getMessage();
        }

        // Cleanup
        self::deleteBackupIfExists($tableClient, $copyBackupName);
        if (!self::isEmulatorUsed()) {
            try {
                $instanceName = $instanceClient->instanceName($projectId, $instanceId);
                $instanceClient->getInstance($instanceName);
                $instanceClient->deleteInstance($instanceName);
            } catch (Exception $th) {
                printf($th->getMessage() . PHP_EOL);
            }
        }

        if ($ex != null) {
            $this->fail($ex);
        }
    }

    /**
     * @depends testCopyBackupSameProjectDifferentCluster
     */
    public function testCopyBackupShouldThrowForCopiedBackup(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage("copying a copied backup is not supported");

        $copyBackupName = self::$tableAdminClient->backupName(
            self::$projectId,
            self::$instanceId,
            self::$copyBackupClusterId,
            self::$copyBackupId
        );
        $operationResponse = self::$tableAdminClient->copyBackup(
            self::$instanceAdminClient->clusterName(
                self::$projectId,
                self::$instanceId,
                self::$clusterId
            ),
            self::$copyBackupId,
            $copyBackupName,
            new Timestamp(['seconds' => time() + self::SECONDS_IN_A_DAY * 10])
        );
        $operationResponse->pollUntilComplete();
    }

    /**
     * Helper method to create a cluster with the given specification and
     * returns the cluster's formatter name
     */
    private function createCustomCluster(
        BigtableInstanceAdminClient $instanceClient,
        string $clusterId,
        string $location
    ) {
        $instanceName = $instanceClient->instanceName(
            self::$projectId,
            self::$instanceId
        );
        $clusterName = $instanceClient->clusterName(
            self::$projectId,
            self::$instanceId,
            $clusterId
        );

        $storage_type = StorageType::SSD;
        $cluster = new Cluster();
        $cluster->setServeNodes(3);
        $cluster->setDefaultStorageType($storage_type);
        $cluster->setLocation(
            self::$instanceAdminClient->locationName(
                self::$projectId,
                $location
            )
        );
        $operationResponse = self::$instanceAdminClient->createCluster(
            $instanceName,
            $clusterId,
            $cluster
        );
        $operationResponse->pollUntilComplete();
        if (!$operationResponse->operationSucceeded()) {
            $this->fail('Cluster creation failed');
        }
        return $clusterName;
    }

    private static function deleteBackupIfExists(
        BigtableTableAdminClient $client,
        string $backupName
    ): void {
        try {
            $client->getBackup($backupName);
            $client->deleteBackup($backupName);
        } catch (ApiException $th) {
            printf($th->getMessage() . PHP_EOL);
        }
    }
}
