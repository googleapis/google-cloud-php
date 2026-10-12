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

namespace Google\Cloud\PubSub\Tests\Snippet;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 */
class TopicTest extends SnippetTestCase
{
    use ProphecyTrait;
    use ApiHelperTrait;

    private const TOPIC = 'projects/my-awesome-project/topics/my-new-topic';
    private const SUBSCRIPTION = 'projects/my-awesome-project/subscriptions/my-new-subscription';
    private const PROJECT_ID = 'my-awesome-project';

    private $requestHandler;
    private $pubsub;
    private $topic;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->pubsub = TestHelpers::stub(PubSubClient::class, [
            [
                'projectId' => self::PROJECT_ID,
                'transport' => 'rest'
            ]
        ], ['requestHandler']);
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
        $this->topic = TestHelpers::stub(Topic::class, [
            $this->requestHandler->reveal(),
            $serializer,
            self::PROJECT_ID,
            self::TOPIC,
            false
        ], ['requestHandler']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Topic::class);
        $snippet->addLocal('pubsub', $this->pubsub);

        $res = $snippet->invoke('topic');
        $this->assertInstanceOf(Topic::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->returnVal()->name());
    }

    public function testClassWithFullyQualifiedName()
    {
        $snippet = $this->snippetFromClass(Topic::class, 1);
        $snippet->addLocal('pubsub', $this->pubsub);

        $res = $snippet->invoke('topic');
        $this->assertInstanceOf(Topic::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'name');
        $snippet->addLocal('topic', $this->topic);

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'create');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'createTopic',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('topicInfo');
        $this->assertEquals([], $res->returnVal());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'update');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'updateTopic',
            Argument::cetera()
        )->shouldBeCalled();

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet->invoke();
    }

    public function testUpdateWithMask()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'update', 1);
        $snippet->addLocal('topic', $this->topic);
        
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'updateTopic',
            Argument::cetera()
        )->shouldBeCalled();

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'delete');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'deleteTopic',
            Argument::cetera()
        )->shouldBeCalled();

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet->invoke();
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'exists');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Topic exists', $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'info');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => self::TOPIC
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'reload');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => self::TOPIC
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testPublish()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'publish');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            Argument::cetera()
        )->shouldBeCalled();

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->willReturn([
            'topic' => self::TOPIC,
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet->invoke();
    }

    public function testPublishBatch()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'publishBatch');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            Argument::cetera()
        )->shouldBeCalled();

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->willReturn([
            'topic' => self::TOPIC,
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet->invoke();
    }

    public function testBatchPublisher()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'batchPublisher');
        $batchPublisher = $this->prophesize(BatchPublisher::class);
        $batchPublisher->publish(Argument::type('array'))
            ->willReturn(true);
        $topic = $this->prophesize(Topic::class);
        $topic->batchPublisher()
            ->willReturn($batchPublisher->reveal());
        $snippet->addLocal('topic', $topic->reveal());

        $snippet->invoke();
    }

    public function testSubscribe()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'subscribe');
        $snippet->addLocal('topic', $this->topic);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSubscription',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => self::SUBSCRIPTION
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('subscription');
        $this->assertInstanceOf(Subscription::class, $res->returnVal());
    }

    public function testSubscription()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'subscription');
        $snippet->addLocal('topic', $this->topic);

        $res = $snippet->invoke('subscription');
        $this->assertInstanceOf(Subscription::class, $res->returnVal());
    }

    public function testSubscriptions()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'subscriptions');
        $snippet->addLocal('topic', $this->topic);
            
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'listTopicSubscriptions',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'subscriptions' => [
                self::SUBSCRIPTION
            ]
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('subscriptions');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'iam');
        $snippet->addLocal('topic', $this->topic);
        $res = $snippet->invoke('iam');

        $this->assertInstanceOf(IamManager::class, $res->returnVal());
    }
}
