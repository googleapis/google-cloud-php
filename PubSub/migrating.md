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

### Client config changes

The following properties are removed/replaced with other options present in GAX. This was done to achieve consistent behaviour that already exists in most of the other products.

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

### Connection classes are not used anymore.

This is a major change with this major version but one that we hope won't break most users. When one created a `PubSubClient`, behind the scenes a connection adapter was initialized based on your transport preferences. This connection object was then forwarded to any resource classes internally, like so:
```php
// This initialized a connection object
$client = new PubSubClient(['transport' => 'rest']);
// This passed on the connection object to the Topic class
$client->topic('my-topic');
```

As you can see the connection object was completely abstracted, so if you used the code this way(Which was intended), there are no changes. However, there was a possibility to initialize a connection class by yourself and pass it to the Topic class, like so:
```php
// Not intended
$connObj = new Rest([]);
$topic = new Topic($connObj,
    // other constructor options
);
```

If your codebase uses the above approach, then you will have to refactor it.

### Retry Settings changes

With `v2` in `google/cloud-pubsub` the retry settings have been moved to GAX completely and from now on you can use the retry settings available there. Here are the changes:
- retries -> Renamed to retrySettings.maxRetries
- restRetryFunction -> Renamed to retrySettings.retryFunction
- grpcRetryFunction -> Renamed to retrySettings.retryFunction
- delayFunc/calcDelayFunction -> Removed in favour of the properties `retrySettings.initialRetryDelayMillis`, `retrySettings.retryDelayMultiplier` and `retrySettings.maxRetryDelayMillis`.

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

- Topic

`$topic->info()['schemaSettings']['encoding']` used to be an integer value for the GRPC transport and a string for the REST transport.
This is now uniformly returned as an integer value for both the REST and GRPC transports, whose value can be obtained as such:

```php
use Google\Cloud\PubSub\V1\Encoding;

$encoding = Encoding::name($topic->info()['schemaSettings']['encoding']);

// Additionally you can pass a string or a constant from the Encoding class while creating the topic.
$pubSubClient->createTopic('new-topic', [
    'schemaSettings' => [
        'name' => '',
        'encoding' => Encoding::JSON
    ]
])
```

While creating a `Topic`, the `messageRetentionDuration` could be passed as a string(only) when using REST but had to be passed as a `Google\Protobuf\Duration` object for GRPC. This will now accept the Duration object or a string for both the transports.
Similarly, the output from the `$topic->info()['messageRetentionDuration']` will return an array containing the seconds and nanoseconds uniformly for both the REST and GRPC transports.

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

- Schema

`$schema->info()['type']` returned a string but now it returns an integer value whose string value can be obtained from the Type class:
```php
use Google\Cloud\PubSub\V1\Schema\Type;

$type = Type::name($schema->info()['type']);
```

- Subscription

While creating a subscription and using the `bigqueryConfig` argument, the REST transport expects it as an array, while the GRPC transport expects it as an instance of the `BigQueryConfig`, but now both the array format and an instance of the `BigQueryConfig` class would work for both the transports.

While creating a subscription and using the `expirationPolicy.ttl` argument, the REST transport used to expect it as a string while the GRPC transport could accept a string or a `Google\Protobuf\Duration` object. Now both the transports accept a string or a `Duration` object. Additionally, `$subscription->info()['expirationPolicy']['ttl']` will return a `Duration` object serialized as an array.

While creating a subscription and using the `retryPolicy.minimumBackoff` or `retryPolicy.maximumBackoff` arguments, the REST transport used to expect it as a string while the GRPC transport could accept a string or a `Google\Protobuf\Duration` object. Now both the transports accept a string or a `Duration` object. Additionally, `$subscription->info()['retryPolicy']['minimumBackoff']` and `$subscription->info()['retryPolicy']['maximumBackoff']` now return a `Duration` object serialized as an array.

`#subscription->info()['state']` now returns an integer whose value can be derived like so:
```
use Google\Cloud\PubSub\V1\Subscription\State;

$state = State::name($subscription->info()['state']);
```

- Snapshot

`$snapshot->info()['expireTime']` used to output as a string for the REST transports but as a serialized `Google\Protobuf\Timestamp` array for the GRPC transport. Now, it will always be a serialized `Timestamp` array.
