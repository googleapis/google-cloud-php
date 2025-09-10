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
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\StructValue;
use Google\Cloud\Spanner\V1\Session;
use Google\Protobuf\Timestamp;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @group spanner
 * @group spanner-structvalue
 */
class StructValueTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';

    private $spannerClient;
    private $serializer;
    private $database;
    private $value;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient = $this->prophesize(SpannerClient::class);

        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->get()->willReturn((new Session([
            'name' => SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, 'my-session'),
            'multiplexed' => true,
            'create_time' => new Timestamp(['seconds' => time()]),
        ]))->serializeToString());

        $cacheKey = sprintf('cache-session-pool.%s.%s.%s.%s', self::PROJECT, self::INSTANCE, self::DATABASE, '');
        $cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $cacheItemPool->getItem($cacheKey)
            ->willReturn($cacheItem->reveal());

        $this->serializer = new Serializer();
        $this->database = new Database(
            $this->spannerClient->reveal(),
            $this->prophesize(DatabaseAdminClient::class)->reveal(),
            $this->serializer,
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE,
            ['cacheItemPool' => $cacheItemPool->reveal()]
        );

        $this->value = new StructValue();
    }

    public function testConstructor()
    {
        $rows = [
            [
                'name' => 'foo',
                'type' => Database::TYPE_STRING,
                'value' => 'bar',
            ], [
                'name' => 'foo',
                'type' => Database::TYPE_INT64,
                'value' => 2,
            ], [
                'name' => '',
                'type' => Database::TYPE_STRING,
                'value' => 'this field is unnamed',
            ]
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($args) use ($rows) {
                $this->assertEquals(
                    $args->getSql(),
                    'SELECT * FROM UNNEST(ARRAY(SELECT @structParam))'
                );
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['params']['structParam'],
                    array_map(fn ($row) => $row['value'], $rows)
                );
                $this->assertEquals(
                    $message['paramTypes']['structParam']['structType']['fields'][0]['name'],
                    $rows[0]['name']
                );
                $this->assertEquals(
                    $message['paramTypes']['structParam']['structType']['fields'][1]['name'],
                    $rows[1]['name']
                );
                $this->assertEquals(
                    $message['paramTypes']['structParam']['structType']['fields'][2]['name'],
                    $rows[2]['name']
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($rows));

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
}
