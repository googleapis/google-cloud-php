<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\SpannerOperationRefreshTrait;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\ArrayType;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\StructType;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-arraytype
 */
class ArrayTypeTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use SpannerOperationRefreshTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';

    private $connection;
    private $database;
    private $type;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));

        $session = $this->prophesize(Session::class);

        $sessionPool = $this->prophesize(SessionPoolInterface::class);
        $sessionPool->acquire(Argument::any())
            ->willReturn($session->reveal());
        $sessionPool->setDatabase(Argument::any())
            ->willReturn(null);

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->database = \Google\Cloud\Core\Testing\TestHelpers::stub(Database::class, [
            $this->connection->reveal(),
            $instance->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::DATABASE,
            $sessionPool->reveal()
        ], ['operation']);
    }

    public function testConstructor()
    {
        $field = [
            'code' => Database::TYPE_ARRAY,
            'arrayElementType' => [
                'code' => Database::TYPE_STRING
            ]
        ];

        $values = [
            'foo', 'bar', null
        ];

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('sql', 'SELECT @arrayParam as arrayValue'),
            Argument::withEntry('params', [
                'arrayParam' => $values
            ]),
            Argument::withEntry('paramTypes', [
                'arrayParam' => $field
            ])
        ))->shouldBeCalled()->willReturn($this->resultGenerator([
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'arrayValue',
                            'type' => $field
                        ]
                    ]
                ]
            ],
            'values' => [$values]
        ]));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromClass(ArrayType::class);
        $snippet->replace('$database = $spanner->connect(\'my-instance\', \'my-database\');', '');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('firstValue');
        $this->assertEquals('foo', $res->returnVal());
    }

    public function testArrayTypeStruct()
    {
        $snippet = $this->snippetFromClass(ArrayType::class, 1);
        $res = $snippet->invoke('arrayType')->returnVal();
        $this->assertEquals(Database::TYPE_STRUCT, $res->type());
        $this->assertInstanceOf(StructType::class, $res->structType());
    }

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
