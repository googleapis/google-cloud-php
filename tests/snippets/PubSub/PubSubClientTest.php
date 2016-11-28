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

namespace Google\Cloud\Tests\Snippets\PubSub;

use Google\Cloud\Dev\SetStubConnectionTrait;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

class PubSubClientTest extends SnippetTestCase
{
    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = new PubSubClientStub;
        $this->client->setConnection($this->connection->reveal());
    }

    public function testClassExample1()
    {
        $snippet = $this->class(PubSubClient::class, '__construct');
        $res = $snippet->invoke('pubsub');

        $this->assertInstanceOf(PubSubClient::class, $res->return());
    }

    public function testCreateTopic()
    {
        $this->connection->createTopic(Argument::any())->willReturn([
            'name' => 'projects/foo/topics/bar'
        ]);

        $this->client->setConnection($this->connection->reveal());

        $snippet = $this->method(PubSubClient::class, 'createTopic');
        $snippet->addLocal('pubsub', $this->client);

        $res = $snippet->invoke('topic');

        $this->assertInstanceOf(Topic::class, $res->return());
    }
}

class PubSubClientStub extends PubSubClient
{
    use SetStubConnectionTrait;
}
