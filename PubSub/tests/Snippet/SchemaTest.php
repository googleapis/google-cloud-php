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

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Schema;
use Google\Cloud\PubSub\V1\SchemaServiceClient;
use Prophecy\Argument;

/**
 * @group pubsub
 * @group pubsub-schema
 */
class SchemaTest extends SnippetTestCase
{
    const PROJECT = 'project';
    const SCHEMA = 'my-schema';

    private $connection;
    private $schema;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->schema = TestHelpers::stub(Schema::class, [
            $this->connection->reveal(),
            SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA)
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Schema::class);
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
        $this->connection->deleteSchema(Argument::any())->shouldBeCalled();
        $this->schema->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Schema::class, 'delete');
        $snippet->addLocal('schema', $this->schema);
        $snippet->invoke();
    }

    public function testInfo()
    {
        $this->connection->getSchema(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
            ]);

        $this->schema->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Schema::class, 'info');
        $snippet->addLocal('schema', $this->schema);
        $this->assertEquals(
            SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
            $snippet->invoke()->output()
        );
    }

    public function testReload()
    {
        $this->connection->getSchema(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
            ]);

        $this->schema->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Schema::class, 'reload');
        $snippet->addLocal('schema', $this->schema);
        $this->assertEquals(
            SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
            $snippet->invoke()->output()
        );
    }

    public function testExists()
    {
        $this->connection->getSchema(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => SchemaServiceClient::schemaName(self::PROJECT, self::SCHEMA),
            ]);

        $this->schema->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Schema::class, 'exists');
        $snippet->addLocal('schema', $this->schema);
        $this->assertEquals(
            'Schema exists',
            $snippet->invoke()->output()
        );
    }
}
