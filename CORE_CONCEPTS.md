# Google Cloud PHP Client Library: Core Concepts

This documentation covers essential patterns and usage for the Google Cloud PHP Client Library, focusing on performance (gRPC), data handling (Protobuf, Update Masks), and flow control (Pagination, LROs, Streaming).

## 1. Protobuf and gRPC

The Google Cloud PHP library supports two transports: **REST (HTTP/1.1)** and **gRPC**.

* **Protobuf (Protocol Buffers):** A mechanism for serializing structured data. It is the interface language for gRPC.

* **gRPC:** A high-performance, open-source universal RPC framework. It is generally faster than REST due to efficient binary serialization and HTTP/2 support.

### Installation & Setup

To use gRPC and Protobuf, you must install the PECL extensions. These are highly recommended for production environments to improve performance and enable streaming capabilities.

For detailed instructions, see the [gRPC installation documentation][grpc].

[grpc]: https://cloud.google.com/php/docs/reference/

```bash
# Install extensions via PECL
pecl install grpc
pecl install protobuf
```

Ensure these lines are added to your `php.ini`:

```ini
extension=grpc.so
extension=protobuf.so
```

### Usage in Client

The client library automatically detects if the `grpc` extension is enabled and uses it by default. You can force a specific transport using the `transport` option when creating a client.

```php
use Google\Cloud\PubSub\V1\Client\PublisherClient;

$publisher = new PublisherClient([
    'transport' => 'grpc' // or 'rest'
]);
```

## 2. Pagination

Most list methods in the Google Cloud PHP library return an instance of `Google\ApiCore\PageIterator`. This allows you to iterate over results without manually managing page tokens.

The easiest way to handle pagination is to simply `foreach` over the response. The library automatically fetches new pages in the background as you iterate.

```php
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\ListSecretsRequest;

$secretManager = new SecretManagerServiceClient();

// Prepare the request
$request = (new ListSecretsRequest())
    ->setParent('projects/my-project');

// Call the API
// This returns a PagedListResponse, which implements IteratorAggregate
$response = $secretManager->listSecrets($request);

// Automatically fetches subsequent pages of secrets
foreach ($response as $secret) {
    printf("Secret: %s\n", $secret->getName());
}
```

### Manual Pagination (Accessing Tokens)

If you need to control pagination manually (e.g., for a web API that sends tokens to a frontend), you can access the `nextPageToken`.

```php
// Prepare request with page size and optional token
$request = (new ListSecretsRequest())
    ->setParent('projects/my-project')
    ->setPageSize(10);

// Check if we have a token from a previous request
if (isset($_GET['page_token'])) {
    $request->setPageToken($_GET['page_token']);
}

$response = $secretManager->listSecrets($request);

foreach ($response as $secret) {
    // Process current page items
}

// Get the token for the next page (null if no more pages)
$nextToken = $response->getPage()->getNextPageToken();
```

## 3. Long Running Operations (LROs)

Some operations, like creating a Compute Engine instance or training an AI model, take too long to complete in a single HTTP request. These return a **Long Running Operation (LRO)**.

The PHP library provides the `OperationResponse` object to manage these.

### Polling for Completion

The standard pattern is to call `pollUntilComplete()`.

```php
use Google\Cloud\Compute\V1\Client\InstancesClient;
use Google\Cloud\Compute\V1\InsertInstanceRequest;
use Google\Cloud\Compute\V1\Instance;
use Google\Rpc\Status;

$instancesClient = new InstancesClient();

// Prepare the Request object
$request = (new InsertInstanceRequest())
    ->setProject($project)
    ->setZone($zone)
    ->setInstanceResource($instanceResource);

// Call the method with the request object
$operation = $instancesClient->insert($request);

// Wait for the operation to complete
// This blocks the script, polling periodically
$operation->pollUntilComplete();

if ($operation->operationSucceeded()) {
    // The return value of OperationResponse::getResult is documented in the Long Running Operation method
    // which returned the OperationResponse. It will be in the format `@return OperationResponse<Instance>`.
    /** @var Instance $result */
    $result = $operation->getResult();
} else {
    /** @var Status $error */
    $error = $operation->getError();
    // Handle error
}
```

### Async / Non-Blocking Check

If you don't want to block the script, you can store the Operation Name and check it later.

```php
// 1. Start operation
$operation = $client->longRunningMethod(...);
$operationName = $operation->getName();

// ... later, or in a different worker process ...

// 2. Resume operation
$newOperation = $client->resumeOperation($operationName, $methodName);

if ($newOperation->isDone()) {
    // Handle success
}
```

## 4. Update Masks

When updating resources (PATCH requests), Google Cloud APIs often use an **Update Mask** (`Google\Protobuf\FieldMask`). This tells the server *exactly* which fields you intend to update, preventing accidental overwrites of other fields.

If you do not provide a mask, some APIs update **all** fields, resetting missing ones to default values.

### Constructing a FieldMask

