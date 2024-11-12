# Migrating Google Spanner from V1 to V2

## How to upgrade

Update your `google/cloud-spanner` dependency to `^2.0`:

```
{
    "require": {
        "google/cloud-spanner": "^2.0"
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
- `FetchAuthTokenInterface` -> Moved to `credentials`
- `keyFile` -> Moved to `credentials`
- `keyFilePath` -> Moved to `credentials`
- `requestTimeout` -> Removed from client options and moved to a call option `timeoutMillis`
- `scopes` -> Moved to `credentialsConfig.scopes`
- `quotaProject` -> Moved to `credentialsConfig.quotaProject`
- `httpHandler` -> Moved to `transportConfig.rest.httpHandler`
- `authHttpHandler` -> Moved to `credentialsConfig.authHttpHandler`
- `retries` -> Removed from client options and moved to call options `retrySettings.maxRetries`

### Retry Options changes

The retry options have been moved to use [`RetrySettings`][RetrySettings] in call options
and function parameters.

- `retries` -> Renamed to `retrySettings.maxRetries`
- `maxRetries` -> Renamed to `retrySettings.maxRetries`

[RetrySettings]: https://googleapis.github.io/gax-php/v1.26.1/Google/ApiCore/RetrySettings.html

[ClientOptions]: https://googleapis.github.io/gax-php/v1.26.1/Google/ApiCore/Options/ClientOptions.html

### Connection classes are not used anymore.

This is a major change with this major version but one that we hope won't break any users. When the
`SpannerClient` was created, behind the scenes a connection adapter was initialized.
This connection object was then forwarded to any resource classes internally,
like so:

```php
// This initialized a connection object
$client = new SpannerClient();
// This passed on the connection object to the Instance class
$instance = $spanner->instance('my-instance');
```

As you can see the connection object was handled internally. If you used the library in this way,
you will not need to make any changes. However, if you created the connection classes directly
and passed it to the `Instance` class, this will break in Spanner `v2`:

```php
// Not intended
$connObj = new Grpc([]);
$instance = new Instance(
    $connObj,
    // other constructor options
);
```

### `Google\Cloud\Spanner\Duration` class is not used anymore.
We have removed the `Google\Cloud\Spanner\Duration` class from the library. Instead we will be using the `Google\Protobuf\Duration` class.

### IAM class changes

We have kept the functionality of `IAM` the same, however the underlying `IAM` class has changed.
```php
// In V1, this used to return an instance of Google\Cloud\Core\Iam\Iam
$iam = $instance->iam();

// In V2, this will return an instance of Google\Cloud\Core\Iam\IamManager
$iam = $instance->iam();

// Both the classes share the same functionality, so the following methods will work for both versions.
$iam->policy();
$iam->setPolicy();
$iam->testIamPermissions();
```

### LongRunningOperation class changes

We have kept the functionality of `LongRunningOperation` the same,
however the underlying `LongRunningOperation` class has changed.
```php
// In V1, this used to return an instance of Google\Cloud\Core\LongRunning\LongRunningOperation.
$lro = $instance->create($configuration);

// In V2, this will return an instance of Google\ApiCore\OperationResponse.
$lro = $instance->create($configuration);

// Both the classes share the same functionality, so the following methods will work for both versions.
$lro->name();
$lro->done();
$lro->state();
$lro->result();
$lro->error();
$lro->info();
$lro->reload();
$lro->pollUntilComplete();
$lro->cancel();
$lro->delete();
```
