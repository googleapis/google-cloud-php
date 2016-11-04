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

namespace Google\Cloud\Tests;

use Google\Cloud\RequestWrapper;
use Google\Cloud\ServiceBuilder;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;

/**
 * @group root
 */
class RequestWrapperTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccessfullySendsRequest()
    {
        $expectedBody = 'responseBody';
        $response = new Response(200, [], $expectedBody);

        $requestWrapper = new RequestWrapper([
            'accessToken' => 'abc',
            'httpHandler' => function ($request, $options = []) use ($response) {
                return $response;
            }
        ]);

        $actualResponse = $requestWrapper->send(
            new Request('GET', 'http://www.test.com')
        );

        $this->assertEquals($expectedBody, (string) $actualResponse->getBody());
    }

    /**
     * @expectedException Google\Cloud\Exception\GoogleException
     */
    public function testThrowsExceptionWhenRequestFails()
    {
        $requestWrapper = new RequestWrapper([
            'accessToken' => 'abc',
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception();
            }
        ]);

        $requestWrapper->send(new Request('GET', 'http://wwww.example.com'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionWithInvalidCredentialsFetcher()
    {
        $credentialsFetcher = new \stdClass();

        $requestWrapper = new RequestWrapper([
            'credentialsFetcher' => $credentialsFetcher
        ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionWithInvalidCache()
    {
        $cache = new \stdClass();

        $requestWrapper = new RequestWrapper([
            'authCache' => $cache
        ]);
    }

    /**
     * @dataProvider credentialsProvider
     */
    public function testCredentialsFetcher($wrapperConfig)
    {
        $requestWrapper = new RequestWrapper($wrapperConfig);

        $this->assertInstanceOf(
            'Google\Auth\FetchAuthTokenInterface',
            $requestWrapper->getCredentialsFetcher()
        );
    }

    /**
     * @dataProvider keyFileCredentialsProvider
     */
    public function testCredentialsFromKeyFileStreamCanBeReadMultipleTimes($wrapperConfig)
    {
        $requestWrapper = new RequestWrapper($wrapperConfig);

        $requestWrapper->getCredentialsFetcher();
        $credentials = $requestWrapper->getCredentialsFetcher();

        $this->assertInstanceOf('Google\Auth\FetchAuthTokenInterface', $credentials);
    }

    public function credentialsProvider()
    {
        $config = [
            'authHttpHandler' => function ($request, $options = []) {
                return new Response(200, [], json_encode(['access_token' => 'abc']));
            },
            'httpHandler' => function ($request, $options = []) {
                return new Response(200, []);
            }
        ];

        $keyFilePath = __DIR__ . '/fixtures/json-key-fixture.json';
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$keyFilePath"); // for application default credentials

        $credentialsFetcher = $this->prophesize('Google\Auth\FetchAuthTokenInterface');
        $credentialsFetcher->fetchAuthToken(Argument::any())
            ->willReturn(['access_token' => 'abc']);

        return [
            [$config + ['keyFile' => json_decode(file_get_contents($keyFilePath), true)]], // keyFile
            [$config + ['keyFilePath' => $keyFilePath]], //keyFilePath
            [$config + ['credentialsFetcher' => $credentialsFetcher->reveal()]], // user supplied fetcher
            [$config] // application default
        ];
    }

    public function keyFileCredentialsProvider()
    {
        $config = [
            'authHttpHandler' => function ($request, $options = []) {
                return new Response(200, [], json_encode(['access_token' => 'abc']));
            },
            'httpHandler' => function ($request, $options = []) {
                return new Response(200, []);
            }
        ];

        $keyFilePath = __DIR__ . '/fixtures/json-key-fixture.json';

        return [
            [$config + ['keyFile' => json_decode(file_get_contents($keyFilePath), true)]], // keyFile
            [$config + ['keyFilePath' => $keyFilePath]], //keyFilePath
        ];
    }

    public function testAddsUserAgentToRequest()
    {
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                $userAgent = $request->getHeaderLine('User-Agent');
                $this->assertEquals('gcloud-php/' . ServiceBuilder::VERSION, $userAgent);
                return new Response(200);
            },
            'accessToken' => 'abc'
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testAddsTokenToRequest()
    {
        $accessToken = 'abc';
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) use ($accessToken) {
                $authHeader = $request->getHeaderLine('Authorization');
                $this->assertEquals('Bearer ' . $accessToken, $authHeader);
                return new Response(200);
            },
            'accessToken' => $accessToken
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    /**
     * @expectedException Google\Cloud\Exception\GoogleException
     */
    public function testThrowsExceptionWhenFetchingCredentialsFails()
    {
        $requestWrapper = new RequestWrapper([
            'authHttpHandler' => function ($request, $options = []) {
                throw new \Exception();
            },
            'httpHandler' => function ($request, $options = []) {
                return new Response(200);
            }
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testExceptionMessageIsNotTruncatedWithGuzzle()
    {
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                $msg = str_repeat('0', 121);

                throw new RequestException(
                    $msg,
                    $request,
                    new Response(400, [], $msg)
                );
            }
        ]);

        try {
            $requestWrapper->send(
                new Request('GET', 'http://www.example.com')
            );
        } catch (\Exception $ex) {
            $this->assertTrue(strlen($ex->getMessage()) > 120);
        }
    }

    /**
     * @expectedException Google\Cloud\Exception\BadRequestException
     */
    public function testThrowsBadRequestException()
    {
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception('', 400);
            }
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    /**
     * @expectedException Google\Cloud\Exception\NotFoundException
     */
    public function testThrowsNotFoundException()
    {
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception('', 404);
            }
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    /**
     * @expectedException Google\Cloud\Exception\ConflictException
     */
    public function testThrowsConflictException()
    {
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception('', 409);
            }
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    /**
     * @expectedException Google\Cloud\Exception\ServerException
     */
    public function testThrowsServerException()
    {
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception('', 500);
            },
            'retries' => 0
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testThrowsExceptionWithNonRetryableError()
    {
        $nonRetryableErrorMessage = '{"error": {"errors": [{"reason": "notAGoodEnoughReason"}]}}';
        $actualAttempts = 0;
        $hasTriggeredException = false;
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function () use (&$actualAttempts, $nonRetryableErrorMessage) {
                $actualAttempts++;
                throw new \Exception($nonRetryableErrorMessage, 429);
            }
        ]);
        try {
            $requestWrapper->send(
                new Request('GET', 'http://www.example.com')
            );
        } catch (\Exception $ex) {
            $hasTriggeredException = true;
        }

        $this->assertTrue($hasTriggeredException);
        $this->assertEquals(1, $actualAttempts);
    }
}
