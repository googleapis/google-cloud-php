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

namespace Google\Cloud\Tests\Unit\PubSub;

use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\IncomingMessageTrait;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Subscription;

/**
 * @group pubsub
 */
class IncomingMessageTraitTest extends \PHPUnit_Framework_TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new IncomingMessageTraitStub($this->prophesize(ConnectionInterface::class)->reveal());
    }

    public function testMessageFactory()
    {
        $message = $this->stub->call([
            'message' => [
                'data' => 'hello world'
            ]
        ]);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals('hello world', $message->data());
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testInvalidMessage()
    {
        $this->stub->call([]);
    }

    public function testDecodeMessage()
    {
        $message = $this->stub->call([
            'message' => [
                'data' => base64_encode('hello world')
            ]
        ], true);

        $this->assertEquals('hello world', $message->data());
    }

    public function testMessageWithSubscription()
    {
        $message = $this->stub->call([
            'message' => [
                'data' => base64_encode('hello world')
            ],
            'subscription' => 'projects/project-id/subscriptions/foo'
        ], true);

        $this->assertInstanceOf(Subscription::class, $message->subscription());
        $this->assertEquals('projects/project-id/subscriptions/foo', $message->subscription()->name());
    }
}

class IncomingMessageTraitStub
{
    use IncomingMessageTrait;

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function call($message, $encode = false)
    {
        return $this->messageFactory($message, $this->connection, 'project-id', $encode);
    }
}
