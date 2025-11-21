# Configuring Client Options for Google Cloud PHP

The Google Cloud PHP Client Libraries (built on `google/gax` and `google/cloud-core`) allow you to configure client behavior via an associative array passed to the client constructor. This array is processed by the [`Google\ApiCore\ClientOptions`](https://docs.cloud.google.com/php/docs/reference/gax/latest/Options.ClientOptions) class.

## Common Configuration Options

The following options can be passed to the constructor of any generated client (e.g., `PubSubClient`, `SpannerClient`, `StorageClient`).

| Option Key | Type | Description |
| ----- | ----- | ----- |
| `credentials` | `string` | `array` |
| `apiKey` | `string` | An **API Key** for services that support public API key authentication (bypassing OAuth2). |
| `apiEndpoint` | `string` | The address of the API remote host. specific for **Regional Endpoints** (e.g., `us-central1-pubsub.googleapis.com:443`) or Private Service Connect. |
| `transport` | `string` | Specifies the transport type. Options: `'grpc'` (default), `'rest'`, or `'grpc-fallback'`. |
| `transportConfig` | `array` | Configuration specific to the transport, such as gRPC channel arguments. |
| `disableRetries` | `bool` | If `true`, disables the default retry logic for all methods in the client. |
| `logger` | `Psr\Log\LoggerInterface` | A PSR-3 compliant logger for client-level logging and tracing. |
| `universeDomain` | `string` | Overrides the default service domain (defaults to `googleapis.com`) for Cloud Universe support. |

## 1\. Authentication Configuration

While the client attempts to find "Application Default Credentials" automatically, you can explicitly provide them using
the `credentials` or `apiKey` options. See [`Authentication`][authentication.md] for details and examples.

[authentication.md]: https://cloud.google.com/php/docs/reference/help/authentication

## 2\. Customizing the API Endpoint

You can modify the API endpoint to connect to a specific Google Cloud region (to reduce latency or meet data residency requirements) or to a private endpoint (via Private Service Connect).

### Connecting to a Regional Endpoint

Some services, like Pub/Sub and Spanner, offer regional endpoints.

```php
use Google\Cloud\PubSub\PubSubClient;

$pubsub = new PubSubClient([
    // Connect explicitly to the us-east1 region
    'apiEndpoint' => 'us-east1-pubsub.googleapis.com:443',
]);
```

## 3\. Configuring a Proxy

The configuration method depends on whether you are using the `grpc` (default) or `rest` transport.

### Proxy with gRPC

When using the gRPC transport, the client library respects the [standard environment variables](https://grpc.github.io/grpc/php/md_doc_environment_variables.html). You **do not** need to configure this in the PHP code itself.

Set the following environment variables in your shell or Docker container:

```
export http_proxy="http://proxy.example.com:3128"
export https_proxy="http://proxy.example.com:3128"
```

**Handling Self-Signed Certificates (gRPC):** If your proxy uses a self-signed certificate (Deep Packet Inspection), you cannot simply "ignore" verification in gRPC. You must provide the path to the proxy's CA certificate bundle.

```
# Point gRPC to a CA bundle that includes your proxy's certificate
export GRPC_DEFAULT_SSL_ROOTS_FILE_PATH="/path/to/roots.pem"
```

**Proxy with REST**

If you are forcing the `rest` transport (or using a library that only supports REST), you must configure the proxy via the `transportConfig` option. This passes the settings down to the underlying Guzzle client.

```php
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;

$secretManagerClient = new SecretManagerServiceClient([
    'transport' => 'rest',
    'transportConfig' => [
        'rest' => [
            'httpOptions' => [
                // Standard Guzzle proxy configuration
                'proxy' => 'http://user:password@proxy.example.com',
                // (Optional) Disable SSL Verification (Development Only)
                // 'verify' => false
            ]
        ]
    ]
]);
```

## 4\. Configuring Retries and Timeouts

There are two ways to configure retries and timeouts: global client configuration (complex) and per-call configuration (simple).

### Per-Call Configuration (Recommended)

For most use cases, it is cleaner to override settings for specific calls using `Google\ApiCore\Options\CallOptions` (or the `$optionalArgs` array in generated clients).

#### Available `retrySettings` Keys

When passing an array to `retrySettings`, you can use the following keys to fine-tune the exponential backoff strategy:

| Key | Type | Description |
| ----- | ----- | ----- |
| `retriesEnabled` | `bool` | Enables or disables retries for this call. |
| `maxRetries` | `int` | The maximum number of retry attempts. |
| `initialRetryDelayMillis` | `int` | Wait time before the *first* retry (in ms). |
| `retryDelayMultiplier` | `float` | Multiplier applied to the delay after each failure (e.g., `1.5`). |
| `maxRetryDelayMillis` | `int` | The maximum wait time between any two retries. |
| `totalTimeoutMillis` | `int` | Total time allowed for the request (including all retries) before giving up. |

#### Example: Advanced Backoff

```php
// Advanced Retry Configuration
$callOptions = [
    'retrySettings' => [
        'retriesEnabled'          => true,
        'maxRetries'              => 3,
        'initialRetryDelayMillis' => 500,  // Start with 0.5s wait
        'retryDelayMultiplier'    => 2.0,  // Double the wait each time (0.5s -> 1s -> 2s)
        'maxRetryDelayMillis'     => 5000, // Cap wait at 5s
        'totalTimeoutMillis'      => 15000 // Max 15s total
    ]
];

$secretManagerClient->accessSecretVersion($request, $callOptions);
```

### Disabling Retries

You can also configure retries globally by passing a `clientConfig` array to the constructor. This is useful if you want to change the default retry strategy for *all* calls made by that client instance.

```php
use Google\Cloud\PubSub\PubSubClient;

$pubsub = new PubSubClient([
    // Quickly disable retries for the entire client
    'disableRetries' => true
]);
```

## 5\. Logging

You can attach any PSR-3 compliant logger (like Monolog) to debug request headers, status codes, and payloads. See [Debug Logging](https://docs.cloud.google.com/php/docs/reference/help/debug) for more examples.

```php
use Google\Cloud\PubSub\PubSubClient;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('google-cloud');
$logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));

$client = new PubSubClient([
    'logger' => $logger
]);
```

