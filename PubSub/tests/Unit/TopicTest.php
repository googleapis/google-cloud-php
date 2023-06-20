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

namespace Google\Cloud\PubSub\Tests\Unit;

use Google\Cloud\Core\V2\RequestHandler;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\V2\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\V1\PublisherClient;
use Google\Cloud\PubSub\V1\SubscriberClient;
use Google\Cloud\PubSub\V1\Topic as TopicProto;
use Google\Cloud\PubSub\V1\Subscription as SubscriptionProto;
use Google\Cloud\PubSub\V1\PublishResponse;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\PubSubSerializer;
use Google\Cloud\PubSub\Topic;
use Google\Protobuf\FieldMask;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 */
class TopicTest extends TestCase
{
    use ProphecyTrait;

    const TOPIC = 'projects/project-name/topics/topic-name';

    private $topic;
    private $publisherClient;
    private $subscriberClient;

    public function setUp(): void
    {
        $this->publisherClient = $this->prophesize(PublisherClient::class);
        $this->subscriberClient = $this->prophesize(SubscriberClient::class);
        $this->topic = TestHelpers::stub(Topic::class, [
            'project-name',
            'topic-name',
            true
        ], ['reqHandler']);
    }

    private function setMockClientOnTopic($mockClient, $clientClass)
    {
        $reqHandler = new RequestHandler(
            new PubSubSerializer(),
            [PublisherClient::class],
            ['libVersion' => PubSubClient::VERSION]
        );

        $prop = (new \ReflectionClass($reqHandler))->getProperty('gapics');
        $prop->setAccessible(true);
        $prop->setValue($reqHandler, [$clientClass => $mockClient]);
        $this->topic->___setProperty('reqHandler', $reqHandler);
    }

    public function testName()
    {
        $this->assertEquals($this->topic->name(), self::TOPIC);
    }

    public function testCreate()
    {
        $response = new TopicProto(['name' => self::TOPIC]);
        $this->publisherClient->createTopic(
            self::TOPIC,
            Argument::withEntry('foo', 'bar')
        )
            ->willReturn($response);

        $this->publisherClient->getTopic()->shouldNotBeCalled();

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $res = $this->topic->create(['foo' => 'bar']);

        // Make sure the topic data gets cached!
        $this->topic->info();

        $this->assertEquals(self::TOPIC, $res['name']);
    }

    public function testUpdate()
    {
        $this->publisherClient->updateTopic(
            Argument::type(TopicProto::class),
            Argument::type(FieldMask::class),
            Argument::withEntry('retrySettings', Argument::any())
        )->shouldBeCalled()->willReturn(
            new TopicProto(['name' => self::TOPIC, 'labels' => ['foo' => 'bar']])
        );

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $res = $this->topic->update(['labels' => ['foo' => 'bar']]);

        $this->assertEquals(self::TOPIC, $res['name']);
        $this->assertEquals(['foo' => 'bar'], $this->topic->info()['labels']);
    }

    public function testDelete()
    {
        $this->publisherClient->deleteTopic(
            self::TOPIC,
            Argument::withEntry('foo', 'bar')
        )->shouldBeCalled();

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $res = $this->topic->delete(['foo' => 'bar']);
    }

    public function testExists()
    {
        $this->publisherClient->getTopic(
            self::TOPIC,
            Argument::withEntry('foo', 'bar')
        )->willReturn(new TopicProto(['name' => self::TOPIC]));

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $this->assertTrue($this->topic->exists(['foo' => 'bar']));
    }

    public function testExistsReturnsFalse()
    {
        $this->publisherClient->getTopic(
            self::TOPIC,
            Argument::withEntry('foo', 'bar')
        )->willThrow(new NotFoundException('uh oh'));

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $this->assertFalse($this->topic->exists(['foo' => 'bar']));
    }

    public function testInfo()
    {
        $this->publisherClient->getTopic(
            self::TOPIC,
            Argument::withEntry('foo', 'bar')
        )->willReturn(new TopicProto(['name' => self::TOPIC]))
            ->shouldBeCalledTimes(1);

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $res = $this->topic->info(['foo' => 'bar']);
        $res2 = $this->topic->info();

        $this->assertEquals($res, $res2);
        $this->assertEquals($res['name'], self::TOPIC);
    }

    public function testReload()
    {
        $this->publisherClient->getTopic(
            self::TOPIC,
            Argument::withEntry('foo', 'bar')
        )->willReturn(new TopicProto(['name' => self::TOPIC]));

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $res = $this->topic->reload(['foo' => 'bar']);

        $this->assertEquals($res['name'], self::TOPIC);
    }

    public function testPublish()
    {
        $message = [
            'data' => 'hello world',
            'attributes' => [
                'key' => 'value'
            ]
        ];

        $ids = [
            'message1id'
        ];

        $this->publisherClient->publish(
            self::TOPIC,
            Argument::that(function ($options) use ($message) {
                return $options[0]->getData() === base64_encode($message['data'])
                    && iterator_to_array($options[0]->getAttributes()) === $message['attributes'];
            }),
            Argument::withEntry('foo', 'bar')
        )->willReturn(new PublishResponse(['message_ids' => $ids]));

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $res = $this->topic->publish($message, ['foo' => 'bar']);

        $this->assertEquals($res['messageIds'], $ids);
    }

