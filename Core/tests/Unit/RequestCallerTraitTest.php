<?php

/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\GapicRequestWrapper;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Core\RequestCallerTrait;
use Prophecy\Argument;
use GuzzleHttp\Psr7\Response;
use Google\Cloud\Core\Exception\NotFoundException;

/**
 * @group core
 */
class RequestCallerTraitTest extends TestCase
{
    use ProphecyTrait;

    private $implementation;
    private $requestWrapper;

    public function setUp(): void
    {
        $this->implementation = $this->getObjectForTrait(RequestCallerTrait::class);
        $this->requestWrapper = $this->prophesize(GapicRequestWrapper::class);
    }

    public function testSetGetRequestWrapper()
    {
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $this->assertInstanceOf(GapicRequestWrapper::class, $this->implementation->requestWrapper());
    }

    public function testSendRequest()
    {
        $responseBody = '{"foo": "bar"}';
        $this->requestWrapper->send(Argument::cetera())
            ->willReturn(new Response(200, [], $responseBody));

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send(function () {
            return "";
        }, []);

        $responseArr = json_decode($actualResponse->getBody()->getContents(), true);

        $this->assertEquals(json_decode($responseBody, true), $responseArr);
    }

    public function testSendRequestWithOptions()
    {
        $callableFunc = function () {
        };

        $args = [
            ['requiredArgs'],
            [
                'optionalArgs' => true
            ]
        ];
        $responseBody = '{"foo": "bar"}';
        $this->requestWrapper->send($callableFunc, $args)
            ->willReturn(new Response(200, [], $responseBody));

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send($callableFunc, $args);
        $responseArr = json_decode($actualResponse->getBody()->getContents(), true);

        $this->assertEquals(json_decode($responseBody, true), $responseArr);
    }

    /**
     * @dataProvider whitelistProvider
     */
    public function testSendRequestWhitelisted($isWhitelisted, $errMsg, $expectedMsg)
    {
        $callableFunc = function () {
        };

        $this->requestWrapper->send(
            $callableFunc,
            Argument::type('array')
        )->willThrow(new NotFoundException($errMsg));

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());

        $msg = null;
        try {
            $this->implementation->send($callableFunc, [], $isWhitelisted);
        } catch (NotFoundException $e) {
            $msg = $e->getMessage();
        }

        $this->assertStringContainsString($expectedMsg, $msg);
    }

    public function whitelistProvider()
    {
        return [
            [true, 'The url was not found!', 'NOTE: Error may be due to Whitelist Restriction.'],
            [false, 'The url was not found!', 'The url was not found!']
        ];
    }
}
