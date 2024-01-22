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
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\GapicRequestWrapper;
use Google\Cloud\Core\RequestHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Core\Tests\Unit\Stubs\SampleGapicClass2;
use Google\Cloud\Core\Tests\Unit\Stubs\SampleGapicClass1;
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\Api\Http;
use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Rpc\Code;
use Google\ApiCore\ServerStream;
use Google\ApiCore\Testing\MockRequest;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\Exception\DeadlineExceededException;
use Google\Cloud\Core\Exception\FailedPreconditionException;
use Google\Cloud\Core\Exception\ServerException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Rpc\BadRequest;
use Google\Rpc\BadRequest\FieldViolation;
use Google\Rpc\PreconditionFailure;
use Google\Rpc\Status;

/**
 * @group core
 */
class RequestHandlerTest extends TestCase
{
    use ProphecyTrait;

    private $serializer;
    private $request;

    public function setUp(): void
    {
        $this->serializer = $this->prophesize(Serializer::class);
        $this->request = new MockRequest();
    }

    /**
     * @dataProvider gapicClassOrObjectProvider
     */
    public function testGetGapicObject($clientClasses, $callingClass)
    {
        $counter = 0;
        $func = function () use (&$counter) {
            $counter = 1;
        };
        $requestHandler = new RequestHandler($this->serializer->reveal(), $clientClasses);
        $requestHandler->sendRequest($callingClass, 'sampleMethod', $this->request, ['func' => $func]);

        $this->assertEquals(1, $counter);
    }

    public function gapicClassOrObjectProvider()
    {
        return [
            // First check for the case when a class is passed.
            [[SampleGapicClass1::class], SampleGapicClass1::class],
            // Then check for when an object was passed.
            [[SampleGapicClass2::class], SampleGapicClass2::class]
        ];
    }

    /**
     * @dataProvider responseProvider
     */
    public function testSuccessfullySendsRequest($response, $expectedMessage)
    {
        $this->serializer->encodeMessage(Argument::type(Http::class))
            ->willReturn($expectedMessage);

        $clientClasses = [SampleGapicClass1::class];
        $requestHandler = new RequestHandler($this->serializer->reveal(), $clientClasses);

        $func = function () use ($response) {
            return $response;
        };

        $actualResponse = $requestHandler->sendRequest(
            SampleGapicClass1::class,
            'sampleMethod',
            $this->request,
            ['func' => $func]
        );

        $this->assertEquals($expectedMessage, $actualResponse);
    }

    public function responseProvider()
    {
        $expectedMessage = ['successful' => 'request'];
        $message = new Http();
        
        $pagedMessage = $this->prophesize(PagedListResponse::class);
        $page = $this->prophesize(Page::class);
        $page->getResponseObject()->willReturn($message);
        $pagedMessage->getPage()->willReturn($page->reveal());
        $operationResponse = new OperationResponse("foo", new \stdClass());

        return [
            [$message, $expectedMessage],
            [$pagedMessage->reveal(), $expectedMessage],
            // instance of OperationResponse is sent as-is
            [$operationResponse, $operationResponse],
            [null, null]
        ];
    }

    public function testSendRequestThrowsException()
    {
        $clientClasses = [SampleGapicClass2::class];

        $func = function () {
            throw new ApiException(
                'exception message',
                \Google\Rpc\Code::NOT_FOUND,
                \Google\ApiCore\ApiStatus::NOT_FOUND
            );
        };

        $requestHandler = new RequestHandler(
            $this->serializer->reveal(),
            $clientClasses,
            []
        );

        $this->expectException(GoogleException::class);
        $this->expectExceptionMessage('exception message');

        $requestHandler->sendRequest(
            SampleGapicClass2::class,
            'sampleMethod',
            $this->request,
            ['func' => $func]
        );
    }

