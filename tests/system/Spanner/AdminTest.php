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

namespace Google\Cloud\Tests\System\Spanner;

use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;

/**
 * @group spanner
 */
class AdminTest extends SpannerTestCase
{
    public function testInstance()
    {
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
        $op = $instance->update([
            'displayName' => $displayName
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
        $op->pollUntilComplete();

        $instance = $client->instance(self::INSTANCE_NAME);
        $this->assertEquals($displayName, $instance->info()['displayName']);
    }

    public function testDatabase()
    {
        $instance = self::$instance;

        $dbName = uniqid(self::TESTING_PREFIX);
        $op = $instance->createDatabase($dbName);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
        $db = $op->pollUntilComplete();
        $this->assertInstanceOf(Database::class, $db);

        self::$deletionQueue[] = function() use ($db) { $db->drop(); };

        $databases = $instance->databases();
        $database = array_filter(iterator_to_array($databases), function ($db) use ($dbName) {
            return $this->parseDbName($db->name()) === $dbName;
        });

        $this->assertInstanceOf(Database::class, current($database));

        $this->assertTrue($db->exists());

        $stmt = "CREATE TABLE Ids (\n" .
            "  id INT64 NOT NULL,\n" .
            ") PRIMARY KEY(id)";

        $op = $db->updateDdl($stmt);
        $op->pollUntilComplete();

        $this->assertEquals($db->ddl()[0], $stmt);
    }

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
        return InstanceAdminClient::parseInstanceFromInstanceName($name);
    }

    private function parseDbName($name)
    {
        return DatabaseAdminClient::parseDatabaseFromDatabaseName($name);
    }
}
