<?php
/**
 * Copyright 2022 Google Inc.
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

use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\Backup;
use Google\Protobuf\Timestamp;

/**
 * @group bigtable
 * @group bigatable-backup
 */
class BackupTests extends BigtableTestCase
{
    private static $destinationClusterId;
    private static $destinationProjectId;
    private static $backupId;
    private static $backupName;
    private static $copyBackupId;
    private static $expireTime;

    const DESTINATION_LOCATION_ID = 'us-central1-b';
    const SECONDS_IN_A_DAY = 86400;


    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$destinationClusterId = uniqid(self::CLUSTER_ID_PREFIX);
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);
        self::$destinationProjectId = $keyFileData['project_id'];
        self::$backupId = uniqid('backup');
        self::$copyBackupId = 'copy' . self::$backupId;
        self::$expireTime = new Timestamp();
        self::$expireTime->setSeconds(
            time() + self::SECONDS_IN_A_DAY * 20
        );
        self::$backupName = self::$tableAdminClient->backupName(
            self::$projectId,
            self::$instanceId,
            self::$clusterId,
            self::$backupId
        );
    }

    public static function tearDownAfterClass(): void
    {
        self::deleteBackupIfExists(self::$backupName);

        $backupName = self::$tableAdminClient->backupName(
            self::$projectId,
            self::$instanceId,
            self::$destinationClusterId,
            self::$copyBackupId
        );
        self::deleteBackupIfExists($backupName);

        $backupName = self::$tableAdminClient->backupName(
            self::$destinationProjectId,
            self::$instanceId,
            self::$clusterId,
            self::$copyBackupId
        );
        self::deleteBackupIfExists($backupName);

        if (!self::isEmulatorUsed()) {
            try {
                $formattedInstanceName = self::$instanceAdminClient->instanceName(
                    self::$destinationProjectId,
                    self::$instanceId
                );
                self::$instanceAdminClient->getInstance($formattedInstanceName);
                self::deleteInstance(self::$destinationProjectId, self::$instanceId);
            } catch (\Throwable $th) {
            }
        }

        parent::tearDownAfterClass();
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
        $backup->setExpireTime(self::$expireTime);

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
        self::assertStringContainsString(self::$backupName, $result->getName());
        self::assertEquals("", $result->getSourceBackup());
    }

    /**
     * @depends testCreateBackup
     */
    public function testCopyBackupShouldWorkForSameProjectDifferentClusterRegion(): void
    {
        self::createCluster(
            self::$projectId,
            self::$instanceId,
            self::DESTINATION_LOCATION_ID,
            self::$destinationClusterId
        );

        $parent = self::$tableAdminClient->clusterName(
            self::$projectId,
            self::$instanceId,
            self::$destinationClusterId
        );

        self::$expireTime->setSeconds(time() + self::SECONDS_IN_A_DAY * 10);

        $operationResponse = self::$tableAdminClient->copyBackup(
            $parent,
            self::$copyBackupId,
            self::$backupName,
            self::$expireTime
        );
        $operationResponse->pollUntilComplete();
        $result = $operationResponse->getResult();

        $expectedResponse = self::$tableAdminClient->backupName(
            self::$projectId,
            self::$instanceId,
            self::$destinationClusterId,
            self::$copyBackupId
        );
        self::assertStringContainsString($expectedResponse, $result->getName());
        self::assertStringContainsString(self::$backupName, $result->getSourceBackup());
    }

    /**
     * @depends testCreateBackup
     */
    public function testCopyBackupShouldWorkForDifferentProject(): void
    {
        self::createInstance(
            self::$destinationProjectId,
            self::$instanceId,
            self::DESTINATION_LOCATION_ID,
            self::$clusterId
        );

        $parent = self::$tableAdminClient->clusterName(
            self::$destinationProjectId,
            self::$instanceId,
            self::$clusterId
        );
        $operationResponse = self::$tableAdminClient->copyBackup(
            $parent,
            self::$copyBackupId,
            self::$backupName,
            self::$expireTime
        );
        $operationResponse->pollUntilComplete();
        $result = $operationResponse->getResult();
        $expectedResponse = self::$tableAdminClient->backupName(
            self::$destinationProjectId,
            self::$instanceId,
            self::$clusterId,
            self::$copyBackupId
        );
        self::assertStringContainsString($expectedResponse, $result->getName());
        self::assertStringContainsString(self::$backupName, $result->getSourceBackup());
    }

    /**
     * @depends testCreateBackup
     */
    public function testCopyBackupShouldThrowForCopiedBackup(): void
    {
        $exceptionMessage = '';
        $parent = self::$tableAdminClient->clusterName(
            self::$destinationProjectId,
            self::$instanceId,
            self::$clusterId
        );
        try {
            $copiedBackupName = self::$tableAdminClient->backupName(
                self::$projectId,
                self::$instanceId,
                self::$destinationClusterId,
                self::$copyBackupId
            );
            $operationResponse = self::$tableAdminClient->copyBackup(
                $parent,
                self::$copyBackupId,
                $copiedBackupName,
                self::$expireTime
            );
            $operationResponse->pollUntilComplete();
        } catch (ApiException $th) {
            $exceptionMessage = $th->getMessage();
        }
        self::assertStringContainsString(
            "copying a copied backup is not supported",
            $exceptionMessage
        );
    }

    private static function deleteBackupIfExists(string $backupName): void
    {
        try {
            self::$tableAdminClient->getBackup($backupName);
            self::$tableAdminClient->deleteBackup($backupName);
        } catch (ApiException $th) {
        }
    }
}
