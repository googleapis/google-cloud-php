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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Core\Exception;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\GAX\ApiException;
use Google\GAX\Page;
use Google\GAX\PagedListResponse;
use Google\GAX\Serializer;
use Google\Protobuf\Internal\Message;
use Prophecy\Argument;

/**
 * @group core
 */
class GrpcRequestWrapperTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    public function setUp()
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
                $this->assertEquals($requestOptions['requestTimeout'] * 1000, $options['timeoutMs']);
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
        $message = $this->prophesize(Message::class);
        $serializer = $this->prophesize(Serializer::class);
        $serializer->encodeMessage($message->reveal())->willReturn($expectedMessage);
        $pagedMessage = $this->prophesize(PagedListResponse::class);
        $page = $this->prophesize(Page::class);
        $page->getResponseObject()->willReturn($message->reveal());
        $pagedMessage->getPage()->willReturn($page->reveal());

        return [
            [$message->reveal(), $expectedMessage, $serializer->reveal()],
            [$pagedMessage->reveal(), $expectedMessage, $serializer->reveal()],
            [null, null, $serializer->reveal()]
        ];
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testThrowsExceptionWhenRequestFails()
    {
        $requestWrapper = new GrpcRequestWrapper();

        $requestWrapper->send(function () {
            throw new ApiException('message', 5);
        }, [[]]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionWithInvalidCredentialsFetcher()
    {
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
        $keyFilePath = __DIR__ . '/../fixtures/json-key-fixture.json';
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
        $keyFilePath = __DIR__ . '/../fixtures/json-key-fixture.json';

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
                throw new ApiException('message', $code);
            }, [[]], ['retries' => 0]);
        } catch (\Exception $ex) {
            $this->assertInstanceOf($expectedException, $ex);
        }
    }

    public function exceptionProvider()
    {
        return [
            [3, Exception\BadRequestException::class],
            [5, Exception\NotFoundException::class],
            [12, Exception\NotFoundException::class],
            [6, Exception\ConflictException::class],
            [9, Exception\FailedPreconditionException::class],
            [2, Exception\ServerException::class],
            [13, Exception\ServerException::class],
            [10, Exception\AbortedException::class],
            [999, Exception\ServiceException::class]
        ];
    }
}
