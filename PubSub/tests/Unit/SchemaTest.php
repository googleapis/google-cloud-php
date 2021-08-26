<?php
/**
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\PubSub\Tests\Unit;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Schema;
use PHPUnit\Framework\TestCase;

/**
 * @group pubsub
 * @group pubsub-schema
 */
class SchemaTest extends TestCase
{
    const NAME = "projects/example/schemas/my-schema";

    private $connection;
    private $schema;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->schema = TestHelpers::stub(Schema::class, [
            $this->connection->reveal(),
            self::NAME,
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->schema->name());
    }

    public function testDelete()
    {
        $this->connection->deleteSchema([
            'name' => self::NAME,
        ])->willReturn('foo');

        $this->schema->___setProperty('connection', $this->connection->reveal());

        // the service call returns void, but let's test that we're returning whatever it sends.
        $this->assertEquals('foo', $this->schema->delete());
    }

    public function testInfo()
    {
        $this->connection->getSchema([
            'name' => self::NAME,
            'view' => 'FULL',
        ])->shouldBeCalledOnce()->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals('bar', $this->schema->info()['foo']);

        // test that the result is stored and a 2nd service call is not made.
        $this->schema->info();
    }

    public function testReload()
    {
        $this->connection->getSchema([
            'name' => self::NAME,
            'view' => 'FULL',
        ])->shouldBeCalledTimes(2)->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals('bar', $this->schema->reload()['foo']);

        // test that the result is not stored and a 2nd service call is made.
        $this->schema->reload();
    }

    public function testExists()
    {
        $this->connection->getSchema([
            'name' => self::NAME,
            'view' => 'FULL',
        ])->shouldBeCalledOnce()->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->schema->exists());
    }

    public function testExistsReturnsFalse()
    {
        $this->connection->getSchema([
            'name' => self::NAME,
            'view' => 'FULL',
        ])->shouldBeCalledOnce()->willThrow(NotFoundException::class);

        $this->schema->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->schema->exists());
    }
}
