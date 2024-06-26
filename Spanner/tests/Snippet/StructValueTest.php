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
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\StructValue;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-structvalue
 */
class StructValueTest extends SnippetTestCase
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
    private $value;

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
        $this->serializer = $this->getSerializer();
        $this->database = TestHelpers::stub(Database::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE,
            $sessionPool->reveal()
        ], ['operation']);

        $this->value = new StructValue;
    }

    public function testConstructor()
    {
        $fields = [
            [
                'name' => 'foo',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ], [
                'name' => 'foo',
                'type' => [
                    'code' => Database::TYPE_INT64,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ], [
                'name'=> '',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ]
        ];

        $values = [
            'bar',
            2,
            'this field is unnamed'
        ];

        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($values, $fields) {
                $this->assertEquals(
                    $args->getSql(),
                    'SELECT * FROM UNNEST(ARRAY(SELECT @structParam))'
                );
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['params'], ['structParam' => $values]);
                $this->assertEquals(
                    $message['paramTypes'],
                    [
                        'structParam' => [
                            'code' => Database::TYPE_STRUCT,
                            'structType' => [
                                'fields' => $fields
                            ],
                            'typeAnnotation' => 0,
                            'protoTypeFqn' => ''
                        ]
                    ]
                );
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

        $snippet = $this->snippetFromClass(StructValue::class);
        $snippet->replace('$database = $spanner->connect(\'my-instance\', \'my-database\');', '');

        $snippet->addLocal('database', $this->database);

        $res = explode(PHP_EOL, $snippet->invoke()->output());
        $this->assertEquals('foo: bar', $res[0]);
        $this->assertEquals('foo: 2', $res[1]);
        $this->assertEquals('2: this field is unnamed', $res[2]);
    }

    public function testAdd()
    {
        $snippet = $this->snippetFromMethod(StructValue::class, 'add');
        $snippet->addLocal('structValue', $this->value);

        $snippet->invoke();
        $this->assertEquals([
            [
                'name' => 'firstName',
                'value' => 'John'
            ]
        ], $this->value->values());
    }

    public function testAddUnnamed()
    {
        $snippet = $this->snippetFromMethod(StructValue::class, 'addUnnamed');
        $snippet->addLocal('structValue', $this->value);

        $snippet->invoke();
        $this->assertEquals([
            [
                'name' => null,
                'value' => 'John'
            ]
        ], $this->value->values());
    }

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
