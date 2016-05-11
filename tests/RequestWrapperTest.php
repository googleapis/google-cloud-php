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
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;

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

    public function testMultipleRequestsUseCachedCredentials()
    {
        $request = new Request('GET', 'http://www.example.com');
        $credentialsFetcher = $this->prophesize('Google\Auth\FetchAuthTokenInterface');
        $credentialsFetcher->fetchAuthToken(Argument::any())
            ->willReturn(['access_token' => 'abc'])
            ->shouldBeCalledTimes(1);

        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                return new Response(200, []);
            },
            'credentialsFetcher' => $credentialsFetcher->reveal()
        ]);

        $requestWrapper->send($request);
        $requestWrapper->send($request);
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
            [$config + ['keyFile' => file_get_contents($keyFilePath)]], // keyFile
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
            [$config + ['keyFile' => file_get_contents($keyFilePath)]], // keyFile
            [$config + ['keyFilePath' => $keyFilePath]], //keyFilePath
        ];
    }

    public function testAddsUserAgentToRequest()
    {
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                $userAgent = $request->getHeaderLine('User-Agent');
                $this->assertEquals('gcloud-php ' . ServiceBuilder::VERSION, $userAgent);
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
}
