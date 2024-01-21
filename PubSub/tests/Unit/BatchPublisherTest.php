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
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 * @group pubsub-batch
 */
class BatchPublisherTest extends TestCase
{
    use ProphecyTrait;

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
        $client = TestHelpers::stub(PubSubClient::class, [
            ['suppressKeyFileNotice' => true, 'projectId' => 'example-project']
        ], [
            'encode', 'requestHandler'
        ]);
        $client->___setProperty('encode', false);

        $publisher = TestHelpers::stub(BatchPublisher::class, [
            self::TOPIC_NAME,
        ], ['client', 'topics']);

        $requestHandler = $this->prophesize(RequestHandler::class);

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

        $orderedMsgsCounts = [
            [$messages[0] , $messages[2]],
            [$messages[1]],
            [$messages[3]]
        ];

        $requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            Argument::cetera()
        )->will(function ($args) use (&$orderedMsgsCounts) {
            return array_shift($orderedMsgsCounts);
        });

        $requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->willReturn([
            'name' => self::TOPIC_NAME,
        ]);

        $client->___setProperty('requestHandler', $requestHandler->reveal());
        $publisher->___setProperty('client', $client);
        $res = $publisher->publishDeferred($messages);

        // The returned order of the messages should be as per the
        // $orderedMsgsCounts declared above.
        $this->assertEquals($messages[0], $res[0]);
        $this->assertEquals($messages[2], $res[1]);
        $this->assertEquals($messages[1], $res[2]);
        $this->assertEquals($messages[3], $res[3]);
    }

    /**
     * @dataProvider compressionOptionsProvider
     */
    public function testPublisherCompression(
        $enableCompression,
        $compressionBytesThreshold,
        $processedEnableCompression,
        $processedCompressionBytesThreshold
    ) {
        $client = TestHelpers::stub(PubSubClient::class, [
            ['suppressKeyFileNotice' => true, 'projectId' => 'example-project']
        ], [
            'encode', 'requestHandler'
        ]);
        $client->___setProperty('encode', false);

        $publisher = TestHelpers::stub(BatchPublisher::class, [
            self::TOPIC_NAME, [
                'identifier' => uniqid(),
                'enableCompression' => $enableCompression,
                'compressionBytesThreshold' => $compressionBytesThreshold
            ]
        ], ['client', 'topics']);

        $requestHandler = $this->prophesize(RequestHandler::class);

        $messages = [[
            'data' => 'foo'
        ]];

        $requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            Argument::cetera()
        )->shouldBeCalled(1)->willReturn([]);

        $client->___setProperty('requestHandler', $requestHandler->reveal());
        $publisher->___setProperty('client', $client);
        $publisher->publishDeferred($messages);
    }

    public function compressionOptionsProvider()
    {
        // Each data is of the form
        // [
        //  $enableCompression                      Input option
        //  $compressionBytesThreshold              Input option
        //  $processedEnableCompression             Expected set option
        //  $processedCompressionBytesThreshold     Expected set option
        // ]
        return [
            [null, null, false, Topic::DEFAULT_COMPRESSION_BYTES_THRESHOLD],
            [false, null, false, Topic::DEFAULT_COMPRESSION_BYTES_THRESHOLD],
            [false, 10000, false, Topic::DEFAULT_COMPRESSION_BYTES_THRESHOLD],
            [true, null, true, Topic::DEFAULT_COMPRESSION_BYTES_THRESHOLD],
            [true, 10000, true, 10000],
        ];
    }
}

//@codingStandardsIgnoreStart
class TestBatchPublisher extends BatchPublisher
{
    use ProphecyTrait;

    public function getCallbackArray()
    {
        return $this->getCallback();
    }
}
//@codingStandardsIgnoreEnd
