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

namespace Google\Cloud\Tests\Snippets\Storage;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\Notification;
use Prophecy\Argument;

/**
 * @group storage
 */
class NotificationTest extends SnippetTestCase
{
    const BUCKET = 'my-bucket';
    const NOTIFICATION_ID = '1234';

    private $connection;
    private $notification;

    public function setUp()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->notification = \Google\Cloud\Dev\stub(Notification::class, [
            $this->connection->reveal(),
            self::NOTIFICATION_ID,
            self::BUCKET
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Notification::class);
        $res = $snippet->invoke('notification');

        $this->assertInstanceOf(Notification::class, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Notification::class, 'exists');
        $snippet->addLocal('notification', $this->notification);
        $this->connection->getNotification(Argument::any())
            ->shouldBeCalled();
        $this->notification->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke();

        $this->assertEquals('Notification exists!', $res->output());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Notification::class, 'delete');
        $snippet->addLocal('notification', $this->notification);
        $this->connection->deleteNotification(Argument::any())
            ->shouldBeCalled();
        $this->notification->___setProperty('connection', $this->connection->reveal());
        $snippet->invoke();
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Notification::class, 'info');
        $snippet->addLocal('notification', $this->notification);
        $topic = 'my-topic';
        $this->connection->getNotification(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'topic' => $topic
            ]);
        $this->notification->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke();

        $this->assertEquals($topic, $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Notification::class, 'reload');
        $snippet->addLocal('notification', $this->notification);
        $topic = 'my-topic';
        $this->connection->getNotification(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'topic' => $topic
            ]);
        $this->notification->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke();

        $this->assertEquals($topic, $res->output());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(Notification::class, 'id');
        $snippet->addLocal('notification', $this->notification);
        $res = $snippet->invoke();

        $this->assertEquals(self::NOTIFICATION_ID, $res->output());
    }

    public function testIdentity()
    {
        $snippet = $this->snippetFromMethod(Notification::class, 'identity');
        $snippet->addLocal('notification', $this->notification);
        $res = $snippet->invoke();

        $this->assertEquals(self::BUCKET, $res->output());
    }
}
