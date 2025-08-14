<?php
/**
 * Copyright 2024 Google Inc.
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

use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance;

/**
 * @group spanner
 */
class GeneratedAdminEmulatorTest extends SpannerTestCase
{
    private static $projectId;

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        self::$projectId = 'emulator-project';
    }

    public function testAdminClientEmulatorSupport()
    {
        if (!getenv('SPANNER_EMULATOR_HOST')) {
            self::markTestSkipped('This test is required to run only in the emulator.');
        }

        $instanceId = uniqid(self::INSTANCE_NAME);
        $databaseId = uniqid(self::TESTING_PREFIX);

        // Create Instance
        $instanceAdminClient = new InstanceAdminClient();
        $parent = InstanceAdminClient::projectName(self::$projectId);
        $instanceName = InstanceAdminClient::instanceName(self::$projectId, $instanceId);
        $configName = $instanceAdminClient->instanceConfigName(self::$projectId, 'regional-us-central1');
        $databaseName = DatabaseAdminClient::databaseName(self::$projectId, $instanceId, $databaseId);
        $instance = (new Instance())
            ->setName($instanceName)
            ->setConfig($configName)
            ->setDisplayName('dispName')
            ->setNodeCount(1);

        $operation = $instanceAdminClient->createInstance(
            (new CreateInstanceRequest())
                ->setParent($parent)
                ->setInstanceId($instanceId)
                ->setInstance($instance)
        );
        $operation->pollUntilComplete();

        $instance = $instanceAdminClient->getInstance(new GetInstanceRequest([
            'name' => $instanceName
        ]));

        $this->assertEquals($instance->getName(), $instanceName);

        // Create Database
        $databaseAdminClient = new DatabaseAdminClient();
        $operation = $databaseAdminClient->createDatabase(
            new CreateDatabaseRequest([
                'parent' => $instanceName,
                'create_statement' => sprintf('CREATE DATABASE `%s`', $databaseId),
                'extra_statements' => [
                    'CREATE TABLE Singers (' .
                    'SingerId     INT64 NOT NULL,' .
                    'FirstName    STRING(1024),' .
                    'LastName     STRING(1024),' .
                    'SingerInfo   BYTES(MAX),' .
                    'FullName     STRING(2048) AS' .
                    '(ARRAY_TO_STRING([FirstName, LastName], " ")) STORED' .
                    ') PRIMARY KEY (SingerId)'
                ]
            ])
        );
        $operation->pollUntilComplete();

        $request = new GetDatabaseRequest(['name' => $databaseName]);
        $database = $databaseAdminClient->getDatabase($request);
        $this->assertEquals($database->getName(), $databaseName);
    }
}