    /**
     * @dataProvider whitelistProvider
     */
    public function testSendRequestWhitelisted($isWhitelisted, $errMsg, $expectedMsg)
    {
        $func = function () use ($errMsg) {
            throw new NotFoundException($errMsg);
        };

        $clientClasses = [SampleGapicClass2::class];
        $requestHandler = new RequestHandler(
            $this->serializer->reveal(),
            $clientClasses,
            []
        );

        $msg = null;
        try {
            $requestHandler->sendRequest(
                SampleGapicClass2::class,
                'sampleMethod',
                $this->request,
                ['func' => $func],
                $isWhitelisted
            );
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

    public function testReturnsStreamedResponse()
    {
        $clientClasses = [SampleGapicClass2::class];
        $requestHandler = new RequestHandler(
            new Serializer(),
            $clientClasses,
            []
        );
        $status = new Status(['code' => Code::CANCELLED]);
        $expected = (new Serializer)->encodeMessage($status);

        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->willReturn(new \ArrayIterator([
            $status,
            $status,
            $status
        ]));

        $func = function () use ($stream) {
            return $stream->reveal();
        };

        $res = $requestHandler->sendRequest(
            SampleGapicClass2::class,
            'sampleMethod',
            $this->request,
            ['func' => $func]
        );

        $this->assertInstanceOf(\Generator::class, $res);
        foreach ($res as $r) {
            $this->assertEquals($expected, $r);
        }
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testCastsToProperException($code, $expectedException)
    {
        $clientClasses = [SampleGapicClass2::class];
        $requestHandler = new RequestHandler(
            new Serializer(),
            $clientClasses,
            []
        );

        $func = function () use ($code) {
            $status = ApiStatus::statusFromRpcCode($code);
            throw new ApiException('message', $code, $status);
        };

        try {
            $requestHandler->sendRequest(
                SampleGapicClass2::class,
                'sampleMethod',
                $this->request,
                ['func' => $func]
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf($expectedException, $ex);
        }
    }

    public function exceptionProvider()
    {
        return [
            [Code::INVALID_ARGUMENT, BadRequestException::class],
            [Code::NOT_FOUND, NotFoundException::class],
            [Code::UNIMPLEMENTED, NotFoundException::class],
            [Code::ALREADY_EXISTS, ConflictException::class],
            [Code::FAILED_PRECONDITION, FailedPreconditionException::class],
            [Code::UNKNOWN, ServerException::class],
            [Code::INTERNAL, ServerException::class],
            [Code::ABORTED, AbortedException::class],
            [Code::DEADLINE_EXCEEDED, DeadlineExceededException::class],
            [999, ServiceException::class]
        ];
    }

    public function testExceptionMetadata()
    {
        $metadata = new BadRequest([
            'field_violations' => [
                new FieldViolation([
                    'field' => 'foo',
                    'description' => 'bar'
                ])
            ]
        ]);

        $otherMetadata = new PreconditionFailure();

        $e = new ApiException(
            'Testing',
            Code::INVALID_ARGUMENT,
            'foo',
            [
                'metadata' => [
                    'google.rpc.badrequest-bin' => [$metadata->serializeToString()],
                    'google.rpc.preconditionfailure-bin' => [$otherMetadata->serializeToString()]
                ]
            ]
        );

        $func = function () use ($e) {
            throw $e;
        };

        $clientClasses = [SampleGapicClass2::class];
        $requestHandler = new RequestHandler(
            new Serializer(),
            $clientClasses,
            []
        );

        try {
            $requestHandler->sendRequest(
                SampleGapicClass2::class,
                'sampleMethod',
                $this->request,
                ['func' => $func]
            );

            $this->assertFalse(true, 'Exception not thrown!');
        } catch (ServiceException $ex) {
            $this->assertEquals(
                json_decode($metadata->serializeToJsonString(), true),
                $ex->getMetadata()[0]
            );

            // Assert only whitelisted types are included.
            $this->assertCount(1, $ex->getMetadata());
        }
    }
}
