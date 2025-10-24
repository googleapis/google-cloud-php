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

namespace Google\Cloud\Spanner\Tests\System;

use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\SpannerClient;

class UniverseDomainTest extends SystemTestCase
{
    use SystemTestCaseTrait;

    private static $instanceId;
    private static $tableName;

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        if (!$keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_KEY_PATH')) {
            self::markTestSkipped('Set GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_KEY_PATH to run system tests');
        }

        $credentials = json_decode(file_get_contents($keyFilePath), true);
        if (!isset($credentials['universe_domain'])) {
            throw new \Exception('The provided key file does not contain universe domain credentials');
        }

        self::$client = new SpannerClient([
            'credentials' => $keyFilePath,
            'projectId' => $credentials['project_id'] ?? null,
            'universeDomain' => $credentials['universe_domain'] ?? null
        ]);

        // Create a unique instance ID for this test
        self::$instanceId = uniqid(self::INSTANCE_NAME);
        self::$dbName = uniqid(self::TESTING_PREFIX);
        self::$tableName = uniqid(self::TESTING_PREFIX);
    }

    /**
     * Test creating an instance with universe domain credentials
     */
    public function testCreateInstanceWithUniverseDomain()
    {
        // Get the first available instance configuration
        $configs = iterator_to_array(self::$client->instanceConfigurations());
        $this->assertNotEmpty($configs, 'No instance configurations found');
        $config = $configs[0];

        // Create the instance
        $op = self::$client->createInstance($config, self::$instanceId, [
            'displayName' => 'Universe Domain Test Instance',
            'nodeCount' => 1
        ]);
        $op->pollUntilComplete();

        $this->assertEquals(LongRunningOperation::STATE_SUCCESS, $op->state(), json_encode($op->error()));

        self::$instance = self::$client->instance(self::$instanceId);
        $info = self::$instance->info();

        $this->assertStringEndsWith('/' . self::$instanceId, $info['name']);
        $this->assertEquals('Universe Domain Test Instance', $info['displayName']);
    }

    /**
     * Test creating a database with universe domain credentials
     *
     * @depends testCreateInstanceWithUniverseDomain
     */
    public function testCreateDatabaseWithUniverseDomain()
    {
        $op = self::$instance->createDatabase(self::$dbName);
        $op->pollUntilComplete();

        self::$database = self::$instance->database(self::$dbName);
        $this->assertStringEndsWith('/' . self::$dbName, self::$database->name());

        // Create a test table
        $op = self::$database->updateDdlBatch([
            'CREATE TABLE ' . self::$tableName . ' (
                id INT64 NOT NULL,
                name STRING(MAX) NOT NULL
            ) PRIMARY KEY (id)'
        ]);
        $op->pollUntilComplete();

        // Verify the table was created
        $result = self::$database->execute(
            "SELECT table_name as name FROM information_schema.tables WHERE table_catalog = '' AND table_schema = ''"
        );
        $tableNames = array_map(fn ($row) => $row['name'], iterator_to_array($result->rows()));

        $this->assertContains(self::$tableName, $tableNames);
    }

    /**
     * Test writing and reading data with universe domain credentials.
     *
     * @depends testCreateDatabaseWithUniverseDomain
     */
    public function testReadWriteWithUniverseDomain()
    {
        // Insert data
        $data = [
            [
                'id' => 1,
                'name' => 'John Doe'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith'
            ]
        ];

        self::$database->transaction(['singleUse' => true])
            ->insertBatch(self::$tableName, $data)
            ->commit();

        // Read data
        $results = self::$database->execute('SELECT * FROM ' . self::$tableName . ' ORDER BY id');
        $rows = iterator_to_array($results);

        $this->assertCount(2, $rows);
        $this->assertEquals(1, $rows[0]['id']);
        $this->assertEquals('John Doe', $rows[0]['name']);
        $this->assertEquals(2, $rows[1]['id']);
        $this->assertEquals('Jane Smith', $rows[1]['name']);
    }

    /**
     * Test updating data with universe domain credentials.
     *
     * @depends testReadWriteWithUniverseDomain
     */
    public function testUpdateWithUniverseDomain()
    {
        // Update data
        self::$database->updateBatch(self::$tableName, [
            [
                'id' => 1,
                'name' => 'John Updated'
            ]
        ]);

        // Read updated data
        $results = self::$database->execute('SELECT * FROM ' . self::$tableName . ' WHERE id = 1');
        $rows = iterator_to_array($results);

        $this->assertCount(1, $rows);
        $this->assertEquals('John Updated', $rows[0]['name']);
    }

    /**
     * Test deleting data with universe domain credentials.
     *
     * @depends testUpdateWithUniverseDomain
     */
    public function testDeleteWithUniverseDomain()
    {
        // Delete data
        $keySet = new KeySet([
            'keys' => [[1]]
        ]);
        self::$database->delete(self::$tableName, $keySet);

        // Verify deletion
        $results = self::$database->execute('SELECT * FROM ' . self::$tableName);
        $rows = iterator_to_array($results);

        $this->assertCount(1, $rows);
        $this->assertEquals(2, $rows[0]['id']);
    }

    /**
     * Test dropping the database with universe domain credentials.
     *
     * @depends testDeleteWithUniverseDomain
     */
    public function testDropDatabaseWithUniverseDomain()
    {
        self::$database->drop();

        // Verify the database was dropped
        $databases = iterator_to_array(self::$instance->databases());
        $dbNames = array_map(fn ($db) => $db->name(), $databases);

        $this->assertNotContains(self::$dbName, $dbNames);
    }

    /**
     * Test deleting the instance with universe domain credentials.
     *
     * @depends testDropDatabaseWithUniverseDomain
     */
    public function testDeleteInstanceWithUniverseDomain()
    {
        self::$instance->delete();

        // Verify the instance was deleted
        $instances = iterator_to_array(self::$client->instances());
        $instanceIds = array_map(fn ($instance) => $instance->name(), $instances);

        $this->assertNotContains(self::$instanceId, $instanceIds);
    }
}
