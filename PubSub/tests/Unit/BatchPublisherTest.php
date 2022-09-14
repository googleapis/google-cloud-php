<?php
/**
 * Copyright 2017 Google Inc.
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

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group pubsub
 * @group pubsub-batch
 */
class BatchPublisherTest extends TestCase
{
    const TOPIC_NAME = 'my-topic';

    /**
     * @dataProvider messages
     */
    public function testPublish($message, $expected = null)
    {
        $expected = $expected ?: $message;

        $runner = $this->prophesize(BatchRunner::class);
        $runner->submitItem('pubsub-topic-' . self::TOPIC_NAME, $expected)
            ->willReturn(true)
            ->shouldBeCalledTimes(1);
        $runner->registerJob(
            Argument::type('string'),
            Argument::type('array'),
            Argument::type('array')
        )
            ->willReturn(true)
            ->shouldBeCalledTimes(1);

        $publisher = new BatchPublisher(self::TOPIC_NAME, [
            'batchRunner' => $runner->reveal()
        ]);

        $publisher->publish($message);
    }

    public function messages()
    {
        $simple = ['data' => 'Hello, world!', 'attributes' => ['foo' => 'bar']];
        return [
            [$simple],
            [new Message($simple), $simple]
        ];
    }

    public function testGetCallback()
    {
        $publisher = new TestBatchPublisher(self::TOPIC_NAME, ['clientConfig' => ['projectId' => 'example_project']]);
        $callbackArray = $publisher->getCallbackArray();

        $this->assertInstanceOf(BatchPublisher::class, $callbackArray[0]);
        $this->assertEquals('publishDeferred', $callbackArray[1]);
    }

    public function testPublishDeferred()
    {
        $client = TestHelpers::stub(PubSubClient::class, [], [
            'encode', 'connection'
        ]);
        $client->___setProperty('encode', false);

        $publisher = TestHelpers::stub(BatchPublisher::class, [
            self::TOPIC_NAME,
        ], ['client', 'topics']);

        $connection = $this->prophesize(ConnectionInterface::class);

        $messages = [
            [
                'data' => 'foo',
                'orderingKey' => 'a',
            ], [
                'data' => 'bar',
                'orderingKey' => 'b',
            ], [
                'data' => 'bat',
                'orderingKey' => 'a'
            ], [
                'data' => 'baz',
            ]
        ];

        $withOrderingKey = function ($key) use ($messages) {
            $messages = array_filter($messages, function ($message) use ($key) {
                if ($key === '') {
                    return !isset($message['orderingKey']);
                }

                return isset($message['orderingKey']) && $message['orderingKey'] === $key;
            });

            return Argument::withEntry('messages', array_values($messages));
        };

        $connection->getTopic(Argument::any())
            ->willReturn([
                'name' => self::TOPIC_NAME,
            ]);

        $connection->publishMessage($withOrderingKey('a'))
            ->will(function ($args) use ($withOrderingKey) {
                $this->publishMessage($withOrderingKey('b'))
                    ->will(function ($args) use ($withOrderingKey) {
                        $this->publishMessage($withOrderingKey(''))
                            ->will(function ($args) {
                                return array_fill(0, count($args[0]['messages']), 1);
                            });

                        return array_fill(0, count($args[0]['messages']), 1);
                    });

                return array_fill(0, count($args[0]['messages']), 1);
            });

        $client->___setProperty('connection', $connection->reveal());
        $publisher->___setProperty('client', $client);
        $res = $publisher->publishDeferred($messages);
        $this->assertEquals(array_fill(0, count($messages), 1), $res);
    }
}

//@codingStandardsIgnoreStart
class TestBatchPublisher extends BatchPublisher
{
    public function getCallbackArray()
    {
        return $this->getCallback();
    }
}
//@codingStandardsIgnoreEnd
