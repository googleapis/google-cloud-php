# Migration Guide for V2 library

## How to upgrade

Update your `google/cloud-firestore` dependency to `^2.0`:

```
{
    "require": {
        "google/cloud-firestore": "^2.0"
    }
}
```

## Changes

### Client Options changes

The following client options are removed/replaced with other options present in
[`ClientOptions`][ClientOptions]. This was done to ensure client options are consistent across all
Google Cloud clients.

- `authCache` -> Moved to `credentialsConfig.authCache`
- `authCacheOptions` -> Moved to `credentialsConfig.authCacheOptions`
- `credentialsFetcher` -> Moved to `credentials`
- `keyFile` -> Moved to `credentials`
- `keyFilePath` -> Moved to `credentials`
- `requestTimeout` -> Removed from client options and moved to a call option `timeoutMillis`
- `scopes` -> Moved to `credentialsConfig.scopes`
- `defaultScopes` -> Moved to `credentialsConfig.defaultScopes`
- `quotaProject` -> Moved to `credentialsConfig.quotaProject`
- `httpHandler` -> Moved to `transportConfig.rest.httpHandler`
- `authHttpHandler` -> Moved to `credentialsConfig.authHttpHandler`
- `asyncHttpHandler` -> Removed in favour of a single httpHandler option.
- `restOptions` -> Moved to `transportConfig.rest`
- `grpcOptions` -> Moved to `transportConfig.grpc`
- `accessToken` -> Removed
- `shouldSignRequest` -> Removed
- `preferNumericProjectId` -> Removed

### Retry Options changes

The retry options have been moved to use [`RetrySettings`][RetrySettings] in Client Options and in
call options.

- `retries` -> Renamed to `retrySettings.maxRetries`
- `restRetryFunction` -> Renamed to `retrySettings.retryFunction`
- `grpcRetryFunction` -> Renamed to `retrySettings.retryFunction`
- `delayFunc`/`calcDelayFunction` -> Removed in favor of the properties
  `retrySettings.initialRetryDelayMillis`, `retrySettings.retryDelayMultiplier` and
  `retrySettings.maxRetryDelayMillis`.

[RetrySettings]: https://googleapis.github.io/gax-php/v1.26.1/Google/ApiCore/RetrySettings.html

[ClientOptions]: https://googleapis.github.io/gax-php/v1.26.1/Google/ApiCore/Options/ClientOptions.html

### Connection classes are not used anymore.

This is a major change with this major version but one that we hope won't break most users. When one
created a `FirestoreClient`, behind the scenes a connection adapter was initialized based on your
transport preferences and then forwarded to resource classes internally. This connection adapter was used
to deliver requests internally:

```php
use Google\Cloud\Firestore\FirestoreClient;

// This initialized a connection object and passed it internally to resource classes.
$client = new FirestoreClient();
// This used the connection object internally to deliver the `batchGetDocuments` request.
$docRef = $client->document('DOCUMENT_NAME');
$docSnapshot = $docRef->snapshot();
```

As you can see the connection object was handled internally. If you used the library in this way,
you will not need to make any changes. However, if you created the connection classes directly
and passed it to a Resource class, this will break in Firestore `v2`:

```php
// Not intended
$connObj = new Grpc([]);
$docRef = new DocumentReference(
    $connObj,
    // other operation options
);
$docRef->snapshot();
```

## Timestamp

Throughout the exposed functionalities of the library, all the `\Google\Cloud\Core\Timestamp` usage has been replaced with `\Google\Protobuf\Timestamp`.

Earlier usage:

```php
use Google\Cloud\Code\Timestamp;

// Create a current timestamp
$timestamp = new Timestamp(new \DateTime());

// Create a timestamp from a timestamp string
$timestamp = new Timestamp(new \DateTime('2003-02-05 11:15:02.421827Z'));

// Create a timestamp with nanoseconds precision as seconds argument
$timestamp = new Timestamp(new \DateTime('2003-02-05 11:15:02.421827Z'), 100);
```

New timestamp usages:

```php
use Google\Protobuf\Timestamp;

// Create a current timestamp

// Method 1
$timestamp = new Timestamp();
$timestamp->fromDateTime(new \DateTime());

// Method 2
$timestamp = new Timestamp(['seconds' => time()]);

// Create a timestamp from a timestamp string
$timestamp = new Timestamp();
$timestamp->fromDateTime(new \DateTime('2003-02-05 11:15:02.421827Z'));

// Create a timestamp with from timestamp string with nanoseconds
$timestamp = new Timestamp();
$timestamp->fromDateTime(new \DateTime('2003-02-05 11:15:02.421827Z'));
$timestamp->setNanos(100);

// Create a current from seconds since epoch and nanos directly

// Method 1
$secondsSinceEpoch = time();
$timestamp = new Timestamp([
    'seconds' => $secondsSinceEpoch,
    'nanos' => 100
])

// Method 2
$secondsSinceEpoch = time();
$timestamp = (new Timestamp())
    ->setSeconds($secondsSinceEpoch)
    ->setNanos(100);
```

## ListCollectionIds

ListCollectionIds rpc is exposed via `DocumentReference::collections()` and `FirestoreClient::collections()` methods.
These method used to return an `\InvalidArgumentException` when `readTime` was invalid. Now we've removed this client
level check and exception is thrown by the Serializer when it converts the array data into Protobuf Request object.

## ListDocuments

ListDocuments rpc is exposed via `CollectionReference::listDocuments()` method. These method used to return an `\InvalidArgumentException`
when `readTime` was invalid. Now we've removed this client level check and exception is thrown by the Serializer
when it converts the array data into Protobuf Request object.

## RunQuery

RunQuery RPC is exposed via `CollectionReference::documents()` and `Transaction::runQuery()` methods. These method used to return an `\InvalidArgumentException`
when `readTime` was invalid. Now we've removed this client level check and exception is thrown by the Serializer
when it converts the array data into Protobuf Request object.

# WriteBatch class

This class has been removed as it was already deprecated. Users should use the bulkwriter feature instead.
