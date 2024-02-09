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

use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Schema;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\Client\SchemaServiceClient;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 */
class PubSubClientTest extends SnippetTestCase
{
    use ProphecyTrait;

    private const PROJECT_ID = 'my-awesome-project';
    private const TOPIC = 'projects/my-awesome-project/topics/my-new-topic';
    private const SUBSCRIPTION = 'projects/my-awesome-project/subscriptions/my-new-subscription';
    private const SNAPSHOT = 'projects/my-awesome-project/snapshots/my-snapshot';
    private const SCHEMA = 'projects/my-awesome-project/schemas/my-schema';

    private $requestHandler;
    private $client;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->client = TestHelpers::stub(PubSubClient::class, [
            ['transport' => 'rest', 'projectId' => self::PROJECT_ID]
        ], ['requestHandler']);
    }

    public function testClassExample()
    {
        $snippet = $this->snippetFromClass(PubSubClient::class);
        $res = $snippet->invoke('pubsub');

        $this->assertInstanceOf(PubSubClient::class, $res->returnVal());
    }

    // phpunit doesn't get the value of $_ENV, so testing PUBSUB_EMULATOR_HOST is pretty tough.
    public function testClassExample3()
    {
        $snippet = $this->snippetFromClass(PubSubClient::class, 1);
        $res = $snippet->invoke('pubsub');

        $this->assertInstanceOf(PubSubClient::class, $res->returnVal());

        putenv('PUBSUB_EMULATOR_HOST');
    }

    public function testCreateTopic()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'createTopic',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => self::TOPIC
        ]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(PubSubClient::class, 'createTopic');
        $snippet->addLocal('pubsub', $this->client);

        $res = $snippet->invoke('topic');

        $this->assertInstanceOf(Topic::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->returnVal()->name());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testTopic()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'topic');
        $snippet->addLocal('pubsub', $this->client);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => self::TOPIC
        ]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('topic');

        $this->assertInstanceOf(Topic::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->returnVal()->name());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testTopics()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'topics');
        $snippet->addLocal('pubsub', $this->client);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'listTopics',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'topics' => [
                ['name' => self::TOPIC]
            ]
        ]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('topics');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testSubscribe()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'subscribe');
        $snippet->addLocal('pubsub', $this->client);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSubscription',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('subscription');

        $this->assertInstanceOf(Subscription::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->name());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->info()['name']);
        $this->assertEquals(self::TOPIC, $res->returnVal()->info()['topic']);
    }

    public function testSubscription()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'subscription');
        $snippet->addLocal('pubsub', $this->client);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'name' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('subscription');

        $this->assertInstanceOf(Subscription::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->name());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->info()['name']);
        $this->assertEquals(self::TOPIC, $res->returnVal()->info()['topic']);
    }

    public function testSubscriptions()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'subscriptions');
        $snippet->addLocal('pubsub', $this->client);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'listSubscriptions',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'subscriptions' => [
                ['name' => self::SUBSCRIPTION, 'topic' => self::TOPIC]
            ]
        ]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('subscriptions');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }

    public function testCreateSnapshot()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSnapshot',
            Argument::cetera()
        )->shouldBecalled()
        ->willReturn([]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(PubSubClient::class, 'createSnapshot');
        $snippet->addLocal('pubsub', $this->client);
        $snippet->addLocal('subscriptionName', self::SUBSCRIPTION);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
    }

    public function testSnapshot()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'snapshot');
        $snippet->addLocal('pubsub', $this->client);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
    }

    public function testSnapshots()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'snapshots');
        $snippet->addLocal('pubsub', $this->client);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'listSnapshots',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'snapshots' => [
                ['name' => self::SNAPSHOT]
            ]
        ]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('snapshots');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::SNAPSHOT, $res->output());
    }

    public function testSchema()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'schema');
        $snippet->addLocal('pubsub', $this->client);

        $res = $snippet->invoke('schema');
        $this->assertInstanceOf(Schema::class, $res->returnVal());
        $this->assertEquals(self::SCHEMA, $res->returnVal()->name());
    }

    public function testCreateSchema()
    {
        $definition = 'foo';

        $snippet = $this->snippetFromMethod(PubSubClient::class, 'createSchema');
        $snippet->replace('$definition = file_get_contents(\'my-schema.txt\');', '');
        $snippet->addLocal('definition', $definition);
        $snippet->addLocal('pubsub', $this->client);

        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'createSchema',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn(['name' => self::SCHEMA]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('schema');
        $this->assertInstanceOf(Schema::class, $res->returnVal());
        $this->assertEquals(self::SCHEMA, $res->returnVal()->name());
    }

    public function testSchemas()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'schemas');
        $snippet->addLocal('pubsub', $this->client);

        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'listSchemas',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn([
            'schemas' => [
                ['name' => self::SCHEMA]
            ]
        ]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('schemas');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::SCHEMA, $res->output());
    }

    public function testValidateSchema()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'validateSchema');
        $snippet->replace('$definition = file_get_contents(\'my-schema.txt\');', '');
        $snippet->addLocal('pubsub', $this->client);
        $snippet->addLocal('definition', '');

        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'validateSchema',
            Argument::cetera()
        )->shouldBeCalled();
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke();

        $this->assertEquals('schema is valid!', $res->output());
    }

    public function testValidateSchemaInvalid()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'validateSchema');
        $snippet->replace('$definition = file_get_contents(\'my-schema.txt\');', '');
        $snippet->addLocal('pubsub', $this->client);
        $snippet->addLocal('definition', '');

        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'validateSchema',
            Argument::cetera()
        )->shouldBeCalled()
        ->willThrow(new BadRequestException('foo'));
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke();

        $this->assertEquals('foo', $res->output());
    }

    public function testValidateMessage()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'validateMessage');
        $snippet->addLocal('pubsub', $this->client);
        $snippet->addLocal('message', '');

        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'validateMessage',
            Argument::cetera()
        )->shouldBeCalled();
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke();

        $this->assertEquals('message is valid!', $res->output());
    }

    public function testValidateMessageInvalid()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'validateMessage');
        $snippet->addLocal('pubsub', $this->client);
        $snippet->addLocal('message', '');

        $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'validateMessage',
            Argument::cetera()
        )->shouldBeCalled()
        ->willThrow(new BadRequestException('foo'));
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke();

        $this->assertEquals('foo', $res->output());
    }

    public function testConsume()
    {
        $message = [
            "message" => [
                "attributes" => [],
                "data" => base64_encode('content'),
                "message_id" => "message-id",
                "publish_time" => (new \DateTime)->format('c'),
            ],
            "subscription" => self::SUBSCRIPTION
        ];

        $snippet = $this->snippetFromMethod(PubSubClient::class, 'consume');
        $snippet->addLocal('pubsub', $this->client);
        $snippet->setLine(0, '$httpPostRequestBody = \''. json_encode($message) .'\';');

        $res = $snippet->invoke('message');
        $this->assertInstanceOf(Message::class, $res->returnVal());
    }

    public function testTimestamp()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'timestamp');
        $snippet->addLocal('pubsub', $this->client);
        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testDuration()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'duration');
        $snippet->addLocal('pubsub', $this->client);
        $res = $snippet->invoke('duration');
        $this->assertInstanceOf(Duration::class, $res->returnVal());
    }
}