```php
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\Secret;
use Google\Cloud\SecretManager\V1\UpdateSecretRequest;
use Google\Protobuf\FieldMask;

$client = new SecretManagerServiceClient();

// 1. Prepare the resource with NEW values
$secret = new Secret();
$secret->setName('projects/my-project/secrets/my-secret');
$secret->setLabels(['env' => 'production']); // We only want to update this field

// 2. Create the FieldMask
// 'paths' MUST match the protobuf field names (snake_case)
$updateMask = new FieldMask([
    'paths' => ['labels']
]);

// 3. Prepare the Request object
$request = (new UpdateSecretRequest())
    ->setSecret($secret)
    ->setUpdateMask($updateMask);

// 4. Call the API
$client->updateSecret($request);
```

**Note:** The field names in `paths` should be the protocol buffer field names (usually `snake_case`), even if the PHP setter methods are `camelCase`.

## 5. gRPC Streaming

gRPC Streaming allows continuous data flow between client and server. In PHP, this is most commonly seen as **Server-Side Streaming**, where the server sends a stream of responses to a single client request. **Bidirectional Streaming** is also fully supported, though it is less common in typical short-lived PHP web request models compared to long-running CLI scripts or workers.

### Streaming Types

| Type | Description | Common PHP Use Case |
| :--- | :--- | :--- |
| **Server-Side** | Client sends one request; Server sends a stream of messages. | Reading large datasets (BigQuery, Spanner) or watching logs. |
| **Client-Side** | Client sends a stream of messages; Server waits for stream to close before sending a response. | Uploading large files or ingesting bulk data. |
| **Bidirectional** | Both Client and Server send a stream of messages independently. | Real-time audio processing (Speech-to-Text), chat applications. |

### Server-Side Streaming Example (High-Level)

A common example is running a query in BigQuery or Spanner, or streaming logs. The PHP client exposes this as an iterable object.

```php
use Google\Cloud\BigQuery\BigQueryClient;

$bigQuery = new BigQueryClient();
$queryJobConfig = $bigQuery->query('SELECT * FROM `bigquery-public-data.samples.shakespeare`');
$queryResults = $bigQuery->runQuery($queryJobConfig);

// This loops acts as a stream reader.
// Internally, it reads partial responses from the gRPC stream.
foreach ($queryResults as $row) {
    print_r($row);
}
```

### Server-Side Streaming Example (Low-Level)

gRPC Streaming is  supported in the generated clients as well. An example of this is in the **BigQuery Storage API**. This `readRows` method returns a `ServerStream`.

Documentation for ServerStream: https://docs.cloud.google.com/php/docs/reference/gax/latest/ServerStream

```php
use Google\Cloud\BigQuery\Storage\V1\Client\BigQueryReadClient;
use Google\Cloud\BigQuery\Storage\V1\ReadRowsRequest;

$readClient = new BigQueryReadClient();

// Note: Streaming requires a valid 'readStream' resource name,
// typically obtained via createReadSession().
$request = (new ReadRowsRequest())
    ->setReadStream('projects/my-proj/locations/us/sessions/session-id/streams/stream-id');

// readRows is a server-side streaming method
$stream = $readClient->readRows($request);

// Read from the stream
foreach ($stream->readAll() as $response) {
    // $response is a ReadRowsResponse object
    foreach ($response->getRows()->getSerializedRows() as $row) {
        // Process binary row data
        printf("Row size: %d bytes\n", strlen($row));
    }
}
```

### gRPC Bidirectional Streaming

For general services, the pattern is always:

```php
// Conceptual example for a Bidi stream
$stream = $client->bidiStreamMethod();

// Write to stream
$stream->write($requestObject);

// Read from stream
$response = $stream->read();
```

If you are using **Cloud Speech-to-Text** (or other Bidirectional APIs), you will interact with a `BidiStream` object. This allows you to write requests and read responses continuously.

The protocol requires you to send a configuration request first, followed by audio data requests.

```php
use Google\Cloud\Speech\V1\Client\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\StreamingRecognitionConfig;
use Google\Cloud\Speech\V1\StreamingRecognizeRequest;

$client = new SpeechClient();

// streamingRecognize is a bidirectional streaming method
$stream = $client->streamingRecognize();

// 1. Send the Initial Configuration Request
$recognitionConfig = (new RecognitionConfig())
    ->setEncoding(RecognitionConfig\AudioEncoding::LINEAR16)
    ->setSampleRateHertz(16000)
    ->setLanguageCode('en-US');

$streamingConfig = (new StreamingRecognitionConfig())
    ->setConfig($recognitionConfig);

$configRequest = (new StreamingRecognizeRequest())
    ->setStreamingConfig($streamingConfig);

$stream->write($configRequest);

// 2. Send Audio Data Request(s)
// In a real app, you might loop through audio chunks here
$audioRequest = (new StreamingRecognizeRequest())
    ->setAudioContent(file_get_contents('audio.raw'));

$stream->write($audioRequest);

// 3. Read responses from the stream
// 'closeWriteAndReadAll' closes the write stream and returns a generator
foreach ($stream->closeWriteAndReadAll() as $response) {
    // $response is a StreamingRecognizeResponse
    foreach ($response->getResults() as $result) {
        printf("Transcript: %s\n", $result->getAlternatives()[0]->getTranscript());
    }
}
```
