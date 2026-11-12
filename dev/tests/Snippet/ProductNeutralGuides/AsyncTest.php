<?php
/**
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\Dev\Tests\Snippet;

use Fiber;
use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Call;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\ApiCore\Transport\TransportInterface;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\Guzzle7HttpHandler;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\PublishResponse;
use Google\Cloud\SecretManager\V1\AccessSecretVersionResponse;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\ListSecretsRequest;
use Google\Cloud\SecretManager\V1\ListSecretsResponse;
use Google\Cloud\SecretManager\V1\Secret;
use Google\Cloud\SecretManager\V1\SecretPayload;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Google\Rpc\Code;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use ReflectionFunction;

/**
 * @group docs
 */
class AsyncTest extends SnippetTestCase
{
    use ProphecyTrait;

    private const ASYNC_FILE = __DIR__ . '/../../../../ASYNC.md';

    public function testWaitingOnMultipleRequests()
    {
        $snippet = $this->snippetFromMarkdown(
            self::ASYNC_FILE,
            'Waiting on Multiple Requests (`Utils::unwrap`)'
        );

        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::type(Call::class), Argument::type('array'))
            ->shouldBeCalledTimes(3)
            ->will(function (array $args) {
                /** @var Call $call */
                $call = $args[0];
                $name = $call->getMessage()->getName();
                $secretId = explode('/', $name)[3];
                $response = (new AccessSecretVersionResponse())
                    ->setName($name)
                    ->setPayload((new SecretPayload())->setData("val-$secretId"));
                return Create::promiseFor($response);
            });

        $client = new SecretManagerServiceClient([
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport->reveal(),
        ]);

        $snippet->replace(
            <<<'PHP'
$client = new SecretManagerServiceClient([
    // Works with both 'grpc' (default) and 'rest'
    'transport' => 'grpc',
]);
PHP,
            ''
        );
        $snippet->addLocal('client', $client);

