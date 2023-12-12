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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\GapicRequestWrapper;
use Google\Cloud\Core\RequestHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Core\Tests\Unit\Helpers\SampleGapicClass2;
use Google\Cloud\Core\Tests\Unit\Helpers\SampleGapicClass1;

/**
 * @group core
 */
class RequestHandlerTest extends TestCase
{
    use ProphecyTrait;

    private $requestWrapper;
    private $serializer;

    public function setUp(): void
    {
        $this->requestWrapper = $this->prophesize(GapicRequestWrapper::class);
        $this->serializer = $this->prophesize(Serializer::class);
    }

    public function testGetSerializer()
    {
        $requestHandler = new RequestHandler($this->serializer->reveal(), []);
        $this->assertInstanceOf(Serializer::class, $requestHandler->getSerializer());
    }

    /**
     * @dataProvider gapicClassOrObjectProvider
     */
    public function testgetGapicObject($gapicClasses, $callingClass)
    {
        $counter = 0;
        $requestHandler = new RequestHandler($this->serializer->reveal(), $gapicClasses);
        $requestHandler->sendRequest($callingClass, 'sampleMethod', [&$counter], []);

        // This will only be 1 if the relevant method was called
        $this->assertEquals(1, $counter);
    }

    public function gapicClassOrObjectProvider()
    {
        return [
            // First check for the case when a class is passed.
            [[SampleGapicClass1::class => SampleGapicClass1::class], SampleGapicClass1::class],
            // Then check for when an object was passed.
            [[SampleGapicClass2::class => new SampleGapicClass2()], SampleGapicClass2::class]
        ];
    }

    public function testSendRequest()
    {
        $gapicObj = new SampleGapicClass2();
        $gapicClasses = [SampleGapicClass2::class => $gapicObj];
        $requestHandler = new RequestHandler($this->serializer->reveal(), $gapicClasses);

        $responseStr = '{"foo": "bar"}';
        $this->requestWrapper->send([$gapicObj, 'sampleMethod'], Argument::cetera())
            ->willReturn(new Response(200, [], $responseStr));

        $requestHandler->setRequestWrapper($this->requestWrapper->reveal());

        $counter = 0;
        $response = $requestHandler->sendRequest(SampleGapicClass2::class, 'sampleMethod', [&$counter], []);
        $responseArr = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(json_decode($responseStr, true), $responseArr);
    }

    public function testSendRequestThrowsException()
    {
        $gapicObj = new SampleGapicClass2();
        $gapicClasses = [SampleGapicClass2::class => $gapicObj];
        $requestHandler = new RequestHandler($this->serializer->reveal(), $gapicClasses);

        $this->requestWrapper->send([$gapicObj, 'sampleMethod'], Argument::cetera())
            ->willThrow(new BadRequestException('exception message'));

        $requestHandler->setRequestWrapper($this->requestWrapper->reveal());

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('exception message');

        $counter = 0;
        $requestHandler->sendRequest(SampleGapicClass2::class, 'sampleMethod', [&$counter], []);
    }

    public function testRequiredAndOptionalArgs()
    {
        $passedRequiredArgs = ['foo', 'bar'];
        $passedOptionalArgs = ['key' => 'val'];

        $gapicObj = $this->prophesize(SampleGapicClass2::class);
        $caller = $this;

        $gapicObj->sampleMethod2(Argument::cetera())
            ->will(function ($args) use ($passedRequiredArgs, $passedOptionalArgs, $caller) {
                $requiredArgs = $args[0];
                $optionalArgs = $args[1];
                $caller->assertEquals($passedRequiredArgs, $requiredArgs);
                $caller->assertEquals($passedOptionalArgs, $optionalArgs);

                return true;
            });

        $gapicClasses = [SampleGapicClass2::class => $gapicObj->reveal()];
        $requestHandler = new RequestHandler($this->serializer->reveal(), $gapicClasses);

        $requestHandler->sendRequest(
            SampleGapicClass2::class,
            'sampleMethod2',
            [$passedRequiredArgs],
            $passedOptionalArgs
        );
    }
}
