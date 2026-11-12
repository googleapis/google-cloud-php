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

use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Call;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\ApiCore\Transport\TransportInterface;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\PublishResponse;
use Google\Cloud\SecretManager\V1\AccessSecretVersionResponse;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\SecretPayload;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Google\Rpc\Code;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\RequestInterface;

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

    public function testDrivingFibersWithCurlMultiHandler()
    {
        $snippet = $this->snippetFromMarkdown(
            self::ASYNC_FILE,
            'Driving Fibers with `CurlMultiHandler`'
        );

        $pendingResolvers = [];
        $fakeCurlMulti = new class($pendingResolvers) {
            private array $resolvers;

            public function __construct(array &$resolvers)
            {
                $this->resolvers = &$resolvers;
            }

            public function tick(): void
            {
                while ($resolver = array_shift($this->resolvers)) {
                    $resolver();
                }
            }
        };

        $mockHandler = function (RequestInterface $request) use (&$pendingResolvers) {
            $promise = new Promise();
            $pendingResolvers[] = static function () use ($promise, $request) {
                $parts = explode('/', trim($request->getUri()->getPath(), '/'));
                $secretId = $parts[4] ?? 'unknown';
                $body = json_encode([
                    'name' => "projects/my-project/secrets/$secretId/versions/1",
                    'payload' => ['data' => base64_encode("fiber-$secretId")],
                ]);
                $promise->resolve(new Response(200, ['Content-Type' => 'application/json'], $body));
            };
            return $promise;
        };

        $httpClient = new Client(['handler' => HandlerStack::create($mockHandler)]);

        $snippet->addUse(InsecureCredentialsWrapper::class);
        $snippet->replace(
            <<<'PHP'
$curlMulti = new CurlMultiHandler(['select_timeout' => 0.01]);
$httpClient = new Client(['handler' => HandlerStack::create($curlMulti)]);
PHP,
            ''
        );
        $snippet->replace(
            "'transport' => 'rest',",
            "'transport' => 'rest',\n    'credentials' => new InsecureCredentialsWrapper(),"
        );
        $snippet->addLocal('curlMulti', $fakeCurlMulti);
        $snippet->addLocal('httpClient', $httpClient);

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
