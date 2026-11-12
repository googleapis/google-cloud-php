# Asynchronous Requests and Concurrency

Every generated Google Cloud PHP V2 client (`*\Client\*Client`) provides an `*Async()` method
alongside each synchronous RPC method—for example, `accessSecretVersionAsync()` alongside
`accessSecretVersion()`. These methods return a
[`GuzzleHttp\Promise\PromiseInterface`][guzzle-promises], allowing a single PHP process to execute
multiple API calls concurrently over **both gRPC and REST**.

* **gRPC (`'transport' => 'grpc'`, default when `ext-grpc` is installed):** Calling `*Async()`
  immediately dispatches the RPC onto the `grpc` C extension's background network threads over
  multiplexed HTTP/2 streams.
* **REST (`'transport' => 'rest'`):** Calling `*Async()` registers the HTTP request with Guzzle's
  `CurlMultiHandler`, multiplexing concurrent transfers on a single thread via `curl_multi`.

[guzzle-promises]: https://github.com/guzzle/promises

## 1. Concurrent Requests with Promises

### Waiting on Multiple Requests (`Utils::unwrap`)

Use `GuzzleHttp\Promise\Utils::unwrap()` to execute an array of `*Async()` promises concurrently
and return their responses keyed by the same array keys. If any request fails, `Utils::unwrap()`
throws a `Google\ApiCore\ApiException` immediately.

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

When individual requests are allowed to fail without aborting the batch, use `Utils::settle()`.
Each entry in the settled array contains `'state'` (`PromiseInterface::FULFILLED` or
`PromiseInterface::REJECTED`) along with either `'value'` or `'reason'`.

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

Avoid creating thousands of `*Async()` promises up front in a loop, which opens excessive
concurrent streams or hits API rate limits. Yield promises lazily from a generator into
`GuzzleHttp\Promise\EachPromise` with a fixed `concurrency` cap.

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

### Paginating Concurrently

For a single list query, async pagination is no faster than synchronous `foreach` iteration because
each page requires the `nextPageToken` returned by the previous page. Async pagination is useful
when listing across **multiple parents** (such as projects or regions) concurrently, or when
overlapping page fetches with per-item async RPCs.

Inside a `.then()` callback, iterate `$response->getPage()` (the current page only) rather than
`$response` directly—iterating `$response` calls `Page::getNextPage()`, which blocks synchronously
via `wait()`—and chain the next `*Async()` call using `$page->getNextPageToken()`:

```php
use Google\ApiCore\PagedListResponse;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\ListSecretsRequest;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;

function listAllSecretsAsync(
    SecretManagerServiceClient $client,
    string $parent,
    string $pageToken = '',
    array $secrets = []
): PromiseInterface {
    $request = (new ListSecretsRequest())
        ->setParent($parent)
        ->setPageToken($pageToken);

    return $client->listSecretsAsync($request)->then(
        function (PagedListResponse $response) use ($client, $parent, $secrets) {
            // Iterate getPage() (current page only), NOT $response directly
            $page = $response->getPage();
            foreach ($page as $secret) {
                $secrets[] = $secret;
            }

            if ($page->hasNextPage()) {
                return listAllSecretsAsync(
                    $client,
                    $parent,
                    $page->getNextPageToken(),
                    $secrets
                );
            }

            return $secrets;
        }
    );
}

$client = new SecretManagerServiceClient();
$parents = ['projects/proj-a', 'projects/proj-b'];

$promises = [];
foreach ($parents as $parent) {
    $promises[$parent] = listAllSecretsAsync($client, $parent);
}

$secretsByProject = Utils::unwrap($promises);
foreach ($secretsByProject as $parent => $secrets) {
    printf("%s: %d secrets\n", $parent, count($secrets));
}
```

## 2. Supported Call Types

