<?php
/**
 * Copyright 2016 Google Inc.
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

use Google\Cloud\Core\Exception\FailedPreconditionException;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig\Type;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;

/**
 * @group spanner
 */
class AdminTest extends SpannerTestCase
{
    /**
     * covers 121
     */
    public function testInstance()
    {
        $this->skipEmulatorTests();

        $client = self::$client;

        $instances = $client->instances();
        $instance = array_filter(iterator_to_array($instances), function ($instance) {
            return $this->parseName($instance->name()) === self::INSTANCE_NAME;
        });

        $this->assertInstanceOf(Instance::class, current($instance));

        $instance = self::$instance;
        $this->assertTrue($instance->exists());
        $this->assertEquals($instance->name(), $instance->info()['name']);
        $this->assertEquals($instance->name(), $instance->reload()['name']);

        $this->assertEquals(Instance::STATE_READY, $instance->state());

        $displayName = uniqid(self::TESTING_PREFIX);
        $processingUnits = 500;
        $op = $instance->update([
            'displayName' => $displayName,
            'processingUnits' => $processingUnits,
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
        $op->pollUntilComplete();

        $instance = $client->instance(self::INSTANCE_NAME);
        $this->assertEquals($displayName, $instance->info()['displayName']);
        $this->assertEquals($processingUnits, $instance->info()['processingUnits']);

        $requestedFieldNames = ['name', 'state'];
        $expectedInfo = [
            'endpointUris' => [],
            'labels' => [],
            'name' => $instance->name(),
            'displayName' => '',
            'nodeCount' => 0,
            'processingUnits' => 0,
            'state' => Instance::STATE_READY,
            'config' => ''
        ];
        $info = $instance->reload(['fieldMask' => $requestedFieldNames]);
        $this->assertEquals($expectedInfo, $info);
    }

    /**
     * covers 123
     */
    public function testDatabase()
    {
        $instance = self::$instance;

        $dbName = uniqid(self::TESTING_PREFIX);
        $op = $instance->createDatabase($dbName);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
        $db = $op->pollUntilComplete();
        $this->assertInstanceOf(Database::class, $db);

        self::$deletionQueue->add(function () use ($db) {
            $db->drop();
        });

        $databases = $instance->databases();
        $database = array_filter(iterator_to_array($databases), function ($db) use ($dbName) {
            return $this->parseDbName($db->name()) === $dbName;
        });

        $this->assertInstanceOf(Database::class, current($database));
        $this->assertTrue($db->exists());

        $expectedDatabaseDialect = DatabaseDialect::GOOGLE_STANDARD_SQL;

        // TODO: Remove this, when the emulator supports PGSQL
        if ((bool) getenv("SPANNER_EMULATOR_HOST")) {
            $expectedDatabaseDialect = DatabaseDialect::DATABASE_DIALECT_UNSPECIFIED;
        }

        $this->assertEquals($db->info()['databaseDialect'], $expectedDatabaseDialect);

        $stmt = "CREATE TABLE Ids (\n" .
            "  id INT64 NOT NULL,\n" .
            ") PRIMARY KEY(id)";

        $op = $db->updateDdl($stmt);
        $op->pollUntilComplete();

        $this->assertEquals($db->ddl()[0], $stmt);
    }

    public function testDatabaseDropProtection()
    {
        $this->skipEmulatorTests();
        $instance = self::$instance;

        $dbName = uniqid(self::TESTING_PREFIX);
        $op = $instance->createDatabase($dbName);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
        $db = $op->pollUntilComplete();
        $this->assertInstanceOf(Database::class, $db);

        $info = $db->reload();
        $this->assertFalse($info['enableDropProtection']);

        $op = $db->updateDatabase(['enableDropProtection' => true]);
        $op->pollUntilComplete();
        $info = $db->reload();
        $this->assertTrue($info['enableDropProtection']);

        // delete database should throw
        $isDropThrows = false;
        try {
            $db->drop();
        } catch (FailedPreconditionException $ex) {
            $isDropThrows = true;
            $this->assertStringContainsStringIgnoringCase(
                'enable_drop_protection',
                $ex->getMessage()
            );
        }
        $this->assertTrue($isDropThrows);
        $this->assertTrue($db->exists());

        // disable drop databases config
        $op = $db->updateDatabase(['enableDropProtection' => false]);
        $op->pollUntilComplete();
        $info = $db->reload();
        $this->assertFalse($info['enableDropProtection']);

        // drop should succeed
        $db->drop();
        $this->assertFalse($db->exists());
    }

    public function testCreateCustomerManagedInstanceConfiguration()
    {
        $this->skipEmulatorTests();

        $client = self::$client;

        // Custom instance configuration IDs must start with 'custom' and may not contain any underscores.
        $customConfigId = uniqid('custom-' . str_replace('_', '-', self::TESTING_PREFIX));

        // Find the first instance configuration that has at least one optional replica. This indicates that it is a
        // Google Managed multi-region config that can be used as the base config for a customer managed configuration.
        $configurations = iterator_to_array($client->instanceConfigurations());
        foreach ($configurations as $configuration) {
            if (!empty($configuration->info()['optionalReplicas'])) {
                $baseConfig = $configuration;
                break;
            }
        }
        if (empty($baseConfig)) {
            $this->fail('No suitable base configuration found to create a custom instance config');
        }

        $customConfiguration = $client->instanceConfiguration($customConfigId);
        // Add all base config replicas + optional replicas, and set a random replica as the default leader.
        $replicas = $baseConfig->info()['replicas'] + $baseConfig->info()['optionalReplicas'];
        $replicas[array_rand($replicas)]['defaultLeaderLocation'] = true;
        $op = $customConfiguration->create($baseConfig, $replicas);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
        $op->pollUntilComplete();

        $this->assertTrue($customConfiguration->exists());

        // Queue the custom config for deletion after the test run has finished.
        self::$deletionQueue->add(function () use ($customConfiguration) {
            $customConfiguration->delete();
        });

        return $customConfigId;
    }

    /**
     * @depends testCreateCustomerManagedInstanceConfiguration
     */
    public function testListCustomerManagedInstanceConfigurations($customConfigId)
    {
        $this->skipEmulatorTests();

        $client = self::$client;

        // Verify that we have one customer-managed instance configuration with the generated name.
        $configurations = iterator_to_array($client->instanceConfigurations());
        $customConfigurations = array_filter(
            $configurations,
            function ($configuration) use ($customConfigId) {
                return $configuration->info()['configType'] === Type::USER_MANAGED
                    && $this->parseInstanceConfigName($configuration->name()) === $customConfigId;
            }
        );
        $this->assertEquals(1, sizeof($customConfigurations));
        $customConfiguration = current($customConfigurations);
        $this->assertEquals($customConfigId, $customConfiguration->info()['displayName']);

        return $customConfigId;
    }

    /**
     * @depends testListCustomerManagedInstanceConfigurations
     */
    public function testUpdateCustomerManagedInstanceConfiguration($customConfigId)
    {
        $this->skipEmulatorTests();

        $client = self::$client;

        $customConfiguration = $client->instanceConfiguration($customConfigId);
        // Update the display name and labels of the custom instance configuration.
        $op = $customConfiguration->update([
            'displayName' => 'New display name',
            'labels' => ['label1' => 'foo', 'label2' => 'bar']
        ]);
        $op->pollUntilComplete();
        $customConfiguration->reload();
        $this->assertEquals('New display name', $customConfiguration->info()['displayName']);
        $this->assertEquals(['label1' => 'foo', 'label2' => 'bar'], $customConfiguration->info()['labels']);

        return $customConfigId;
    }

    /**
     * @depends testCreateCustomerManagedInstanceConfiguration
     */
    public function testListCustomerManagedInstanceConfigurationOperations()
    {
        $this->skipEmulatorTests();

        $client = self::$client;

        // List instance config operations and verify that at least one operation is present.
        $operations = iterator_to_array($client->instanceConfigOperations());
        $this->assertNotEmpty($operations);
    }

    public function testPgDatabase()
    {
        $this->skipEmulatorTests();

        $instance = self::$instance;

        $dbName = uniqid(self::TESTING_PREFIX);
        $op = $instance->createDatabase($dbName, [
            'databaseDialect' => DatabaseDialect::POSTGRESQL
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
        $db = $op->pollUntilComplete();
        $this->assertInstanceOf(Database::class, $db);

        self::$deletionQueue->add(function () use ($db) {
            $db->drop();
        });

        $databases = $instance->databases();
        $database = array_filter(iterator_to_array($databases), function ($db) use ($dbName) {
            return $this->parseDbName($db->name()) === $dbName;
        });

        $this->assertInstanceOf(Database::class, current($database));
        $this->assertTrue($db->exists());
        $this->assertEquals($db->info()['databaseDialect'], DatabaseDialect::POSTGRESQL);
    }

    /**
     * covers 120
     */
    public function testConfigurations()
    {
        $client = self::$client;

        $configurations = $client->instanceConfigurations();

        $this->assertContainsOnly(InstanceConfiguration::class, $configurations);

        $res = iterator_to_array($configurations);
        $firstConfigName = $res[0]->name();

        $config = $client->instanceConfiguration($firstConfigName);

        $this->assertInstanceOf(InstanceConfiguration::class, $config);
        $this->assertEquals($firstConfigName, $config->name());

        $this->assertTrue($config->exists());
        $this->assertEquals($config->name(), $config->info()['name']);
        $this->assertEquals($config->name(), $config->reload()['name']);
    }

    private function parseName($name)
    {
        return InstanceAdminClient::parseName($name)['instance'];
    }

    private function parseDbName($name)
    {
        return DatabaseAdminClient::parseName($name)['database'];
    }

    private function parseInstanceConfigName($name)
    {
        return InstanceAdminClient::parseName($name)['instance_config'];
    }
}
