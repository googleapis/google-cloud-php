<?php

/**
 * Copyright 2015 Google Inc.
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
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Core\Exception;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Rpc\BadRequest;
use Google\Rpc\BadRequest\FieldViolation;
use Google\Rpc\Code;
use Google\Rpc\PreconditionFailure;
use Google\Rpc\Status;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 */
class GrpcRequestWrapperTest extends TestCase
{
    use ExpectException;
    use GrpcTestTrait;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();
    }

    public function testGetKeyfile()
    {
        $kf = 'hello world';

        $requestWrapper = new GrpcRequestWrapper([
            'keyFile' => $kf
        ]);

        $this->assertEquals($kf, $requestWrapper->keyFile());
    }

    /**
     * @dataProvider responseProvider
     */
    public function testSuccessfullySendsRequest($response, $expectedMessage, $serializer)
    {
        $requestWrapper = new GrpcRequestWrapper(['serializer' => $serializer]);
        $requestOptions = [
            'requestTimeout' => 3.5
        ];

        $actualResponse = $requestWrapper->send(
            function ($test, $options) use ($response, $requestOptions) {
                $this->assertEquals(
                    $requestOptions['requestTimeout'] * 1000,
                    $options['retrySettings']['noRetriesRpcTimeoutMillis']
                );

                return $response;
            },
            ['test', []],
            $requestOptions
        );

        $this->assertEquals($expectedMessage, $actualResponse);
    }

    public function responseProvider()
    {
        if ($this->shouldSkipGrpcTests()) {
            return [];
        }
        $expectedMessage = ['successful' => 'request'];
        $message = new Http();
        $serializer = $this->prophesize(Serializer::class);
        $serializer->encodeMessage($message)->willReturn($expectedMessage);
        $pagedMessage = $this->prophesize(PagedListResponse::class);
        $page = $this->prophesize(Page::class);
        $page->getResponseObject()->willReturn($message);
        $pagedMessage->getPage()->willReturn($page->reveal());

        return [
            [$message, $expectedMessage, $serializer->reveal()],
            [$pagedMessage->reveal(), $expectedMessage, $serializer->reveal()],
            [null, null, $serializer->reveal()]
        ];
    }

    public function testThrowsExceptionWhenRequestFails()
    {
        $this->expectException('Google\Cloud\Core\Exception\GoogleException');

        $requestWrapper = new GrpcRequestWrapper();

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
        $requestWrapper = new GrpcRequestWrapper();

        $this->assertInstanceOf(OperationResponse::class, $requestWrapper->send(function () {
            $op = $this->prophesize(OperationResponse::class);

            return $op->reveal();
        }, [[]]));
    }

    /**
     * @group stream
     *
     * @return void
     */
    public function testReturnsStreamedResponse()
    {
        $requestWrapper = new GrpcRequestWrapper();

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

    public function testThrowsExceptionWithInvalidCredentialsFetcher()
    {
        $this->expectException('InvalidArgumentException');

        $credentialsFetcher = new \stdClass();

        $requestWrapper = new GrpcRequestWrapper([
            'credentialsFetcher' => $credentialsFetcher
        ]);
    }

    /**
     * @dataProvider credentialsProvider
     */
    public function testCredentialsFetcher($wrapperConfig)
    {
        $requestWrapper = new GrpcRequestWrapper($wrapperConfig);

        $this->assertInstanceOf(
            FetchAuthTokenInterface::class,
            $requestWrapper->getCredentialsFetcher()
        );
    }

    /**
     * @dataProvider keyFileCredentialsProvider
     */
    public function testCredentialsFromKeyFileStreamCanBeReadMultipleTimes($wrapperConfig)
    {
        $requestWrapper = new GrpcRequestWrapper($wrapperConfig);

        $requestWrapper->getCredentialsFetcher();
        $credentials = $requestWrapper->getCredentialsFetcher();

        $this->assertInstanceOf(FetchAuthTokenInterface::class, $credentials);
    }

    public function credentialsProvider()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$keyFilePath"); // for application default credentials

        $credentialsFetcher = $this->prophesize(FetchAuthTokenInterface::class);

        return [
            [['keyFile' => json_decode(file_get_contents($keyFilePath), true)]], // keyFile
            [['keyFilePath' => $keyFilePath]], //keyFilePath
            [['credentialsFetcher' => $credentialsFetcher->reveal()]], // user supplied fetcher
            [[]] // application default
        ];
    }

    public function keyFileCredentialsProvider()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();

        return [
            [['keyFile' => json_decode(file_get_contents($keyFilePath), true)]], // keyFile
            [['keyFilePath' => $keyFilePath]], //keyFilePath
        ];
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testCastsToProperException($code, $expectedException)
    {
        $requestWrapper = new GrpcRequestWrapper();

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

        $requestWrapper = new GrpcRequestWrapper();

        try {
            $requestWrapper->send(function () use ($e) {
                throw $e;
            }, [[]], ['retries' => 0]);

            $this->assertFalse(true, 'Exception not thrown!');
        } catch (\Exception $ex) {
            $this->assertEquals(
                json_decode($metadata->serializeToJsonString(), true),
                $ex->getMetadata()[0]
            );

            // Assert only whitelisted types are included.
            $this->assertCount(1, $ex->getMetadata());
        }
    }
}
