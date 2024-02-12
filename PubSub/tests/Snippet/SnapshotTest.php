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
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 */
class SnapshotTest extends SnippetTestCase
{
    use ProphecyTrait;
    use ApiHelperTrait;

    private const PROJECT = 'my-awesome-project';
    private const SNAPSHOT = 'projects/my-awesome-project/snapshots/my-snapshot';
    private const PROJECT_ID = 'my-awesome-project';

    private $requestHandler;
    private $snapshot;
    private $pubsub;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
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
        $this->pubsub = TestHelpers::stub(PubSubClient::class, [
            [
                'projectId' => self::PROJECT_ID,
                'transport' => 'rest'
            ]
        ], ['requestHandler']);

        $this->pubsub->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->snapshot = TestHelpers::stub(Snapshot::class, [
            $this->requestHandler->reveal(),
            $serializer,
            self::PROJECT,
            self::SNAPSHOT,
            false,
            [
                'topic' => 'foo',
                'subscription' => 'bar'
            ]
        ], ['requestHandler']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Snapshot::class);
        $snippet->addLocal('pubsub', $this->pubsub);
        $snippet->addLocal('snapshotName', self::SNAPSHOT);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
        $this->assertEquals(self::SNAPSHOT, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'name');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke();
        $this->assertEquals(self::SNAPSHOT, $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'info');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('info');
        $this->assertEquals('foo', $res->returnVal()['topic']);
    }

    public function testCreate()
    {
        $info = [
            'topic' => 'foo',
            'subscription' => 'bar'
        ];

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSnapshot',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn($info);

        $this->snapshot->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(Snapshot::class, 'create');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('info');
        $this->assertEquals($info, $res->returnVal());
    }

    public function testDelete()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'deleteSnapshot',
            Argument::cetera()
        )->shouldBeCalled();

        $this->snapshot->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(Snapshot::class, 'delete');
        $snippet->addLocal('snapshot', $this->snapshot);

        $snippet->invoke();
    }

    public function testTopic()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'topic');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('topic');
        $this->assertInstanceOf(Topic::class, $res->returnVal());
    }

    public function testSubscription()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'subscription');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('subscription');
        $this->assertInstanceOf(Subscription::class, $res->returnVal());
    }
}
