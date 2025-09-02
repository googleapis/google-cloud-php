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

use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\ArrayType;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\StructType;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\Session;
use Google\Protobuf\Timestamp;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @group spanner
 * @group spanner-arraytype
 */
class ArrayTypeTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ApiHelperTrait;
    use ResultGeneratorTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const SESSION = 'my-session';

    private $database;
    private $type;
    private $spannerClient;
    private $serializer;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->get()->willReturn((new Session([
            'name' => SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION),
            'multiplexed' => true,
            'create_time' => new Timestamp(['seconds' => time()]),
        ]))->serializeToString());

        $cacheKey = sprintf('cache-session-pool.%s.%s.%s.%s', self::PROJECT, self::INSTANCE, self::DATABASE, '');
        $cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $cacheItemPool->getItem($cacheKey)
            ->willReturn($cacheItem->reveal());

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->serializer = new Serializer();

        $this->database = new Database(
            $this->spannerClient->reveal(),
            $this->prophesize(DatabaseAdminClient::class)->reveal(),
            $this->serializer,
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE,
            ['cacheItemPool' => $cacheItemPool->reveal()],
        );
    }

    public function testConstructor()
    {
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals('SELECT @arrayParam as arrayValue', $request->getSql());
                $this->assertEquals(
                    ['arrayParam' => ['foo', 'bar', null]],
                    $message['params']
                );
                $this->assertEquals(
                    Database::TYPE_STRING,
                    $message['paramTypes']['arrayParam']['arrayElementType']['code'],
                );
                $this->assertEquals(
                    Database::TYPE_ARRAY,
                    $message['paramTypes']['arrayParam']['code'],
                );
                return true;
            }),
            Argument::type('array')
        )->shouldBeCalled()->willReturn(
            $this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
                    'metadata' => [
                        'rowType' => [
                            'fields' => [
                                [
                                    'name' => 'arrayValue',
                                    'type' => [
                                        'code' => Database::TYPE_ARRAY,
                                        'arrayElementType' => [
                                            'code' => Database::TYPE_STRING
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'values' => [
                        [
                            'listValue' => [
                                'values' => [
                                    ['stringValue' => 'foo'],
                                    ['stringValue' => 'bar'],
                                    ['nullValue' => 0]
                                ]
                            ]
                        ]
                    ]
                ]
            )->serializeToJsonString()])
        );

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
}
