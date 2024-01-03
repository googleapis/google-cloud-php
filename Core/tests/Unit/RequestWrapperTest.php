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

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\FetchAuthTokenCache;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\GetUniverseDomainInterface;
use Google\Auth\UpdateMetadataInterface;
use Google\Cloud\Core\AnonymousCredentials;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServerException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\RequestWrapper;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group core
 */
class RequestWrapperTest extends TestCase
{
    use ProphecyTrait;

    const VERSION = 'v0.1';

    private static $requestOptions = [
        'restOptions' => ['debug' => true],
        'requestTimeout' => 3.5
    ];

    public function testSuccessfullySendsRequest()
    {
        $expectedBody = 'responseBody';
        $response = new Response(200, [], $expectedBody);

        $requestWrapper = new RequestWrapper([
            'accessToken' => 'abc',
            'httpHandler' => function ($request, $options = []) use ($response) {
                $this->assertEquals(self::$requestOptions['restOptions']['debug'], $options['debug']);
                $this->assertEquals(self::$requestOptions['requestTimeout'], $options['timeout']);
                return $response;
            }
        ]);

        $actualResponse = $requestWrapper->send(
            new Request('GET', 'http://www.example.com'),
            self::$requestOptions
        );

        $this->assertEquals($expectedBody, (string) $actualResponse->getBody());
    }

    public function testSuccessfullySendsAsyncRequest()
    {
        $expectedBody = 'responseBody';
        $response = new Response(200, [], $expectedBody);

        $requestWrapper = new RequestWrapper([
            'accessToken' => 'abc',
            'asyncHttpHandler' => function ($request, $options = []) use ($response) {
                $this->assertEquals(self::$requestOptions['restOptions']['debug'], $options['debug']);
                $this->assertEquals(self::$requestOptions['requestTimeout'], $options['timeout']);
                return Create::promiseFor($response);
            }
        ]);

        $actualPromise = $requestWrapper->sendAsync(
            new Request('GET', 'http://www.example.com'),
            self::$requestOptions
        );

        $this->assertInstanceOf(PromiseInterface::class, $actualPromise);
        $this->assertEquals(
            $expectedBody,
            (string) $actualPromise
                ->wait()
                ->getBody()
        );
    }

    public function testSendAsyncRetriesOnFailure()
    {
        $actualDelays = 0;
        $expectedRetries = 5;
        $requestWrapper = new RequestWrapper([
            'retries' => $expectedRetries,
            'accessToken' => 'abc',
            'restRetryFunction' => function () {
                return true; // always retry
            },
            'restDelayFunction' => function ($delay) use (&$actualDelays) {
                // instead of actually delaying, just mark that we attempted
                // a retry
                $actualDelays++;
            },
            'asyncHttpHandler' => function ($request, $options = []) {
                return Create::rejectionFor(new \Exception());
            }
        ]);

        $promise = $requestWrapper->sendAsync(new Request('GET', 'http://www.example.com'))
            ->then(null, function (\Exception $ex) {
                $this->assertInstanceOf(ServiceException::class, $ex);
            })->wait();

        $this->assertEquals($expectedRetries, $actualDelays);
    }

    public function testGetKeyfile()
    {
        $kf = 'hello world';

        $requestWrapper = new RequestWrapper([
            'keyFile' => $kf
        ]);

        $this->assertEquals($kf, $requestWrapper->keyFile());
    }

    public function testThrowsExceptionWhenRequestFails()
    {
        $this->expectException(GoogleException::class);

        $requestWrapper = new RequestWrapper([
            'accessToken' => 'abc',
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception();
            }
        ]);

