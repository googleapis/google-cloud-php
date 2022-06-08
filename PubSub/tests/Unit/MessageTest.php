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

use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Subscription;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

/**
 * @group pubsub
 */
class MessageTest extends TestCase
{
    use AssertIsType;

    private $message;

    private $time = '2016-09-27T13:21:30.242Z';

    public function set_up()
    {
        $this->message = new Message([
            'data' => 'hello world',
            'messageId' => 1,
            'publishTime' => $this->time,
            'attributes' => [
                'foo' => 'bar'
            ],
            'orderingKey' => 'foo'
        ], [
            'ackId' => 1234,
            'deliveryAttempt' => 4,
            'subscription' => $this->prophesize(Subscription::class)->reveal()
        ]);
    }

    public function testData()
    {
        $this->assertEquals('hello world', $this->message->data());
    }

    public function testOrderingKey()
    {
        $this->assertEquals('foo', $this->message->orderingKey());
    }

    public function testAttribute()
    {
        $this->assertEquals('bar', $this->message->attribute('foo'));
    }

    public function testAttributeNull()
    {
        $this->assertNull($this->message->attribute('nothanks'));
    }

    public function testAttributes()
    {
        $this->assertEquals(['foo' => 'bar'], $this->message->attributes());
    }

    public function testId()
    {
        $this->assertEquals(1, $this->message->id());
    }

    public function testPublishTime()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->message->publishTime());
        $this->assertEquals(new \DateTimeImmutable($this->time), $this->message->publishTime());
    }

    public function testAckId()
    {
        $this->assertEquals(1234, $this->message->ackId());
    }

    /**
     * @dataProvider deliveryAttempts
     */
    public function testDeliveryAttempt($metadata, $expected)
    {
        $message = new Message([], $metadata);
        $this->assertEquals($expected, $message->deliveryAttempt());
    }

    public function deliveryAttempts()
    {
        return [
            [[], null],
            [['deliveryAttempt' => 2], 2]
        ];
    }

    public function testSubscription()
    {
        $this->assertInstanceOf(Subscription::class, $this->message->subscription());
    }

    public function testInfo()
    {
        $this->assertIsArray($this->message->info());
        $this->assertIsArray($this->message->info()['message']);
        $this->assertInstanceOf(Subscription::class, $this->message->info()['subscription']);
        $this->assertEquals(1234, $this->message->info()['ackId']);
    }
}
