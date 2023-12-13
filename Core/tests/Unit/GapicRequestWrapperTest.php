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

use Google\Api\Http;
use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\Serializer;
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\Exception;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\GapicRequestWrapper;
use Google\Rpc\BadRequest;
use Google\Rpc\BadRequest\FieldViolation;
use Google\Rpc\Code;
use Google\Rpc\PreconditionFailure;
use Google\Rpc\Status;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group core
 */
class GapicRequestWrapperTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @dataProvider responseProvider
     */
    public function testSuccessfullySendsRequest($response, $expectedMessage)
    {
        $serializer = $this->prophesize(Serializer::class);
        $serializer->encodeMessage(Argument::type(Http::class))
            ->willReturn($expectedMessage);

        $requestWrapper = new GapicRequestWrapper(['serializer' => $serializer->reveal()]);
        $args = [
            ['retrySettings' => []],    // required args
            []                          // optional args
        ];

        $actualResponse = $requestWrapper->send(
            function ($options) use ($response, $args) {
                $this->assertEquals(
                    $args[0]['retrySettings'],
                    $options['retrySettings']
                );

                return $response;
            },
            $args
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

        return [
            [$message, $expectedMessage],
            [$pagedMessage->reveal(), $expectedMessage],
            [null, null]
        ];
    }

    public function testThrowsExceptionWhenRequestFails()
    {
        $this->expectException(GoogleException::class);

        $requestWrapper = new GapicRequestWrapper();

        $requestWrapper->send(function () {
            throw new ApiException(
                'message',
                \Google\Rpc\Code::NOT_FOUND,
                \Google\ApiCore\ApiStatus::NOT_FOUND
            );
        }, [[]]);
    }

    public function testReturnsOperationResponse()
    {
        $requestWrapper = new GapicRequestWrapper();
        $response = $requestWrapper->send(function () {
            $op = $this->prophesize(OperationResponse::class);

            return $op->reveal();
        }, [[]]);

        $this->assertInstanceOf(OperationResponse::class, $response);
    }

    /**
     * @group stream
     *
     * @return void
     */
    public function testReturnsStreamedResponse()
    {
        $requestWrapper = new GapicRequestWrapper();

        $status = new Status(['code' => Code::CANCELLED]);
        $expected = (new Serializer)->encodeMessage($status);

        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->willReturn(new \ArrayIterator([
            $status,
            $status,
            $status
        ]));

        $res = $requestWrapper->send(function () use ($stream) {
            return $stream->reveal();
        }, [[]]);

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
        $requestWrapper = new GapicRequestWrapper();

        try {
            $requestWrapper->send(function () use ($code) {
                $status = ApiStatus::statusFromRpcCode($code);
                throw new ApiException('message', $code, $status);
            }, [[]], ['retries' => 0]);
        } catch (\Exception $ex) {
            $this->assertInstanceOf($expectedException, $ex);
        }
    }

    public function exceptionProvider()
    {
        return [
            [Code::INVALID_ARGUMENT, Exception\BadRequestException::class],
            [Code::NOT_FOUND, Exception\NotFoundException::class],
            [Code::UNIMPLEMENTED, Exception\NotFoundException::class],
            [Code::ALREADY_EXISTS, Exception\ConflictException::class],
            [Code::FAILED_PRECONDITION, Exception\FailedPreconditionException::class],
            [Code::UNKNOWN, Exception\ServerException::class],
            [Code::INTERNAL, Exception\ServerException::class],
            [Code::ABORTED, Exception\AbortedException::class],
            [Code::DEADLINE_EXCEEDED, Exception\DeadlineExceededException::class],
            [999, Exception\ServiceException::class]
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

        $otherMetadata = new PreconditionFailure;

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

        $requestWrapper = new GapicRequestWrapper();

        try {
            $requestWrapper->send(function () use ($e) {
                throw $e;
            }, [[]], ['retries' => 0]);

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
