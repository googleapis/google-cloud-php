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

use Google\Cloud\Bigtable\Admin\V2\Backup;
use Google\Protobuf\Timestamp;

/**
 * @group bigtable
 * @group bigatableBackup
 */
class BackupTests extends BigtableTestCase
{
    private static $destinationClusterId;
    private static $destinationProjectId;
    private static $backupId;
    private static $backupName;
    private static $copyBackupId;
    private static $expireTime;

    public const DESTINATION_LOCATION_ID = 'us-central1-b';

    public static function set_up_before_class()
    {
        parent::set_up_before_class();
        self::$destinationClusterId = uniqid(self::CLUSTER_ID_PREFIX);
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);
        self::$destinationProjectId = $keyFileData['project_id'];
        self::$backupId = uniqid('backup');
        self::$copyBackupId = 'copy' . self::$backupId;
        self::$expireTime = new Timestamp();
        self::$expireTime->setSeconds(time() + 86400);
        self::$backupName = self::$tableAdminClient->backupName(
            self::$projectId,
            self::$instanceId,
            self::$clusterId,
            self::$backupId
        );
    }

    public function testCreateBackup()
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
    }

    /**
     * @depends testCreateBackup
     */
    public function testCopyBackup()
    {
        // Test for same project, different cluster region
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

        // Test for different project
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

    public static function tear_down_after_class()
    {
        self::$tableAdminClient->deleteBackup(self::$backupName);

        $backupName = self::$tableAdminClient->backupName(
            self::$projectId,
            self::$instanceId,
            self::$destinationClusterId,
            self::$copyBackupId
        );
        self::$tableAdminClient->deleteBackup($backupName);

        $backupName = self::$tableAdminClient->backupName(
            self::$destinationProjectId,
            self::$instanceId,
            self::$clusterId,
            self::$copyBackupId
        );
        self::$tableAdminClient->deleteBackup($backupName);

        if (!self::isEmulatorUsed()) {
            self::deleteInstance(self::$destinationProjectId, self::$instanceId);
        }

        parent::tear_down_after_class();
    }
}
