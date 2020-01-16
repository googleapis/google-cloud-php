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
use Google\Cloud\PubSub\OrderingKeyBatchJob;
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
    public function testPublish($message, $expected = null, $orderingKey = null)
    {
        $expected = $expected ?: $message;

        $jobId = sprintf(OrderingKeyBatchJob::ID_TEMPLATE, self::TOPIC_NAME, $orderingKey ?: 'default');

        $runner = $this->prophesize(BatchRunner::class);
        $runner->submitItem($jobId, $expected)
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
        $daemonRunning = getenv("IS_BATCH_DAEMON_RUNNING");
        putenv("IS_BATCH_DAEMON_RUNNING=");
        $client = TestHelpers::stub(PubSubClient::class, [], [
            'encode', 'connection'
        ]);
        $client->___setProperty('encode', false);

        $publisher = TestHelpers::stub(BatchPublisher::class, [
            self::TOPIC_NAME,
            [
                'batchOptions' => [
                    'callPeriod' => 100
                ]
            ]
        ], ['client', 'jobs', 'topics']);

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

        $messageActualCount = 0;
        $batchCount = 0;
        $connection->publishMessage(Argument::that(function ($args) use (
            &$messageActualCount,
            &$batchCount,
            $messages
        ) {
            $batchCount = count($args['messages']);
            if (empty($args['messages'])) {
                return false;
            }

            $firstMessage = current($args['messages']);
            $orderingKey = isset($firstMessage['orderingKey'])
                ? $firstMessage['orderingKey']
                : null;

            $expectedCount = count(array_filter($args['messages'], function ($message) use ($orderingKey) {
                return $orderingKey
                    ? isset($message['orderingKey']) && $message['orderingKey'] === $orderingKey
                    : !isset($message['orderingKey']);
            }));

            $messageActualCount = $messageActualCount + $batchCount;
            return $batchCount === $expectedCount;
        }))->shouldBeCalledTimes(3)->willReturn(['messageIds' => array_fill(0, $batchCount, 'a')]);

        $client->___setProperty('connection', $connection->reveal());
        $publisher->___setProperty('client', $client);

        foreach ($messages as $message) {
            $publisher->publish($message);
        }
        sleep(1);

        $jobCount = 0;
        $jobs = $publisher->___getProperty('jobs');
        foreach ($jobs as $jobId => $job) {
            $job->flush();
            $jobCount++;
        }
        $this->assertEquals(3, $jobCount);
        $this->assertEquals(count($messages), $messageActualCount);

        putenv("IS_BATCH_DAEMON_RUNNING=" . $daemonRunning);
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
