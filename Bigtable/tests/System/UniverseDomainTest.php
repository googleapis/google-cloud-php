<?php
/**
 * Copyright 2025 Google Inc.
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
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\CreateInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\CreateTableRequest;
use Google\Cloud\Bigtable\Admin\V2\DeleteInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\DeleteTableRequest;
use Google\Cloud\Bigtable\Admin\V2\GetInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\GetTableRequest;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Core\Testing\System\SystemTestCase;

class UniverseDomainTest extends SystemTestCase
{
    private static $instanceAdminClient;
    private static $tableAdminClient;
    private static $bigtableClient;
    private static $tableId;
    private static $instanceId;
    private static $clusterId;
    private static $projectId;
    private static $locationId;

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        if (!$keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_KEY_PATH')) {
            self::markTestSkipped('Set GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_KEY_PATH to run system tests');
        }

        // This can be found for your universe by running "gcloud compute zones list"
        if (!$locationId = getenv('GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_LOCATION')) {
            self::markTestSkipped('Set GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_LOCATION to run system tests');
        }

        if (!$credentials = json_decode(file_get_contents($keyFilePath), true)) {
            throw new \Exception('unable to decode key file');
        }
        if (!isset($credentials['universe_domain'])) {
            throw new \Exception('The provided key file does not contain universe domain credentials');
        }

        self::$projectId = $credentials['project_id'];
        self::$instanceId = uniqid(BigtableTestCase::INSTANCE_ID_PREFIX);
        self::$clusterId = uniqid(BigtableTestCase::CLUSTER_ID_PREFIX);
        self::$tableId = BigtableTestCase::TABLE_ID;
        self::$locationId = $locationId;

        self::$instanceAdminClient = new BigtableInstanceAdminClient([
            'credentials' => $keyFilePath,
            'projectId' => self::$projectId,
            'universeDomain' => $credentials['universe_domain'],
        ]);
        self::$tableAdminClient = new BigtableTableAdminClient([
            'credentials' => $keyFilePath,
            'projectId' => self::$projectId,
            'universeDomain' => $credentials['universe_domain'],
        ]);
        self::$bigtableClient = new BigtableClient([
            'credentials' => $keyFilePath,
            'projectId' => self::$projectId,
            'universeDomain' => $credentials['universe_domain'],
        ]);
    }

    /**
     * Test creating a Bigtable instance with universe domain credentials
     */
    public function testCreateInstanceWithUniverseDomain()
    {
        $formattedParent = self::$instanceAdminClient->projectName(self::$projectId);
        $instance = new Instance();
        $instance->setDisplayName(self::$instanceId);

        $cluster = new Cluster();
        $cluster->setLocation(
            self::$instanceAdminClient->locationName(
                self::$projectId,
                self::$locationId
            )
        );
        $cluster->setServeNodes(1);

        $request = new CreateInstanceRequest([
            'parent' => $formattedParent,
            'instance_id' => self::$instanceId,
            'instance' => $instance,
            'clusters' => [
                self::$clusterId => $cluster
            ]
        ]);

        $operationResponse = self::$instanceAdminClient->createInstance($request);
        $operationResponse->pollUntilComplete();

        $this->assertTrue($operationResponse->operationSucceeded(), 'Failed to create instance');

        // Get the result to verify the instance was created
        $result = $operationResponse->getResult();
        $this->assertNotNull($result);
        $this->assertStringEndsWith('/' . self::$instanceId, $result->getName());
    }

    /**
     * Test creating a table with universe domain credentials
     *
     * @depends testCreateInstanceWithUniverseDomain
     */
    public function testCreateTableWithUniverseDomain()
    {
        $instanceName = self::$instanceAdminClient->instanceName(self::$projectId, self::$instanceId);
        $tableName = self::$tableAdminClient->tableName(self::$projectId, self::$instanceId, self::$tableId);

        // Create table with column families
        $table = new Table();
        $columnFamily = new ColumnFamily();
        $table->setColumnFamilies([
            'cf1' => $columnFamily
        ]);

        $createTableRequest = (new CreateTableRequest())
            ->setParent($instanceName)
            ->setTableId(self::$tableId)
            ->setTable($table);

        $response = self::$tableAdminClient->createTable($createTableRequest);

        $this->assertNotNull($response);
        $this->assertEquals($tableName, $response->getName());
    }

    /**
     * Test writing and reading data with universe domain credentials.
     *
     * @depends testCreateTableWithUniverseDomain
     */
    public function testListsObjectsWithUniverseDomain()
    {
        $table = self::$bigtableClient->table(self::$instanceId, self::$tableId);

        $greetings = ['Hello World!', 'Hello Cloud Bigtable!', 'Hello PHP!'];
        $entries = [];
        $columnFamilyId = 'cf1';
        $column = 'greeting';
        foreach ($greetings as $i => $value) {
            $rowKey = sprintf('greeting%s', $i);
            $rowMutation = new Mutations();
            $rowMutation->upsert($columnFamilyId, $column, $value, time() * 1000 * 1000);
            $entries[$rowKey] = $rowMutation;
        }
        $table->mutateRows($entries);

        $key = 'greeting0';

        // Only retrieve the most recent version of the cell.
        $rowFilter = (new RowFilter())->setCellsPerColumnLimitFilter(1);

        $column = 'greeting';
        $columnFamilyId = 'cf1';

        $row = $table->readRow($key, [
            'filter' => $rowFilter
        ]);

        $columnFamilyId = 'cf1';
        $column = 'greeting';

        $partialRows = iterator_to_array($table->readRows([])->readAll());
        $this->assertCount(3, $partialRows);
        $this->assertEquals('Hello World!', $partialRows['greeting0'][$columnFamilyId][$column][0]['value']);
        $this->assertEquals('Hello Cloud Bigtable!', $partialRows['greeting1'][$columnFamilyId][$column][0]['value']);
        $this->assertEquals('Hello PHP!', $partialRows['greeting2'][$columnFamilyId][$column][0]['value']);
    }
    /**
     * Test deleting a table with universe domain credentials.
     *
     * @depends testListsObjectsWithUniverseDomain
     */
    public function testDeleteTableWithUniverseDomain()
    {
        $tableName = self::$tableAdminClient->tableName(self::$projectId, self::$instanceId, self::$tableId);

        $deleteTableRequest = (new DeleteTableRequest())
            ->setName($tableName);

        self::$tableAdminClient->deleteTable($deleteTableRequest);

        // Verify the table was deleted by trying to get it (should throw an exception)
        $getTableRequest = (new GetTableRequest())
            ->setName($tableName);

        try {
            self::$tableAdminClient->getTable($getTableRequest);
            $this->fail('Expected exception was not thrown');
        } catch (ApiException $e) {
            $this->assertEquals('NOT_FOUND', $e->getStatus());
        }
    }

    /**
     * Test deleting a Bigtable instance with universe domain credentials.
     *
     * @depends testDeleteTableWithUniverseDomain
     */
    public function testDeleteInstanceWithUniverseDomain()
    {
        $instanceName = self::$instanceAdminClient->instanceName(self::$projectId, self::$instanceId);

        $deleteRequest = new DeleteInstanceRequest([
            'name' => $instanceName
        ]);

        self::$instanceAdminClient->deleteInstance($deleteRequest);

        // Verify the instance was deleted by trying to get it (should throw an exception)
        $getRequest = new GetInstanceRequest([
            'name' => $instanceName
        ]);
        try {
            self::$instanceAdminClient->getInstance($getRequest);
            $this->fail('Expected exception was not thrown');
        } catch (ApiException $e) {
            $this->assertEquals('NOT_FOUND', $e->getStatus());
        }
    }
}
