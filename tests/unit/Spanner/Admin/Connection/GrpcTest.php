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

namespace Google\Cloud\Tests\Unit\Spanner\Admin\Connection;

use Google\Cloud\GrpcRequestWrapper;
use Google\Cloud\GrpcTrait;
use Google\Cloud\Spanner\Connection\Grpc;
use Prophecy\Argument;

/**
 * @group spanneradmin
 */
class GrpcTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTrait;

    const PROJECT = 'my-awesome-project';

    private $requestWrapper;
    private $successMessage;

    public function setUp()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
    }

    /**
     * @dataProvider methodProvider
     */
    public function testCallBasicMethods($method, $args, $expectedArgs)
    {
        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($this->successMessage);

        $grpc = new Grpc();
        $grpc->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($this->successMessage, $grpc->$method($args));
    }

    public function methodProvider()
    {
        $configName = 'test-config';
        $instanceName = 'muh-instance';

        $instanceArgs = [
            'name' => $instanceName,
            'config' => 'foo',
            'displayName' => 'instanceName',
            'nodeCount' => 2,
            'labels' => [],
            'instanceId' => $instanceName,
            'state' => null,
        ];

        $databaseName = 'foo';
        $createStmt = 'CREATE DATABASE foo';
        $extraStmts = ['CREATE TABLE bar'];

        return [
            [
                'listConfigs',
                ['projectId' => self::PROJECT],
                [self::PROJECT, []]
            ],
            [
                'getConfig',
                ['name' => $configName],
                [$configName, []]
            ],
            [
                'listInstances',
                ['projectId' => self::PROJECT],
                [self::PROJECT, []]
            ],
            [
                'getInstance',
                ['name' => $instanceName],
                [$instanceName, []]
            ],
            // [
            //     'createInstance',
            //     $instanceArgs + ['projectId' => self::PROJECT],
            //     [self::PROJECT, $instanceName, Argument::type(\google\spanner\admin\instance\v1\Instance::class), []]
            // ],
            // [
            //     'updateInstance',
            //     ['name' => $value],
            //     [$value, []]
            // ],
            [
                'deleteInstance',
                ['name' => $instanceName],
                [$instanceName, []]
            ],
            [
                'getInstanceIamPolicy',
                ['resource' => $instanceName],
                [$instanceName, []]
            ],
            [
                'setInstanceIamPolicy',
                ['resource' => $instanceName, 'policy' => 'foo'],
                [$instanceName, 'foo', []]
            ],
            [
                'testInstanceIamPermissions',
                ['resource' => $instanceName, 'permissions' => ['foo']],
                [$instanceName, ['foo'], []]
            ],
            [
                'listDatabases',
                ['instance' => $instanceName],
                [$instanceName, []]
            ],
            [
                'createDatabase',
                [
                    'instance' => $instanceName,
                    'createStatement' => $createStmt,
                    'extraStatements' => $extraStmts],
                [$instanceName, $createStmt, $extraStmts, []]
            ],
            [
                'updateDatabase',
                [
                    'name' => $databaseName,
                    'statements' => $extraStmts
                ],
                [$databaseName, $extraStmts, []]
            ],
            [
                'dropDatabase',
                ['name' => $databaseName],
                [$databaseName, []]
            ],
            [
                'getDatabaseDDL',
                ['name' => $databaseName],
                [$databaseName, []]
            ],
            [
                'getDatabaseIamPolicy',
                ['resource' => $databaseName],
                [$databaseName, []]
            ],
            [
                'setDatabaseIamPolicy',
                [
                    'resource' => $databaseName,
                    'policy' => 'foo'
                ],
                [$databaseName, 'foo', []]
            ],
            [
                'testDatabaseIamPermissions',
                [
                    'resource' => $databaseName,
                    'permissions' => 'foo'
                ],
                [$databaseName, 'foo', []]
            ],
        ];
    }
}