        $result = $snippet->invoke();
        $this->assertEquals(
            <<<'EOF'
db-password: val-db-password
api-key: val-api-key
jwt-signing-key: val-jwt-signing-key

EOF,
            $result->output()
        );
    }

    public function testHandlingPartialFailures()
    {
        $snippet = $this->snippetFromMarkdown(
            self::ASYNC_FILE,
            'Handling Partial Failures (`Utils::settle`)'
        );

        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::type(Call::class), Argument::type('array'))
            ->will(function (array $args) {
                /** @var Call $call */
                $call = $args[0];
                $name = $call->getMessage()->getName();
                if (str_contains($name, '/missing/')) {
                    return Create::rejectionFor(
                        new ApiException('Secret not found', Code::NOT_FOUND, ApiStatus::NOT_FOUND)
                    );
                }
                $response = (new AccessSecretVersionResponse())
                    ->setName($name)
                    ->setPayload((new SecretPayload())->setData('secret-data'));
                return Create::promiseFor($response);
            });

        $client = new SecretManagerServiceClient([
            'credentials' => new InsecureCredentialsWrapper(),
            'disableRetries' => true,
            'transport' => $transport->reveal(),
        ]);

        $snippet->replace('$client = new SecretManagerServiceClient();', '');
        $snippet->addLocal('client', $client);

        $result = $snippet->invoke();
        $this->assertEquals(
            <<<'EOF'
existing succeeded: secret-data
missing failed: NOT_FOUND

EOF,
            $result->output()
        );
    }

    public function testLimitingConcurrency()
    {
        $snippet = $this->snippetFromMarkdown(
            self::ASYNC_FILE,
            'Limiting Concurrency (`EachPromise`)'
        );

        $inFlight = 0;
        $maxObservedInFlight = 0;

        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::type(Call::class), Argument::type('array'))
            ->shouldBeCalledTimes(5)
            ->will(function () use (&$inFlight, &$maxObservedInFlight) {
                $inFlight++;
                $maxObservedInFlight = max($maxObservedInFlight, $inFlight);
                $promise = new Promise(function () use (&$promise, &$inFlight) {
                    $inFlight--;
                    $promise->resolve((new PublishResponse())->setMessageIds(['msg-1']));
                });
                return $promise;
            });

        $publisher = new PublisherClient([
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport->reveal(),
        ]);

        $snippet->replace('$publisher = new PublisherClient();', '');
        $snippet->addLocal('publisher', $publisher);

        $result = $snippet->invoke();
        $this->assertLessThanOrEqual(2, $maxObservedInFlight);
        $this->assertEquals("Published 5 messages\n", $result->output());
    }

    public function testPaginatingConcurrently()
    {
        $snippet = $this->snippetFromMarkdown(
            self::ASYNC_FILE,
            'Paginating Concurrently'
        );

        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::type(Call::class), Argument::type('array'))
            ->shouldBeCalledTimes(3)
            ->will(function (array $args) {
                /** @var Call $call */
                $call = $args[0];
                /** @var ListSecretsRequest $request */
                $request = $call->getMessage();
                $parent = $request->getParent();
                $token = $request->getPageToken();

                if ($parent === 'projects/proj-a' && $token === '') {
                    return Create::promiseFor(
                        (new ListSecretsResponse())
                            ->setSecrets([
                                (new Secret())->setName('projects/proj-a/secrets/s1'),
                                (new Secret())->setName('projects/proj-a/secrets/s2'),
                            ])
                            ->setNextPageToken('page-2')
                    );
                }

                if ($parent === 'projects/proj-a' && $token === 'page-2') {
                    return Create::promiseFor(
                        (new ListSecretsResponse())
                            ->setSecrets([
                                (new Secret())->setName('projects/proj-a/secrets/s3'),
                            ])
                    );
                }

                return Create::promiseFor(
                    (new ListSecretsResponse())
                        ->setSecrets([
                            (new Secret())->setName('projects/proj-b/secrets/s1'),
                        ])
                );
            });

        $client = new SecretManagerServiceClient([
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport->reveal(),
        ]);

        $snippet->replace(
            '$client = new SecretManagerServiceClient();',
            'global $testClient; $client = $testClient;'
        );
        global $testClient;
        $testClient = $client;

        $result = $snippet->invoke();
        $this->assertEquals(
            <<<'EOF'
projects/proj-a: 3 secrets
projects/proj-b: 1 secrets

EOF,
            $result->output()
        );
    }

    public function testHandwrittenClientHelpers()
    {
        $snippet = $this->snippetFromMarkdown(
            self::ASYNC_FILE,
            'Handwritten Client Helpers'
        );

        $obj1 = $this->prophesize(StorageObject::class);
        $obj1->name()->willReturn('report-1.txt');
        $obj2 = $this->prophesize(StorageObject::class);
        $obj2->name()->willReturn('report-2.txt');

        $bucket = $this->prophesize(Bucket::class);
        $bucket->uploadAsync('First report contents', ['name' => 'report-1.txt'])
            ->shouldBeCalledOnce()
            ->willReturn(Create::promiseFor($obj1->reveal()));
        $bucket->uploadAsync('Second report contents', ['name' => 'report-2.txt'])
            ->shouldBeCalledOnce()
            ->willReturn(Create::promiseFor($obj2->reveal()));

        $storage = $this->prophesize(StorageClient::class);
        $storage->bucket('my-bucket')->shouldBeCalledOnce()->willReturn($bucket->reveal());

        $snippet->replace('$storage = new StorageClient();', '');
        $snippet->addLocal('storage', $storage->reveal());

        $result = $snippet->invoke();
        $this->assertEquals(
            <<<'EOF'
Uploaded report-1.txt
Uploaded report-2.txt

EOF,
            $result->output()
        );
    }

    public function testConfigureRestClientWithFibers()
    {
        $snippet = $this->snippetFromMarkdown(
            self::ASYNC_FILE,
            '1. Configure the REST Client'
        );

        $creds = $this->prophesize(ServiceAccountCredentials::class);
        $snippet->addUse(MockHandler::class);
        $snippet->replace(
            'use Amp\Http\Client\GuzzleAdapter\GuzzleHandlerAdapter;',
            ''
        );
        $snippet->replace('new GuzzleHandlerAdapter()', 'new MockHandler()');
        $snippet->replace(
            "'transport' => 'rest',",
            "'transport' => 'rest',\n    'credentials' => \$creds,"
        );
        $snippet->addLocal('creds', $creds->reveal());

        $res = $snippet->invoke(['client', 'httpHandler']);
        [$client, $httpHandler] = $res->returnVal();

        $this->assertInstanceOf(SecretManagerServiceClient::class, $client);
        $this->assertInstanceOf(Guzzle7HttpHandler::class, $httpHandler);

        $cw = (new ReflectionClass($client))
            ->getProperty('credentialsWrapper')
            ->getValue($client);
        $authHttp = (new ReflectionClass($cw))
            ->getProperty('authHttpHandler')
            ->getValue($cw);
        $this->assertSame($httpHandler, $authHttp);

        $transport = (new ReflectionClass($client))
            ->getProperty('transport')
            ->getValue($client);
        $restHttpClosure = (new ReflectionClass($transport))
            ->getProperty('httpHandler')
            ->getValue($transport);
        $this->assertSame(
            $httpHandler,
            (new ReflectionFunction($restHttpClosure))->getClosureThis()
        );
    }

    public function testRunSynchronousCallsConcurrentlyInFibers()
    {
        if (!function_exists('Amp\async')) {
            eval(<<<'PHP'
namespace Amp {
    function async(callable $fn): \Fiber {
        $fiber = new \Fiber($fn);
        $fiber->start();
        return $fiber;
    }
}
namespace Amp\Future {
    function await(array $futures): array {
        global $drainFiberResolvers;
        ($drainFiberResolvers)();
        return array_map(static fn (\Fiber $f) => $f->getReturn(), $futures);
    }
}
PHP);
        }

        $pendingResolvers = [];
        global $drainFiberResolvers;
        $drainFiberResolvers = static function () use (&$pendingResolvers): void {
            // All 3 Fibers must have started and suspended before any response resolves
            while ($resolver = array_shift($pendingResolvers)) {
                $resolver();
                Utils::queue()->run();
            }
        };

        $mockAdapter = static function (
            RequestInterface $request
        ) use (&$pendingResolvers): PromiseInterface {
            $guzzlePromise = new Promise();
            $fiber = Fiber::getCurrent();
            $pendingResolvers[] = static function () use ($guzzlePromise, $request): void {
                $parts = explode('/', trim($request->getUri()->getPath(), '/'));
                $secretId = $parts[4] ?? 'unknown';
                $body = json_encode([
                    'name' => "projects/my-project/secrets/$secretId/versions/1",
                    'payload' => ['data' => base64_encode("fiber-$secretId")],
                ]);
                $guzzlePromise->resolve(
                    new Response(200, ['Content-Type' => 'application/json'], $body)
                );
            };

            return $promise = new Promise(
                static function () use (&$promise, $guzzlePromise, $fiber): void {
                    $guzzlePromise->then(
                        static fn () => $fiber && $fiber->isSuspended() && $fiber->resume(),
                        static fn () => $fiber && $fiber->isSuspended() && $fiber->resume()
                    );
                    if ($fiber && $guzzlePromise->getState() === PromiseInterface::PENDING) {
                        Fiber::suspend();
                    }
                    $promise->resolve($guzzlePromise->wait());
                }
            );
        };

        $httpClient = new Client(['handler' => HandlerStack::create($mockAdapter)]);
        $httpHandler = HttpHandlerFactory::build($httpClient);

        $client = new SecretManagerServiceClient([
            'transport' => 'rest',
            'credentials' => new InsecureCredentialsWrapper(),
            'transportConfig' => [
                'rest' => [
                    'httpHandler' => [$httpHandler, 'async'],
                ],
            ],
        ]);

        $snippet = $this->snippetFromMarkdown(
            self::ASYNC_FILE,
            '2. Run Synchronous Calls Concurrently'
        );
        $snippet->addLocal('client', $client);

        $result = $snippet->invoke();
        $this->assertEquals(
            <<<'EOF'
db-password: fiber-db-password
api-key: fiber-api-key
jwt-signing-key: fiber-jwt-signing-key

EOF,
            $result->output()
        );
    }
}
