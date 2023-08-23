<?php
/**
 * Copyright 2018 Google LLC.
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

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient as TableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Bigtable\Admin\V2\StorageType;
use Exception;

/**
 * @group bigtable
 * @group bigtabledata
 */
class BigtableTestCase extends SystemTestCase
{
    public const INSTANCE_ID_PREFIX = 'php-sys-instance-';
    public const CLUSTER_ID_PREFIX = 'php-sys-cluster-';
    public const TABLE_ID = 'bigtable-php-sys-test-table';
    public const LOCATION_ID = 'us-east1-b';

    protected static $instanceAdminClient;
    protected static $tableAdminClient;
    protected static $table;
    protected static $projectId;
    protected static $instanceId;
    protected static $clusterId;

    public static function setUpBeforeClass(): void
    {
        self::setUsingEmulator(getenv('BIGTABLE_EMULATOR_HOST'));
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        self::$instanceAdminClient = new InstanceAdminClient([
            'credentials' => $keyFilePath
        ]);
        self::$tableAdminClient = new TableAdminClient([
            'credentials' => $keyFilePath
        ]);
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);
        self::$projectId = $keyFileData['project_id'];
        self::$instanceId = uniqid(self::INSTANCE_ID_PREFIX);
        self::$clusterId = uniqid(self::CLUSTER_ID_PREFIX);
        self::$table = (new BigtableClient([
            'projectId' => self::$projectId,
            'credentials' => $keyFilePath
        ]))->table(self::$instanceId, self::TABLE_ID);
        if (!self::isEmulatorUsed()) {
            self::createInstance(
                self::$projectId,
                self::$instanceId,
                self::LOCATION_ID,
                self::$clusterId
            );
        }
        self::createTable(self::$projectId, self::$instanceId, self::TABLE_ID);
    }

    public static function tearDownAfterClass(): void
    {
        self::deleteTable(self::$projectId, self::$instanceId, self::TABLE_ID);
        if (!self::isEmulatorUsed()) {
            self::deleteInstance(self::$projectId, self::$instanceId);
        }
    }

    protected static function createInstance(
        string $projectId,
        string $instanceId,
        string $locationId,
        string $clusterId
    ) {
        $formattedParent = self::$instanceAdminClient->projectName($projectId);
        $instance = new Instance();
        $instance->setDisplayName($instanceId);
        $cluster = new Cluster();
        $cluster->setLocation(
            self::$instanceAdminClient->locationName(
                $projectId,
                $locationId
            )
        );
        $cluster->setServeNodes(3);
        $clusters = [
            $clusterId => $cluster
        ];
        $operationResponse = self::$instanceAdminClient->createInstance(
            $formattedParent,
            $instanceId,
            $instance,
            $clusters
        );
        $operationResponse->pollUntilComplete();
        if (!$operationResponse->operationSucceeded()) {
            throw new Exception('error creating instance', -1);
        }
    }

    protected static function createCluster(
        string $projectId,
        string $instanceId,
        string $locationId,
        string $clusterId
    ) {
        $instanceName = self::$instanceAdminClient->instanceName(
            $projectId,
            $instanceId
        );
        $clusterName = self::$instanceAdminClient->clusterName(
            $projectId,
            $instanceId,
            $clusterId
        );

        $storage_type = StorageType::SSD;
        $serve_nodes = 3;

        $cluster = new Cluster();
        $cluster->setServeNodes($serve_nodes);
        $cluster->setDefaultStorageType($storage_type);
        $cluster->setLocation(
            self::$instanceAdminClient->locationName(
                $projectId,
                $locationId
            )
        );
        $operationResponse = self::$instanceAdminClient->createCluster(
            $instanceName,
            $clusterId,
            $cluster
        );
        $operationResponse->pollUntilComplete();
        if (!$operationResponse->operationSucceeded()) {
            throw new Exception('error creating cluster', -1);
        }
    }

    protected static function deleteInstance(string $projectId, string $instanceId)
    {
        $formattedName = self::$instanceAdminClient->instanceName(
            $projectId,
            $instanceId
        );
        self::$instanceAdminClient->deleteInstance($formattedName);
    }

    protected static function createTable(
        string $projectId,
        string $instanceId,
        string $tableId
    ) {
        $formattedParent = self::$tableAdminClient->instanceName(
            $projectId,
            $instanceId
        );
        $table = new Table();
        $columnFamily = new ColumnFamily();
        $table->setColumnFamilies([
            'cf0' => $columnFamily,
            'cf1' => $columnFamily,
            'cf2' => $columnFamily,
            'cf3' => $columnFamily,
            'cf4' => $columnFamily,
            'cf5' => $columnFamily,
            'cf6' => $columnFamily,
            'cf7' => $columnFamily,
            'cf8' => $columnFamily,
            'cf9' => $columnFamily
        ]);
        self::$tableAdminClient->createTable(
            $formattedParent,
            $tableId,
            $table
        );
    }

    protected static function deleteTable(
        string $projectId,
        string $instanceId,
        string $tableId
    ) {
        $formattedName = self::$tableAdminClient->tableName(
            $projectId,
            $instanceId,
            $tableId
        );
        self::$tableAdminClient->deleteTable($formattedName);
    }
}
