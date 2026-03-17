# Migrating Google Cloud Logging from V1 to V2

## How to upgrade

Update your `google/cloud-logging` dependency to `^2.0`:

```
{
    "require": {
        "google/cloud-logging": "^2.0"
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

### `ConnectionInterface`, `Connection\Grpc`, and `Connection\Rest` are not used anymore.

This is a major change, but one that we hope won't break any users. When the
`LoggingClient` was created, behind the scenes a connection adapter was initialized.

The Rest and Grpc connection classes (along with the `ConnectionInterface`) have been
removed in favor of using the GAPIC generated clients directly. See `src/Connection/Gapic.php`
for an example.


