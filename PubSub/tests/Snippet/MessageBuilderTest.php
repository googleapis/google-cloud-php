<?php
/**
 * Copyright 2020 Google LLC
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
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\MessageBuilder;
use Google\Cloud\PubSub\PubSubClient;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class MessageBuilderTest extends SnippetTestCase
{
    private $builder;

    public function setUp()
    {
        $this->builder = new MessageBuilder;
    }

    public function testClass()
    {
        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->publishMessage(Argument::any())->willReturn([]);
        $connection->getTopic(Argument::any())
            ->willReturn([
                'topic' => '',
            ]);

        $client = TestHelpers::stub(PubSubClient::class);
        $client->___setProperty('connection', $connection->reveal());

        $snippet = $this->snippetFromClass(MessageBuilder::class);
        $snippet->replace('$client = new PubSubClient();', '');
        $snippet->addLocal('client', $client);
        $snippet->addLocal('topicId', 'test');

        $res = $snippet->invoke('builder');
        $this->assertEquals([
            'data' => 'hello friend!',
            'attributes' => [
                'from' => 'Bob',
                'to' => 'Jane'
            ]
        ], $res->returnVal()->build()->toArray());
    }

    public function testSetData()
    {
        $snippet = $this->snippetFromMethod(MessageBuilder::class, 'setData');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('builder');
        $this->assertEquals('Hello friend!', $res->returnVal()->build()->toArray()['data']);
    }

    public function testSetAttributes()
    {
        $snippet = $this->snippetFromMethod(MessageBuilder::class, 'setAttributes');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('builder');
        $this->assertEquals(['from' => 'Bob'], $res->returnVal()->setData('foo')->build()->toArray()['attributes']);
    }

    public function testAddAttribute()
    {
        $snippet = $this->snippetFromMethod(MessageBuilder::class, 'addAttribute');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('builder');
        $this->assertEquals(['to' => 'Jane'], $res->returnVal()->setData('foo')->build()->toArray()['attributes']);
    }

    public function testSetOrderingKey()
    {
        $snippet = $this->snippetFromMethod(MessageBuilder::class, 'setOrderingKey');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('builder');
        $this->assertEquals('order', $res->returnVal()->setData('foo')->build()->toArray()['orderingKey']);
    }

    public function testBuild()
    {
        $snippet = $this->snippetFromMethod(MessageBuilder::class, 'build');
        $snippet->addLocal('builder', $this->builder->setData('hello'));
        $res = $snippet->invoke('message');
        $this->assertInstanceOf(Message::class, $res->returnVal());
    }
}
