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

namespace Google\Cloud\PubSub\Tests\Snippet;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Schema;
use Google\Cloud\PubSub\V1\Client\SchemaServiceClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 * @group pubsub-schema
 */
class SchemaTest extends SnippetTestCase
{
    use ProphecyTrait;
    use ApiHelperTrait;

    const PROJECT = 'project';
    const SCHEMA = 'my-schema';

    private $requestHandler;
    private $schema;
    private $client;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $serializer = new Serializer([
            'publish_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'expiration_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [], [], [
            'google.protobuf.Duration' => function ($v) {
                return $this->formatDurationForApi($v);
            }
        ]);
        $this->schema = TestHelpers::stub(Schema::class, [
            $this->requestHandler->reveal(),
            $serializer,
            SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA)
        ], ['requestHandler']);
        $this->client = TestHelpers::stub(PubSubClient::class, [
            [
                'projectId' => self::PROJECT
            ]
        ], ['requestHandler']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Schema::class);
        $snippet->addLocal('client', $this->client);
        $res = $snippet->invoke('schema');
        $this->assertInstanceOf(Schema::class, $res->returnVal());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Schema::class, 'name');
        $snippet->addLocal('schema', $this->schema);
        $this->assertEquals(
            SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
            $snippet->invoke('name')->returnVal()
        );
    }

    public function testDelete()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'deleteSchema',
            Argument::cetera()
        )->shouldBeCalled();
        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(Schema::class, 'delete');
        $snippet->addLocal('schema', $this->schema);
        $snippet->invoke();
    }

    public function testInfo()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'getSchema',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
        ]);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(Schema::class, 'info');
        $snippet->addLocal('schema', $this->schema);
        $this->assertEquals(
            SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
            $snippet->invoke()->output()
        );
    }

    public function testReload()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'getSchema',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
        ]);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(Schema::class, 'reload');
        $snippet->addLocal('schema', $this->schema);
        $this->assertEquals(
            SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
            $snippet->invoke()->output()
        );
    }

    public function testExists()
    {
        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'getSchema',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
        ]);

        $this->schema->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(Schema::class, 'exists');
        $snippet->addLocal('schema', $this->schema);
        $this->assertEquals(
            'Schema exists',
            $snippet->invoke()->output()
        );
    }
}