        $requestWrapper->send(new Request('GET', 'http://wwww.example.com'));
    }

    public function testThrowsExceptionWithInvalidCredentialsFetcher()
    {
        $this->expectException(InvalidArgumentException::class);

        $credentialsFetcher = new \stdClass();

        $requestWrapper = new RequestWrapper([
            'credentialsFetcher' => $credentialsFetcher
        ]);
    }

    public function testThrowsExceptionWithInvalidCache()
    {
        $this->expectException(InvalidArgumentException::class);

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
            FetchAuthTokenInterface::class,
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

        $this->assertInstanceOf(FetchAuthTokenInterface::class, $credentials);
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

        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$keyFilePath"); // for application default credentials

        $credentialsFetcher = $this->prophesize(FetchAuthTokenInterface::class);
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

        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();

        return [
            [$config + ['keyFile' => json_decode(file_get_contents($keyFilePath), true)]], // keyFile
            [$config + ['keyFilePath' => $keyFilePath]], //keyFilePath
        ];
    }

    public function testAddsUserAgentAndXGoogApiClientToRequest()
    {
        $requestWrapper = new RequestWrapper([
            'componentVersion' => self::VERSION,
            'httpHandler' => function ($request, $options = []) {
                $userAgent = $request->getHeaderLine('User-Agent');
                $this->assertEquals('gcloud-php/' . self::VERSION, $userAgent);
                $xGoogApiClient = $request->getHeaderLine('x-goog-api-client');
                $this->assertEquals('gl-php/' . phpversion() . ' gccl/' . self::VERSION, $xGoogApiClient);
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
                $authHeader = $request->getHeaderLine('authorization');
                $this->assertEquals('Bearer ' . $accessToken, $authHeader);
                return new Response(200);
            },
            'accessToken' => $accessToken
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testRequestUsesApiKeyInsteadOfAuthHeader()
    {
        $version = '1.0.0';
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) use ($version) {
                $authHeader = $request->getHeaderLine('authorization');
                $userAgent = $request->getHeaderLine('User-Agent');
                $xGoogApiClient = $request->getHeaderLine('x-goog-api-client');
                $this->assertEquals('gcloud-php/' . $version, $userAgent);
                $this->assertEquals('gl-php/' . phpversion() . ' gccl/' . $version, $xGoogApiClient);
                $this->assertEmpty($authHeader);
                return new Response(200);
            },
            'shouldSignRequest' => false,
            'componentVersion' => $version
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testThrowsExceptionWhenFetchingCredentialsFails()
    {
        $this->expectException(GoogleException::class);

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
                $jsonMsg = '{"msg":"' . $msg . '"}';

                throw new RequestException(
                    $jsonMsg,
                    $request,
                    new Response(400, [], $jsonMsg)
                );
            }
        ]);

        try {
            $requestWrapper->send(
                new Request('GET', 'http://www.example.com')
            );
        } catch (\Exception $ex) {
            $this->assertGreaterThan(120, strlen($ex->getMessage()));
        }
    }

    public function testThrowsBadRequestException()
    {
        $this->expectException(BadRequestException::class);

        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception('', 400);
            }
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testThrowsNotFoundException()
    {
        $this->expectException(NotFoundException::class);

        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception('', 404);
            }
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testThrowsConflictException()
    {
        $this->expectException(ConflictException::class);

        $requestWrapper = new RequestWrapper([
            'httpHandler' => function ($request, $options = []) {
                throw new \Exception('', 409);
            }
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testThrowsServerException()
    {
        $this->expectException(ServerException::class);

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

    public function testRestCalcDelayFunctionIsProperlySet()
    {
        $hasTriggeredException = false;
        $actualDelay = 0;
        $expectedDelay = 100;
        $requestWrapper = new RequestWrapper([
            'retries' => 1,
            'httpHandler' => function () {
                throw new \Exception;
            },
            'restRetryFunction' => function () {
                return true;
            },
            'restDelayFunction' => function ($delay) use (&$actualDelay) {
                $actualDelay = $delay;
            },
            'restCalcDelayFunction' => function () use ($expectedDelay) {
                return $expectedDelay;
            },
            'shouldSignRequest' => false
        ]);

        try {
            $requestWrapper->send(
                new Request('GET', 'http://www.example.com')
            );
        } catch (\Exception $ex) {
            $hasTriggeredException = true;
        }

        $this->assertTrue($hasTriggeredException);
        $this->assertEquals($expectedDelay, $actualDelay);
    }

    public function testDisablesRequestSigningWithAnonymousCredentials()
    {
        $headers = [];
        $requestWrapper = new RequestWrapper([
            'credentialsFetcher' => new AnonymousCredentials(),
            'httpHandler' => function ($request, array $options = []) use (&$headers) {
                $headers = $request->getHeaders();

                return new Response(200);
            }
        ]);
        $requestWrapper->send(new Request('GET', 'http://www.example.com'));

        $this->assertArrayNotHasKey('authorization', $headers);
    }

    public function testDefaultToAnonymousCredentialsWhenNoOthersExist()
    {
        $requestWrapper = new RequestWrapperStub();
        $fetcher = $requestWrapper->getCredentialsFetcher();

        $this->assertInstanceOf(FetchAuthTokenInterface::class, $fetcher);
        $this->assertNull($fetcher->fetchAuthToken()['access_token']);
    }

    public function testSetsQuotaProjectOnCredentialsWithKeyFile()
    {
        $quotaProject = 'test-quota-project';
        $requestWrapper = new RequestWrapper([
            'quotaProject' => $quotaProject,
            'keyFile' => json_decode(file_get_contents(Fixtures::JSON_KEY_FIXTURE()), true)
        ]);

        $this->assertEquals(
            $quotaProject,
            $requestWrapper->getCredentialsFetcher()->getQuotaProject()
        );
    }

    public function testSetsQuotaProjectOnCredentialsWithADC()
    {
        $quotaProject = 'test-quota-project';
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$keyFilePath");
        $requestWrapper = new RequestWrapper([
            'quotaProject' => $quotaProject
        ]);

        $this->assertEquals(
            $quotaProject,
            $requestWrapper->getCredentialsFetcher()->getQuotaProject()
        );
    }

    public function testUserProvidedQuotaProjectTakesPrecedentOverKeyFile()
    {
        $quotaProject = 'test-quota-project';
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        $keyFile = json_decode(file_get_contents($keyFilePath), true);
        $keyFile['quota_project_id'] = 'do-not-use-this';

        $requestWrapper = new RequestWrapper([
            'quotaProject' => $quotaProject,
            'keyFile' => $keyFile,
            'authHttpHandler' => function ($request, $options = []) {
                return new Response(200, [], json_encode(['access_token' => 'abc']));
            },
            'httpHandler' => function ($request, $options = []) use ($quotaProject) {
                $userProject = $request->getHeaderLine('X-Goog-User-Project');
                $this->assertEquals($quotaProject, $userProject);
                return new Response(200);
            },
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testAddsQuotaProjectHeaderToRequest()
    {
        $quotaProject = 'test-quota-project';
        $requestWrapper = new RequestWrapper([
            'quotaProject' => $quotaProject,
            'httpHandler' => function ($request, $options = []) use ($quotaProject) {
                $userProject = $request->getHeaderLine('X-Goog-User-Project');
                $this->assertEquals($quotaProject, $userProject);
                return new Response(200);
            },
            'accessToken' => 'abc'
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testUsesSelfSignedJwtWithScopeByDefault()
    {
        $keyFile = [
            'type' => 'service_account',
            'client_email' => '123@abc.com',
            'private_key' => openssl_pkey_new(),
        ];
        $requestWrapper = new RequestWrapper([
            'keyFile' => $keyFile,
            'scopes' => 'abc 123',
        ]);
        $fetcherCache = $requestWrapper->getCredentialsFetcher();

        // Assert Cache Wrapper
        $this->assertInstanceOf(FetchAuthTokenCache::class, $fetcherCache);

        // Assert Service Account Credentials
        $cacheRefClass = new \ReflectionClass($fetcherCache);
        $cacheProp = $cacheRefClass->getProperty('fetcher');
        $cacheProp->setAccessible(true);
        $fetcher = $cacheProp->getValue($fetcherCache);
        $this->assertInstanceOf(ServiceAccountCredentials::class, $fetcher);

        // Assert "JWT Access With Scope" is enabled by default
        $fetcherRefClass = new \ReflectionClass($fetcher);
        $fetcherProp = $fetcherRefClass->getProperty('useJwtAccessWithScope');
        $fetcherProp->setAccessible(true);
        $this->assertTrue($fetcherProp->getValue($fetcher));

        // Assert a JWT token is created without using HTTP
        $httpHandler = function ($request, $options = []) {
            $this->fail('A network request should not be utilized.');
        };
        $token = $fetcher->fetchAuthToken($httpHandler);
        $this->assertNotNull($token);
        $this->assertArrayHasKey('access_token', $token);

        // Assert the token is a JWT with the proper scopes
        $parts = explode('.', $token['access_token']);
        $this->assertCount(3, $parts);
        $payload = json_decode(base64_decode($parts[1]), true);
        $this->assertArrayHasKey('scope', $payload);
        $this->assertEquals('abc 123', $payload['scope']);
    }

    public function testEmptyTokenThrowsException()
    {
        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('Unable to fetch token');

        $credentialsFetcher = $this->prophesize(FetchAuthTokenInterface::class);

        // Set the response to an empty array (no token)
        $credentialsFetcher->fetchAuthToken(Argument::any())
            ->willReturn([]);

        // We have to mock this message because RequestWrapper wraps the credentials using the
        // FetchAuthTokenCache class
        $credentialsFetcher->getCacheKey()
            ->willReturn(null);

        $requestWrapper = new RequestWrapper([
            'credentialsFetcher' => $credentialsFetcher->reveal(),
        ]);

        $requestWrapper->send(new Request('GET', 'http://www.example.com'));
    }

    /**
     * This test asserts that the retry related options and callbacks are
     * properly mapped and set in the RequestWrapper's `$requestOptions`
     * property.
     */
    public function testPassingInRetryOptions()
    {
        $attempt = 0;
        $retryFunctionCalled = false;
        $retryListenerCalled = false;
        $options = [
            'restRetryFunction' => function () use (&$retryFunctionCalled) {
                $retryFunctionCalled = true;
                return true;
            },
            'restRetryListener' => function () use (&$retryListenerCalled) {
                $retryListenerCalled = true;
            },
        ];
        $request = new Request('GET', 'http://www.example.com');
        $requestWrapper = new RequestWrapper([
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
            'httpHandler' => function () use (&$attempt) {
                if ($attempt++ < 1) {
                    throw new \Exception('retry!');
                }
                return new Response(200, []);
            }
        ]);
        $requestWrapper->send($request, $options);

        $this->assertTrue($retryFunctionCalled);
        $this->assertTrue($retryListenerCalled);
    }

    public function testAuthHandlerPassingWithFetchAuthTokenInterface()
    {
        $authHttpHandler = function ($request, $options = []) {
        };
        $fetcher = $this->prophesize(FetchAuthTokenInterface::class);
        $fetcher->fetchAuthToken($authHttpHandler)
            ->shouldBeCalledOnce()
            ->willReturn(['access_token' => 'xyz']);
        $fetcher->getCacheKey()
            ->shouldBeCalledTimes(2)
            ->willReturn(null);
        $wrapper = new RequestWrapper([
            'authHttpHandler' => $authHttpHandler,
            'credentialsFetcher' => $fetcher->reveal(),
        ]);

        $wrapper->send(new Request('GET', 'http://www.example.com'));
    }

    public function testAuthHandlerPassingWithUpdateMetadataInterface()
    {
        $authHttpHandler = function ($request, $options = []) {
        };
        $fetcher = $this->prophesize(FetchAuthTokenInterface::class);
        $fetcher->willImplement(UpdateMetadataInterface::class);
        $fetcher->updateMetadata(Argument::any(), Argument::any(), $authHttpHandler)
            ->shouldBeCalledOnce()
            ->willReturn([
                'authorization' => ['Bearer abc']
            ]);

        $fetcher = $this->prophesizeUpdateMetadataFetcher($fetcher);

        $wrapper = new RequestWrapper([
            'authHttpHandler' => $authHttpHandler,
            'credentialsFetcher' => $fetcher->reveal(),
        ]);

        $wrapper->send(new Request('GET', 'http://www.example.com'));
    }

    /**
     * Test to verify auth related headers fetching and updation if
     * credential fetcher implements UpdateMetadataInterface too, else
     * going ahead with access_code fetching followed by auth header
     * creation and updation.
     */
    public function testFetchingCredentialAsAuthHeader()
    {
        $credentialsFetcher = $this->prophesize(FetchAuthTokenInterface::class);
        $credentialsFetcher->willImplement(UpdateMetadataInterface::class);

        $accessToken = 'abc';
        $credentialsFetcher->updateMetadata(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn([
                'authorization' => ['Bearer ' . $accessToken]
            ]);

        $credentialsFetcher = $this->prophesizeUpdateMetadataFetcher($credentialsFetcher);

        $requestWrapper = new RequestWrapper([
            'credentialsFetcher' => $credentialsFetcher->reveal(),
            'httpHandler' => function ($request, $options = []) use ($accessToken) {
                $authHeader = $request->getHeaderLine('authorization');
                $this->assertEquals('Bearer ' . $accessToken, $authHeader);
                return new Response(200);
            }
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    public function testFetchingCredentialAsAuthHeaderWithOverlappingHeaders()
    {
        $credentialsFetcher = $this->prophesize(FetchAuthTokenInterface::class);
        $credentialsFetcher->willImplement(UpdateMetadataInterface::class);

        $accessToken = 'abc';
        $credentialsFetcher->updateMetadata(Argument::that(function ($arg) {
            return array_key_exists('x-goog-api-client', $arg);
        }), Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn([
                'authorization' => ['Bearer ' . $accessToken],
                'x-goog-api-client' => ['xyz']
            ]);

        $credentialsFetcher = $this->prophesizeUpdateMetadataFetcher($credentialsFetcher);

        $requestWrapper = new RequestWrapper([
            'credentialsFetcher' => $credentialsFetcher->reveal(),
            'httpHandler' => function ($request, $options = []) use ($accessToken) {
                $authHeader = $request->getHeaderLine('authorization');
                $this->assertEquals('Bearer ' . $accessToken, $authHeader);
                return new Response(200);
            },
        ]);

        $requestWrapper->send(
            new Request('GET', 'http://www.example.com')
        );
    }

    /**
     * @dataProvider provideCheckUniverseDomainFails
     */
    public function testCheckUniverseDomainFails(
        ?string $universeDomain,
        ?string $credentialsUniverse,
        string $message = null
    ) {
        $this->expectException(GoogleException::class);
        $this->expectExceptionMessage($message ?: sprintf(
            'The configured universe domain (%s) does not match the credential universe domain (%s)',
            is_null($universeDomain) ? GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN : $universeDomain,
            is_null($credentialsUniverse) ? GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN : $credentialsUniverse,
        ));
        $fetcher = $this->prophesize(FetchAuthTokenInterface::class);
        // When the $credentialsUniverse is null, the fetcher doesn't implement GetUniverseDomainInterface
        if (!is_null($credentialsUniverse)) {
            $fetcher->willImplement(GetUniverseDomainInterface::class);
            $fetcher->getUniverseDomain()->willReturn($credentialsUniverse);
        }
        $fetcher->getLastReceivedToken()->willReturn(null);

        $config = ['credentialsFetcher' => $fetcher->reveal()];
        // A null value here represents not passing in a universeDomain
        if (!is_null($universeDomain)) {
            $config['universeDomain'] = $universeDomain;
        }
        $requestWrapper = new RequestWrapper($config);
        // Send a fake request
        $requestWrapper->send(new Request('GET', 'http://www.example.com'));
    }

    public function provideCheckUniverseDomainFails()
    {
        return [
            ['foo.com', 'googleapis.com'],
            ['googleapis.com', 'foo.com'],
            ['googleapis.com', ''],
            ['', 'googleapis.com', 'The universe domain cannot be empty'],
            [null, 'foo.com'], // null in RequestWrapper will default to "googleapis.com"
            ['foo.com', null], // Credentials not implementing `GetUniverseDomainInterface` will have default universe
        ];
    }

    /**
     * @dataProvider provideCheckUniverseDomainPasses
     */
    public function testCheckUniverseDomainPasses(?string $universeDomain, ?string $credentialsUniverse)
    {
        $fetcher = $this->prophesize(FetchAuthTokenInterface::class);
        // When the $credentialsUniverse is null, the fetcher doesn't implement GetUniverseDomainInterface
        if (!is_null($credentialsUniverse)) {
            $fetcher->willImplement(GetUniverseDomainInterface::class);
            $fetcher->getUniverseDomain()->shouldBeCalledOnce()->willReturn($credentialsUniverse);
        }
        $fetcher->getLastReceivedToken()->willReturn(null);
        $fetcher->fetchAuthToken(Argument::any())->willReturn(['access_token' => 'abc']);
        $fetcher->getCacheKey()
            ->shouldBeCalledTimes(2)
            ->willReturn(null);

        $called = false;
        $config = [
            'credentialsFetcher' => $fetcher->reveal(),
            'httpHandler' => function (Request $request) use (&$called) {
                $headers = $request->getHeaders();
                $this->assertArrayHasKey('authorization', $headers);
                $this->assertEquals('Bearer abc', $headers['authorization'][0]);
                $called = true;
            }
        ];
        // A null value here represents not passing in a universeDomain
        if (!is_null($universeDomain)) {
            $config['universeDomain'] = $universeDomain;
        }
        $requestWrapper = new RequestWrapper($config);

        // send a fake request
        $requestWrapper->send(new Request('GET', 'http://www.example.com'));
        $this->assertTrue($called);
    }

    public function provideCheckUniverseDomainPasses()
    {
        return [
            [null, 'googleapis.com'], // null will default to "googleapis.com"
            ['foo.com', 'foo.com'],
            ['googleapis.com', 'googleapis.com'],
            ['googleapis.com', null],
        ];
    }

    private function prophesizeUpdateMetadataFetcher($credentialsFetcher)
    {
        // We have to mock this message because RequestWrapper wraps the credentials using the
        // FetchAuthTokenCache class
        $credentialsFetcher->getCacheKey()
            ->shouldBeCalledOnce()
            ->willReturn(null);

        // We have to mock this message because FetchAuthTokenCache class' updateMetadata()
        // internally calls getLastReceivedToken() as a part of token fetching.
        $credentialsFetcher->getLastReceivedToken()
            ->shouldBeCalledOnce()
            ->willReturn(null);

        return $credentialsFetcher;
    }
}

//@codingStandardsIgnoreStart
class RequestWrapperStub extends RequestWrapper
{
    protected function getADC()
    {
        throw new \DomainException('Not found');
    }
}
//@codingStandardsIgnoreEnd
