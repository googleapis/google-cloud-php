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

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Subscription;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class MessageTest extends SnippetTestCase
{
    const SUBSCRIPTION = 'projects/my-awesome-project/subscriptions/my-new-subscription';

    private $msg;
    private $metadata;
    private $message;

    public function setUp()
    {
        $this->msg = [
            'data' => 'hello world',
            'messageId' => '1234',
            'publishTime' => (new \DateTime())->format('c'),
            'attributes' => [
                'browser-name' => 'Google Chrome'
            ]
        ];

        $subscription = $this->prophesize(Subscription::class);
        $subscription->name()->willReturn(self::SUBSCRIPTION);

        $this->metadata = [
            'ackId' => '4321',
            'subscription' => $subscription->reveal()
        ];

        $this->message = new Message($this->msg, $this->metadata);
    }

    public function testClass()
    {
        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->pull(Argument::withEntry('subscription', self::SUBSCRIPTION))
            ->shouldBeCalled()
            ->willReturn([
                'receivedMessages' => [
                    [
                        'message' => [
                            'data' => base64_encode('hello world')
                        ]
                    ]
                ]
            ]);

        $snippet = $this->snippetFromClass(Message::class);
        $snippet->addLocal('connectionStub', $connection->reveal());
        $snippet->insertAfterLine(2, '$reflection = new \ReflectionClass($pubsub);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($pubsub, $connectionStub);
            $property->setAccessible(false);
            $property = $reflection->getProperty(\'encode\');
            $property->setAccessible(true);
            $property->setValue($pubsub, \'false\');
            $property->setAccessible(false);'
        );

        $res = $snippet->invoke('messages');
        $this->assertContainsOnlyInstancesOf(Message::class, $res->returnVal());
        $this->assertEquals('hello world', $res->output());
    }

    public function testData()
    {
        $snippet = $this->snippetFromMethod(Message::class, 'data');
        $snippet->addLocal('message', $this->message);

        $res = $snippet->invoke();
        $this->assertEquals($this->msg['data'], $res->output());
    }

    public function testAttribute()
    {
        $snippet = $this->snippetFromMethod(Message::class, 'attribute');
        $snippet->addLocal('message', $this->message);

        $res = $snippet->invoke();
        $this->assertEquals($this->msg['attributes']['browser-name'], $res->output());
    }

    public function testAttributes()
    {
        $snippet = $this->snippetFromMethod(Message::class, 'attributes');
        $snippet->addLocal('message', $this->message);

        $res = $snippet->invoke('attributes');
        $this->assertEquals($this->msg['attributes'], $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(Message::class, 'id');
        $snippet->addLocal('message', $this->message);

        $res = $snippet->invoke();
        $this->assertEquals($this->msg['messageId'], $res->output());
    }

    public function testPublishTime()
    {
        $snippet = $this->snippetFromMethod(Message::class, 'publishTime');
        $snippet->addLocal('message', $this->message);

        $res = $snippet->invoke('time');
        $this->assertEquals($this->msg['publishTime'], $res->returnVal()->format('c'));
    }

    public function testAckId()
    {
        $snippet = $this->snippetFromMethod(Message::class, 'ackId');
        $snippet->addLocal('message', $this->message);

        $res = $snippet->invoke();
        $this->assertEquals($this->metadata['ackId'], $res->output());
    }

    public function testSubscription()
    {
        $snippet = $this->snippetFromMethod(Message::class, 'subscription');
        $snippet->addLocal('message', $this->message);

        $res = $snippet->invoke();
        $this->assertEquals('Subscription Name: '. self::SUBSCRIPTION, $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Message::class, 'info');
        $snippet->addLocal('message', $this->message);

        $res = $snippet->invoke('info');
        $this->assertTrue(is_array($res->returnVal()));
    }
}
