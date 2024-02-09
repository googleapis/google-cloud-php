# Migrating Google PubSub from V1 to V2

## How to upgrade

Update your `google/cloud-pubsub` dependency to `^2.0`:

```
{
    "require": {
        "google/cloud-pubsub": "^2.0"
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

This is a major change with this major version but one that we hope won't break any users. When the
`PubSubClient` was created, behind the scenes a connection adapter was initialized based on your
transport preferences. This connection object was then forwarded to any resource classes internally,
like so:

```php
// This initialized a connection object
$client = new PubSubClient(['transport' => 'rest']);
// This passed on the connection object to the Topic class
$topic = $client->topic('my-topic');
```

As you can see the connection object was handled internally. If you used the library in this way,
you will not need to make any changes. However, if you created the connection classes directly
and passed it to the Topic class, this will break in PubSub `v2`:

```php
// Not intended
$connObj = new Rest([]);
$topic = new Topic(
    $connObj,
    // other constructor options
);
```

### IAM class changes

We have kept the functionality of IAM the same, however the underlying IAM class has changed.
```php
// In V1, this used to return an instance of Google\Cloud\Core\Iam\Iam
$iam = $topic->iam();

// In V2, this will return an instance of Google\Cloud\Core\Iam\IamManager
$iam = $topic->iam();

// Both the classes share the same functionality, so the following methods will work for both versions.
$iam->policy();
$iam->setPolicy();
$iam->testIamPermissions();
```

### Changes specific to resources:

#### Topic

`$topic->info()['schemaSettings']['encoding']` used to be an `int` for the gRPC transport and a
`string` for the REST transport. This is now uniformly returned as an `int` for both the
REST and gRPC transports, whose value can be obtained like this:

```php
use Google\Cloud\PubSub\V1\Encoding;

$encoding = Encoding::name($topic->info()['schemaSettings']['encoding']);
```

Additionally you can pass a string or a constant from the `Encoding` class while creating the topic:

```php
$pubSubClient->createTopic('new-topic', [
    'schemaSettings' => [
        'name' => '',
        'encoding' => Encoding::JSON
    ]
])
```

While creating a `Topic`, the `messageRetentionDuration` could be passed as a `string` when using
REST but had to be passed as a `Google\Protobuf\Duration` object for gRPC. This will now accept the
`Duration` object or a `string` for both the transports. Similarly,
`$topic->info()['messageRetentionDuration']` is now an array containing the seconds and nanoseconds
uniformly for both the REST and gRPC transports.

```php
use Google\Protobuf\Duration;

$topic = $pubSubClient->createTopic('new-topic', [
    'messageRetentionDuration' => '3600.000000100s'
    'messageRetentionDuration' => new Duration(['seconds' => 3600, 'nanos' => 100])
]);

/*
['seconds' => 3600, 'nanos' => 100]
*/
$topic->info()['messageRetentionDuration'];
```

#### Schema

`$schema->info()['type']` was a `string` but is now an `int` whose string value can be obtained from
the `Google\Cloud\PubSub\V1\Schema\Type` class:
```php
use Google\Cloud\PubSub\V1\Schema\Type;

$type = Type::name($schema->info()['type']);
```

#### Subscription

While creating a subscription and using the `bigqueryConfig` argument, the REST transport expected
an `array`, while the gRPC transport expected an instance of
`Google\Cloud\PubSub\V1\BigQueryConfig`. Now both transports accept `array` and `BigQueryConfig`.

While creating a subscription and using the `expirationPolicy.ttl` argument, the REST transport
expected a `string` while the gRPC transport could accept `string` or a
`Google\Protobuf\Duration` object. Now both transports accept `string` and `Duration`. Additionally,
`$subscription->info()['expirationPolicy']['ttl']` is a `Duration` object serialized as an array.

While creating a subscription and using the `retryPolicy.minimumBackoff` or
`retryPolicy.maximumBackoff` arguments, the REST transport used to expect `string` while the gRPC
transport could accept `string` or a `Google\Protobuf\Duration` object. Now both transports accept
`string` and `Duration`. Additionally, `$subscription->info()['retryPolicy']['minimumBackoff']` and
`$subscription->info()['retryPolicy']['maximumBackoff']` is a `Duration` object serialized as an
array.

`$subscription->info()['state']` is now an `int` whose string value can be obtained using the
`Google\Cloud\PubSub\V1\Subscription\State` class:
```
use Google\Cloud\PubSub\V1\Subscription\State;

$state = State::name($subscription->info()['state']);
```

#### Snapshot

`$snapshot->info()['expireTime']` used to be a `string` for the REST transports but a serialized
`Google\Protobuf\Timestamp` array for the gRPC transport. Now, it will always be a serialized
`Timestamp` array.
