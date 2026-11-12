# Asynchronous Requests and Concurrency

Every generated Google Cloud PHP V2 client (`*\Client\*Client`) provides an `*Async()` method alongside each synchronous RPC method—for example, `accessSecretVersionAsync()` alongside `accessSecretVersion()`. These methods return a [`GuzzleHttp\Promise\PromiseInterface`](https://github.com/guzzle/promises), allowing a single PHP process to execute multiple API calls concurrently over **both gRPC and REST**.

* **gRPC (`'transport' => 'grpc'`, default when `ext-grpc` is installed):** Calling `*Async()` immediately dispatches the RPC onto the `grpc` C extension's background network threads over multiplexed HTTP/2 streams.
* **REST (`'transport' => 'rest'`):** Calling `*Async()` registers the HTTP request with Guzzle's `CurlMultiHandler`, multiplexing concurrent transfers on a single thread via `curl_multi`.

## 1. Concurrent Requests with Promises

### Waiting on Multiple Requests (`Utils::unwrap`)

Use `GuzzleHttp\Promise\Utils::unwrap()` to execute an array of `*Async()` promises concurrently and return their responses keyed by the same array keys. If any request fails, `Utils::unwrap()` throws a `Google\ApiCore\ApiException` immediately.

```php
use Google\Cloud\SecretManager\V1\AccessSecretVersionRequest;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use GuzzleHttp\Promise\Utils;

$client = new SecretManagerServiceClient([
    // Works with both 'grpc' (default) and 'rest'
    'transport' => 'grpc',
]);

$secretIds = ['db-password', 'api-key', 'jwt-signing-key'];
$promises = [];

foreach ($secretIds as $secretId) {
    $versionName = SecretManagerServiceClient::secretVersionName(
        'my-project',
        $secretId,
        'latest'
    );
    $request = (new AccessSecretVersionRequest())->setName($versionName);

    // Starts the request without blocking
    $promises[$secretId] = $client->accessSecretVersionAsync($request);
}

// Wait for all in-flight requests to complete concurrently
$responses = Utils::unwrap($promises);

foreach ($responses as $secretId => $response) {
    printf("%s: %s\n", $secretId, $response->getPayload()->getData());
}
```

### Handling Partial Failures (`Utils::settle`)

When individual requests are allowed to fail without aborting the batch, use `Utils::settle()`. Each entry in the settled array contains `'state'` (`PromiseInterface::FULFILLED` or `PromiseInterface::REJECTED`) along with either `'value'` or `'reason'`.

```php
use Google\ApiCore\ApiException;
use Google\Cloud\SecretManager\V1\AccessSecretVersionRequest;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;

$client = new SecretManagerServiceClient();

$promises = [
    'existing' => $client->accessSecretVersionAsync(
        (new AccessSecretVersionRequest())->setName(
            SecretManagerServiceClient::secretVersionName('my-project', 'existing', 'latest')
        )
    ),
    'missing' => $client->accessSecretVersionAsync(
        (new AccessSecretVersionRequest())->setName(
            SecretManagerServiceClient::secretVersionName('my-project', 'missing', 'latest')
        )
    ),
];

$results = Utils::settle($promises)->wait();

foreach ($results as $key => $result) {
    if ($result['state'] === PromiseInterface::FULFILLED) {
        printf("%s succeeded: %s\n", $key, $result['value']->getPayload()->getData());
    } else {
        /** @var ApiException $error */
        $error = $result['reason'];
        printf("%s failed: %s\n", $key, $error->getStatus());
    }
}
```

### Limiting Concurrency (`EachPromise`)

Avoid creating thousands of `*Async()` promises up front in a loop, which opens excessive concurrent streams or hits API rate limits. Yield promises lazily from a generator into `GuzzleHttp\Promise\EachPromise` with a fixed `concurrency` cap.

```php
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\PubsubMessage;
use Google\Cloud\PubSub\V1\PublishRequest;
use Google\Cloud\PubSub\V1\PublishResponse;
use GuzzleHttp\Promise\EachPromise;

$publisher = new PublisherClient();
$topicName = PublisherClient::topicName('my-project', 'my-topic');
$payloads = ['event-1', 'event-2', 'event-3', 'event-4', 'event-5'];

$promiseGenerator = (function () use ($publisher, $topicName, $payloads) {
    foreach ($payloads as $payload) {
        $request = (new PublishRequest())
            ->setTopic($topicName)
            ->setMessages([
                (new PubsubMessage())->setData($payload),
            ]);

        yield $payload => $publisher->publishAsync($request);
    }
})();

$publishedCount = 0;
$eachPromise = new EachPromise($promiseGenerator, [
    // Keep at most 2 requests in flight at any time
    'concurrency' => 2,
    'fulfilled' => function (PublishResponse $response, string $payload) use (&$publishedCount) {
        $publishedCount += count($response->getMessageIds());
    },
]);

$eachPromise->promise()->wait();
printf("Published %d messages\n", $publishedCount);
```

## 2. Supported Call Types

| Call Type | `*Async()` Return Type | Behavior |
| :--- | :--- | :--- |
| **Unary** | `PromiseInterface<Message>` | Resolves to the protobuf response message. |
| **Paginated** | `PromiseInterface<PagedListResponse>` | Resolves the first page asynchronously. Iterating past the first page via `foreach` fetches subsequent pages synchronously; to paginate asynchronously, pass `pageToken` explicitly to `*Async()`. |
| **Long-Running Operation (LRO)** | `PromiseInterface<OperationResponse>` | Resolves once the server *starts* the operation. See [Core Concepts](https://docs.cloud.google.com/php/docs/reference/help/core_concepts) for polling LROs. |
| **Streaming & Resumable Uploads** | *Not supported* | Throws `ValidationException`. Use streaming methods (`ServerStream`, `ClientStream`, `BidiStream`) directly. |

### Handwritten Client Helpers

Most handwritten wrapper clients (`BigQueryClient`, `SpannerClient`, `FirestoreClient`) expose synchronous helper APIs; use the underlying generated `V1\Client\*Client` classes when you need `*Async()` methods. For Cloud Storage, `Google\Cloud\Storage\Bucket` and `StorageObject` provide `uploadAsync()` and `downloadAsStreamAsync()` directly:

```php
use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Promise\Utils;

$storage = new StorageClient();
$bucket = $storage->bucket('my-bucket');

$files = [
    'report-1.txt' => 'First report contents',
    'report-2.txt' => 'Second report contents',
];

$promises = [];
foreach ($files as $name => $contents) {
    $promises[$name] = $bucket->uploadAsync($contents, ['name' => $name]);
}

$objects = Utils::unwrap($promises);
foreach ($objects as $name => $object) {
    printf("Uploaded %s\n", $object->name());
}
```

## 3. Using PHP Fibers with the REST Transport

PHP `Fiber`s allow you to write normal synchronous client code (such as `$client->accessSecretVersion($request)`) that suspends the current fiber while waiting on network I/O, letting other fibers run on the same thread without chaining `.then()` callbacks.

Because PHP `Fiber`s do not include a built-in scheduler, you pair them with Guzzle's `CurlMultiHandler` (or an event loop like [`revolt/event-loop`](https://revolt.run/)) and pass a Fiber-aware `httpHandler` and `authHttpHandler` to the **`rest`** transport.

> [!IMPORTANT]
> Fiber suspension only works with `'transport' => 'rest'`. Under `'transport' => 'grpc'`, synchronous client calls block inside the `grpc` C extension (`Grpc\UnaryCall::wait()`), which does not expose pollable sockets to PHP's userland event loop. For concurrent gRPC calls, use the `*Async()` methods shown in Section 1.

### Driving Fibers with `CurlMultiHandler`

The example below uses native PHP `Fiber`s and Guzzle's `CurlMultiHandler` with zero additional dependencies. Configuring both `httpHandler` and `authHttpHandler` ensures that both API requests and OAuth2 token refreshes suspend the active fiber rather than blocking the thread.

```php
use Google\Cloud\SecretManager\V1\AccessSecretVersionRequest;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

$curlMulti = new CurlMultiHandler(['select_timeout' => 0.01]);
$httpClient = new Client(['handler' => HandlerStack::create($curlMulti)]);

// Suspends the current Fiber until Guzzle resolves the HTTP transfer
$asyncFiberHandler = function (RequestInterface $request, array $options = []) use ($httpClient): PromiseInterface {
    $guzzlePromise = $httpClient->sendAsync($request, $options);
    $fiber = Fiber::getCurrent();
    if ($fiber === null) {
        return $guzzlePromise;
    }

    return $promise = new Promise(function () use (&$promise, $guzzlePromise, $fiber) {
        $guzzlePromise->then(
            static fn () => $fiber->isSuspended() && $fiber->resume(),
            static fn () => $fiber->isSuspended() && $fiber->resume()
        );
        if ($guzzlePromise->getState() === PromiseInterface::PENDING) {
            Fiber::suspend();
        }
        try {
            $promise->resolve($guzzlePromise->wait());
        } catch (\Throwable $e) {
            $promise->reject($e);
        }
    });
};

// Wraps the async handler for synchronous OAuth2 token fetches in google/auth
$syncFiberHandler = static fn (RequestInterface $request, array $options = []): ResponseInterface =>
    $asyncFiberHandler($request, $options)->wait();

$client = new SecretManagerServiceClient([
    'transport' => 'rest',
    'credentialsConfig' => [
        'authHttpHandler' => $syncFiberHandler,
    ],
    'transportConfig' => [
        'rest' => [
            'httpHandler' => $asyncFiberHandler,
        ],
    ],
]);

$secretIds = ['db-password', 'api-key', 'jwt-signing-key'];
$fibers = [];

foreach ($secretIds as $secretId) {
    $fiber = new Fiber(function () use ($client, $secretId): string {
        $request = (new AccessSecretVersionRequest())->setName(
            SecretManagerServiceClient::secretVersionName('my-project', $secretId, 'latest')
        );

        // Synchronous method call—suspends this Fiber while HTTP I/O is in flight
        $response = $client->accessSecretVersion($request);
        return $response->getPayload()->getData();
    });
    $fiber->start();
    $fibers[$secretId] = $fiber;
}

// Tick Guzzle's curl_multi loop until all fibers complete
while (array_filter($fibers, static fn (Fiber $f) => !$f->isTerminated())) {
    $curlMulti->tick();
    Utils::queue()->run();
}

foreach ($fibers as $secretId => $fiber) {
    printf("%s: %s\n", $secretId, $fiber->getReturn());
}
```

### Integrating with an Event Loop (`revolt/event-loop` / Amp)

In long-running async applications built on [`revolt/event-loop`](https://revolt.run/) or [`amphp/amp`](https://amphp.org/), register a periodic timer on the event loop to tick `CurlMultiHandler` while requests are active instead of writing a manual `while` loop:

```php
use Revolt\EventLoop;
use GuzzleHttp\Promise\Utils;

// Register a periodic callback to advance cURL transfers on the Revolt loop
$timerId = EventLoop::repeat(0.01, static function () use ($curlMulti): void {
    $curlMulti->tick();
    Utils::queue()->run();
});

// Unreference the timer so it does not keep the process alive once work finishes
EventLoop::unreference($timerId);
```

> [!NOTE]
> Built-in client retries sleep via `usleep()` between attempts, which pauses the current thread during backoff. In latency-sensitive event-loop servers, consider setting `'disableRetries' => true` on the client and handling retry delays with your event loop's non-blocking timer (such as `Amp\delay()`).
