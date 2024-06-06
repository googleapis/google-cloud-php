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

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\ArrayType;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\StructType;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-structtype
 */
class StructTypeTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use OperationRefreshTrait;
    use ProphecyTrait;
    use RequestHandlingTestTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';

    private $requestHandler;
    private $serializer;
    private $database;
    private $type;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        $session = $this->prophesize(Session::class);
        $session->info()
            ->willReturn([
                'databaseName' => 'database'
            ]);
        $session->name()
            ->willReturn('database');
        $session->setExpiration(Argument::any())
            ->willReturn(100);

        $sessionPool = $this->prophesize(SessionPoolInterface::class);
        $sessionPool->acquire(Argument::any())
            ->willReturn($session->reveal());
        $sessionPool->setDatabase(Argument::any())
            ->willReturn(null);

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();;
        $this->database = TestHelpers::stub(Database::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            $instance->reveal(),
            [],
            self::PROJECT,
            self::DATABASE,
            $sessionPool->reveal()
        ], ['operation', 'requestHandler', 'serializer']);

        $this->type = new StructType;
    }

    public function testExecuteStruct()
    {
        $fields = [
            [
                'name' => 'firstName',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    "typeAnnotation" => 0,
                    "protoTypeFqn" => ""
                ]
            ], [
                'name' => 'lastName',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    "typeAnnotation" => 0,
                    "protoTypeFqn" => ""
                ]
            ]
        ];

        $values = [
            'John',
            'Testuser'
        ];

        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($fields, $values) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals('SELECT @userStruct.firstName, @userStruct.lastName', $args->getSql());
                $this->assertEquals($message['params']['userStruct'], $values);
                $this->assertEquals($message['paramTypes']['userStruct']['structType']['fields'], $fields);
                return true;
            },
            $this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => $fields
                    ]
                ],
                'values' => $values
            ])
        );
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromClass(StructType::class);
        $snippet->replace('$database = $spanner->connect(\'my-instance\', \'my-database\');', '');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('fullName');
        $this->assertEquals('John Testuser', $res->returnVal());
    }

    public function testConstruct()
    {
        $snippet = $this->snippetFromMethod(StructType::class, '__construct');
        $snippet->invoke();
    }

    public function testAdd()
    {
        $snippet = $this->snippetFromMethod(StructType::class, 'add');
        $snippet->addLocal('structType', $this->type);
        $snippet->addUse(Database::class);

        $snippet->invoke();

        $this->assertEquals([
            [
                'name' => 'firstName',
                'type' => Database::TYPE_STRING,
                'child' => null
            ]
        ], $this->type->fields());
    }

    public function testAddComplex()
    {
        $snippet = $this->snippetFromMethod(StructType::class, 'add', 1);
        $snippet->addLocal('structType', $this->type);

        $snippet->invoke();

        $this->assertEquals([
            [
                'name' => 'customer',
                'type' => Database::TYPE_STRUCT,
                'child' => (new StructType)
                    ->add('name', Database::TYPE_STRING)
                    ->add('phone', Database::TYPE_STRING)
                    ->add('email', Database::TYPE_STRING)
                    ->add('lastOrderDate', Database::TYPE_DATE)
                    ->add('orderIds', new ArrayType(Database::TYPE_INT64))
            ]
        ], $this->type->fields());
    }

    public function testAddUnnamed()
    {
        $snippet = $this->snippetFromMethod(StructType::class, 'addUnnamed');
        $snippet->addLocal('structType', $this->type);
        $snippet->addUse(Database::class);

        $snippet->invoke();

        $this->assertEquals([
            [
                'name' => null,
                'type' => Database::TYPE_STRING,
                'child' => null
            ]
        ], $this->type->fields());
    }

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