* **Unary (`PromiseInterface<Message>`):** Resolves to the protobuf response message.
* **Paginated (`PromiseInterface<PagedListResponse>`):** Resolves the first page asynchronously.
  See [Paginating Concurrently](#paginating-concurrently) for fetching subsequent pages without
  blocking.
* **Long-Running Operation (`PromiseInterface<OperationResponse>`):** Resolves once the server
  *starts* the operation. See [Core Concepts][core-concepts] for polling LROs.
* **Streaming & Resumable Uploads:** Not supported via `*Async()` (throws `ValidationException`).
  Use streaming methods (`ServerStream`, `ClientStream`, `BidiStream`) directly.

[core-concepts]: https://docs.cloud.google.com/php/docs/reference/help/core_concepts

### Handwritten Client Helpers

Most handwritten wrapper clients (`BigQueryClient`, `SpannerClient`, `FirestoreClient`) expose
synchronous helper APIs; use the underlying generated `V1\Client\*Client` classes when you need
`*Async()` methods. For Cloud Storage, `Google\Cloud\Storage\Bucket` and `StorageObject` provide
`uploadAsync()` and `downloadAsStreamAsync()` directly:

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

In Fiber-based applications (such as [AMPHP][amp]), you can run standard synchronous client methods
concurrently over the **`rest`** transport without chaining `.then()` callbacks by routing Guzzle
requests through [`amphp/http-client-guzzle-adapter`][amp-guzzle-adapter]:

```sh
composer require amphp/amp amphp/http-client-guzzle-adapter
```

> [!IMPORTANT]
> Fiber suspension only works with `'transport' => 'rest'`. Under `'transport' => 'grpc'`,
> synchronous client calls block inside the `grpc` C extension (`Grpc\UnaryCall::wait()`), which
> does not expose pollable sockets to PHP's event loop. For concurrent gRPC calls, use the
> `*Async()` methods shown in Section 1.

[amp]: https://amphp.org/
[amp-guzzle-adapter]: https://github.com/amphp/http-client-guzzle-adapter

### 1. Configure the REST Client

Build an HTTP handler around `GuzzleHandlerAdapter` with `HttpHandlerFactory::build()` and pass it
to both `credentialsConfig` (so OAuth2 token refreshes are non-blocking) and `transportConfig`:

```php
use Amp\Http\Client\GuzzleAdapter\GuzzleHandlerAdapter;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

// Route Guzzle requests through AMPHP's Fiber-native HTTP client
$httpClient = new Client([
    'handler' => HandlerStack::create(new GuzzleHandlerAdapter()),
]);
$httpHandler = HttpHandlerFactory::build($httpClient);

// Configure both auth token refreshes and REST calls to use the handler
$client = new SecretManagerServiceClient([
    'transport' => 'rest',
    'credentialsConfig' => [
        'authHttpHandler' => $httpHandler,
    ],
    'transportConfig' => [
        'rest' => [
            'httpHandler' => [$httpHandler, 'async'],
        ],
    ],
]);
```

### 2. Run Synchronous Calls Concurrently

With the Fiber-backed handler configured, standard synchronous methods (including `foreach`
pagination across pages) automatically suspend the current Fiber while waiting on HTTP I/O:

```php
use Amp\Future;
use Google\Cloud\SecretManager\V1\AccessSecretVersionRequest;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use function Amp\async;

$secretIds = ['db-password', 'api-key', 'jwt-signing-key'];
$futures = [];

foreach ($secretIds as $secretId) {
    $futures[$secretId] = async(function () use ($client, $secretId): string {
        $versionName = SecretManagerServiceClient::secretVersionName(
            'my-project',
            $secretId,
            'latest'
        );
        $request = (new AccessSecretVersionRequest())->setName($versionName);

        // Suspends the current Fiber automatically while waiting on HTTP I/O
        return $client->accessSecretVersion($request)->getPayload()->getData();
    });
}

// Wait for all Fibers to finish and collect their return values
$secrets = Future\await($futures);
foreach ($secrets as $secretId => $value) {
    printf("%s: %s\n", $secretId, $value);
}
```

> [!NOTE]
> Built-in client retries sleep via `usleep()` between attempts, which pauses the current thread
> during backoff. In latency-sensitive event-loop servers, consider setting
> `'disableRetries' => true` on the client and handling retry delays with your event loop's
> non-blocking timer (such as `Amp\delay()`).
