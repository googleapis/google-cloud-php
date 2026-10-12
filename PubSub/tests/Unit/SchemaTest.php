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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\Schema;
use Google\Cloud\PubSub\V1\Client\SchemaServiceClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 * @group pubsub-schema
 */
class SchemaTest extends TestCase
{
    use ProphecyTrait;

    const NAME = "projects/example/schemas/my-schema";

    private $requestHandler;
    private $schema;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->schema = TestHelpers::stub(Schema::class, [
            $this->requestHandler->reveal(),
            new Serializer(),
            self::NAME,
        ], ['requestHandler']);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->schema->name());
    }

    public function testDelete()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'deleteSchema',
            Argument::cetera()
        )->willReturn('foo');

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        // the service call returns void, but let's test that we're returning whatever it sends.
        $this->assertEquals('foo', $this->schema->delete());
    }

    public function testInfo()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'getSchema',
            Argument::cetera()
        )->shouldBeCalledOnce()->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertEquals('bar', $this->schema->info()['foo']);

        // test that the result is stored and a 2nd service call is not made.
        $this->schema->info();
    }

    public function testReload()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'getSchema',
            Argument::cetera()
        )->shouldBeCalledTimes(2)->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertEquals('bar', $this->schema->reload()['foo']);

        // test that the result is not stored and a 2nd service call is made.
        $this->schema->reload();
    }

    public function testExists()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'getSchema',
            Argument::cetera()
        )->shouldBeCalledOnce()->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertTrue($this->schema->exists());
    }

    public function testExistsReturnsFalse()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'getSchema',
            Argument::cetera()
        )->shouldBeCalledOnce()->willThrow(NotFoundException::class);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertFalse($this->schema->exists());
    }

    public function testlistRevisions()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'listSchemaRevisions',
            Argument::cetera()
        )->shouldBeCalledOnce()
        ->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertEquals('bar', $this->schema->listRevisions()['foo']);
    }

    public function testCommit()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'commitSchema',
            Argument::cetera()
        )->shouldBeCalledOnce()
        ->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertEquals('bar', $this->schema->commit('test', 'AVRO')['foo']);
    }

    public function testDeleteRevision()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'deleteSchemaRevision',
            Argument::cetera()
        )->shouldBeCalledOnce()
        ->willReturn(['foo' => 'bar']);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertEquals('bar', $this->schema->deleteRevision('1234567')['foo']);
    }
}
