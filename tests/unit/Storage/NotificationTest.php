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

namespace Google\Cloud\Tests\Unit\Storage;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\Notification;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group storage
 */
class NotificationTest extends TestCase
{
    const BUCKET_NAME = 'my-bucket';
    const NOTIFICATION_ID = '1234';

    private $connection;
    private $notificationInfo = [
        'id'   => '1234',
        'etag' => 'ABC',
        'kind' => 'storage#notification'
    ];

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    private function getNotification(array $data = [])
    {
        return new Notification(
            $this->connection->reveal(),
            self::NOTIFICATION_ID,
            self::BUCKET_NAME,
            $data
        );
    }

    public function testDoesExistTrue()
    {
        $this->connection->getNotification(Argument::any())
            ->willReturn(['id' => self::NOTIFICATION_ID]);
        $notification = $this->getNotification();

        $this->assertTrue($notification->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getNotification(Argument::any())
            ->willThrow(new NotFoundException(null));
        $notification = $this->getNotification();

        $this->assertFalse($notification->exists());
    }

    public function testDelete()
    {
        $this->connection->deleteNotification(Argument::any())
            ->willReturn([]);
        $notification = $this->getNotification();

        $this->assertNull($notification->delete());
    }

    public function testGetsInfo()
    {
        $notification = $this->getNotification($this->notificationInfo);

        $this->assertEquals($this->notificationInfo, $notification->info());
    }

    public function testGetsInfoWithForce()
    {
        $this->connection->getNotification(Argument::any())
            ->willReturn($this->notificationInfo)
            ->shouldBeCalledTimes(1);
        $notification = $this->getNotification();

        $this->assertEquals($this->notificationInfo, $notification->info());
    }

    public function testGetsId()
    {
        $notification = $this->getNotification();

        $this->assertEquals(self::NOTIFICATION_ID, $notification->id());
    }

    public function testReloads()
    {
        $this->connection->getNotification(Argument::any())
            ->willReturn($this->notificationInfo)
            ->shouldBeCalledTimes(1);
        $notification = $this->getNotification();

        $this->assertEquals($this->notificationInfo, $notification->reload());
    }

    public function testGetsIdentity()
    {
        $notification = $this->getNotification();

        $this->assertEquals(
            [
                'bucket' => self::BUCKET_NAME,
                'notification' => self::NOTIFICATION_ID,
                'userProject' => null
            ],
            $notification->identity()
        );
    }
}
