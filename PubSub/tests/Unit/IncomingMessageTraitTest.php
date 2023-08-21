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

use Google\ApiCore\Veneer\RequestHandler;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\IncomingMessageTrait;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Subscription;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 */
class IncomingMessageTraitTest extends TestCase
{
    use ProphecyTrait;

    const PROJECT = 'my-project';

    private $requestHandler;
    private $stub;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->stub = TestHelpers::impl(IncomingMessageTrait::class, ['requestHandler']);
        $this->stub->___setProperty('requestHandler', $this->requestHandler->reveal());
    }

    public function testMessageFactory()
    {
        $data = [
            'message' => [
                'data' => 'hello world'
            ]
        ];

        $message = $this->stub->call(
            'messageFactory',
            [
                $data, self::PROJECT, false
            ]
        );

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals('hello world', $message->data());
    }

    public function testInvalidMessage()
    {
        $this->expectException(GoogleException::class);

        $this->stub->call(
            'messageFactory',
            [
                [], self::PROJECT, false
            ]
        );
    }

    public function testDecodeMessage()
    {
        $message = $this->stub->call(
            'messageFactory',
            [
                [
                    'message' => [
                        'data' => base64_encode('hello world')
                    ]
                ],
                self::PROJECT,
                true
            ]
        );

        $this->assertEquals('hello world', $message->data());
    }

    public function testMessageWithSubscription()
    {
        $message = $this->stub->call(
            'messageFactory',
            [
                [
                    'message' => [
                        'data' => base64_encode('hello world')
                    ],
                    'subscription' => 'projects/project-id/subscriptions/foo'
                ],
                self::PROJECT,
                true
            ]
        );

        $this->assertInstanceOf(Subscription::class, $message->subscription());
        $this->assertEquals('projects/project-id/subscriptions/foo', $message->subscription()->name());
    }
}
