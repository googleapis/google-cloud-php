# Migrating Google Datastore from V1 to V2

## How to upgrade

Update your `google/cloud-datastore` dependency to `^2.0`:

```
{
    "require": {
        "google/cloud-datastore": "^2.0"
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
created a `DatastoreClient`, behind the scenes a connection adapter was initialized based on your
transport preferences and then forwarded to operation class internally. This connection adapter was used
to deliver requests internally:

```php
// This initialized a connection object and passed it internally to Operation class.
$client = new DatastoreClient(['transport' => 'rest']);
// This used the connection object internally to deliver the lookup request.
$client->lookup($key);
```

As you can see the connection object was handled internally. If you used the library in this way,
you will not need to make any changes. However, if you created the connection classes directly
and passed it to the Operation class, this will break in Datastore `v2`:

```php
// Not intended
$connObj = new Rest([]);
$operation = new Operation(
    $connObj,
    // other operation options
);
$operation->lookup($keys);
```