    public function testPublishBatch()
    {
        $messages = [
            [
                'data' => 'hello world',
                'attributes' => [
                    'key' => 'value'
                ]
            ], [
                'data' => 'hello again, world',
                'attributes' => [
                    'key' => 'other value i guess'
                ]
            ]
        ];

        $ids = [
            'message1id',
            'message2id'
        ];

        $this->publisherClient->publish(
            self::TOPIC,
            Argument::that(function ($options) use ($messages) {
                return $options[0]->getData() === base64_encode($messages[0]['data'])
                    && $options[1]->getData() === base64_encode($messages[1]['data'])
                    && iterator_to_array($options[0]->getAttributes()) === $messages[0]['attributes']
                    && iterator_to_array($options[1]->getAttributes()) === $messages[1]['attributes'];
            }),
            Argument::withEntry('foo', 'bar')
        )->willReturn(new PublishResponse(['message_ids' => $ids]));

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $res = $this->topic->publishBatch($messages, ['foo' => 'bar']);

        $this->assertEquals($res['messageIds'], $ids);
    }

    public function testPublishMalformedMessage()
    {
        $this->expectException(InvalidArgumentException::class);

        $message = [
            'key' => 'val'
        ];

        $this->publisherClient->publish(Argument::any());

        $this->setMockClientOnTopic($this->publisherClient->reveal(), PublisherClient::class);

        $this->topic->publishBatch([$message]);
    }

    public function testBatchPublisher()
    {
        $this->assertInstanceOf(
            BatchPublisher::class,
            $this->topic->batchPublisher()
        );
    }

    // public function testSubscribe()
    // {
    //     $subscriptionData = [
    //         'name' => 'projects/project-name/subscriptions/subscription-name',
    //         'topic' => self::TOPIC
    //     ];

    //     $this->connection->createSubscription(Argument::withEntry('foo', 'bar'))
    //         ->willReturn($subscriptionData)
    //         ->shouldBeCalledTimes(1);

    //     $this->topic->___setProperty('connection', $this->connection->reveal());

    //     $subscription = $this->topic->subscribe('subscription-name', ['foo' => 'bar']);

    //     $this->assertInstanceOf(Subscription::class, $subscription);
    // }

    public function testSubscription()
    {
        $subscription = $this->topic->subscription('subscription-name');

        $this->assertInstanceOf(Subscription::class, $subscription);
    }

    // public function testSubscriptions()
    // {
    //     $subscriptionResult = [
    //         'projects/project-name/subscriptions/subscription-a',
    //         'projects/project-name/subscriptions/subscription-b',
    //         'projects/project-name/subscriptions/subscription-c',
    //     ];

    //     $this->connection->listSubscriptionsByTopic(Argument::withEntry('foo', 'bar'))
    //         ->willReturn([
    //             'subscriptions' => $subscriptionResult
    //         ])->shouldBeCalledTimes(1);

    //     $this->topic->___setProperty('connection', $this->connection->reveal());

    //     $subscriptions = $this->topic->subscriptions([
    //         'foo' => 'bar'
    //     ]);

    //     $this->assertInstanceOf(ItemIterator::class, $subscriptions);

    //     $arr = iterator_to_array($subscriptions);
    //     $this->assertInstanceOf(Subscription::class, $arr[0]);
    //     $this->assertEquals($arr[0]->name(), $subscriptionResult[0]);
    //     $this->assertEquals($arr[1]->name(), $subscriptionResult[1]);
    //     $this->assertEquals($arr[2]->name(), $subscriptionResult[2]);
    // }

    // public function testSubscriptionsPaged()
    // {
    //     $subscriptionResult = [
    //         'projects/project-name/subscriptions/subscription-a',
    //         'projects/project-name/subscriptions/subscription-b',
    //         'projects/project-name/subscriptions/subscription-c',
    //     ];

    //     $this->connection->listSubscriptionsByTopic(Argument::allOf(
    //         Argument::withEntry('foo', 'bar'),
    //         Argument::that(function ($options) {
    //             if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
    //                 return false;
    //             }

    //             return true;
    //         })
    //     ))->willReturn([
    //         'subscriptions' => $subscriptionResult,
    //         'nextPageToken' => 'foo'
    //     ])->shouldBeCalledTimes(2);

    //     $this->topic->___setProperty('connection', $this->connection->reveal());

    //     $subscriptions = $this->topic->subscriptions([
    //         'foo' => 'bar'
    //     ]);

    //     // enumerate the iterator and kill after it loops twice.
    //     $arr = [];
    //     $i = 0;
    //     foreach ($subscriptions as $subscription) {
    //         $i++;
    //         $arr[] = $subscription;
    //         if ($i == 6) {
    //             break;
    //         }
    //     }

    //     $this->assertCount(6, $arr);
    // }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->topic->iam());
    }
}
