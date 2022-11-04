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
use Exception;

/**
 * @group bigtable
 * @group bigtabledata
 */
class BigtableTestCase extends SystemTestCase
{
    const INSTANCE_ID_PREFIX = 'php-sys-instance-';
    const CLUSTER_ID_PREFIX = 'php-sys-cluster-';
    const TABLE_ID = 'bigtable-php-sys-test-table';
    const LOCATION_ID = 'us-east1-b';

    protected static $instanceAdminClient;
    protected static $tableAdminClient;
    protected static $table;
    protected static $projectId;
    protected static $instanceId;
    protected static $clusterId;

    public static function set_up_before_class()
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
            self::createInstance();
        }
        self::createTable();
    }

    public static function tear_down_after_class()
    {
        self::deleteTable();
        if (!self::isEmulatorUsed()) {
            self::deleteInstance();
        }
    }

    private static function createInstance()
    {
        $formattedParent = self::$instanceAdminClient->projectName(self::$projectId);
        $instance = new Instance();
        $instance->setDisplayName(self::$instanceId);
        $cluster = new Cluster();
        $cluster->setLocation(
            self::$instanceAdminClient->locationName(
                self::$projectId,
                self::LOCATION_ID
            )
        );
        $cluster->setServeNodes(3);
        $clusters = [
            self::$clusterId => $cluster
        ];
        $operationResponse = self::$instanceAdminClient->createInstance(
            $formattedParent,
            self::$instanceId,
            $instance,
            $clusters
        );
        $operationResponse->pollUntilComplete();
        if (!$operationResponse->operationSucceeded()) {
            throw new Exception('error creating instance', -1);
        }
    }

    private static function deleteInstance()
    {
        $formattedName = self::$instanceAdminClient->instanceName(
            self::$projectId,
            self::$instanceId
        );
        self::$instanceAdminClient->deleteInstance($formattedName);
    }

    private static function createTable()
    {
        $formattedParent = self::$tableAdminClient->instanceName(
            self::$projectId,
            self::$instanceId
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
            self::TABLE_ID,
            $table
        );
    }

    private static function deleteTable()
    {
        $formattedName = self::$tableAdminClient->tableName(
            self::$projectId,
            self::$instanceId,
            self::TABLE_ID
        );
        self::$tableAdminClient->deleteTable($formattedName);
    }
}
