# Migrating Google API Core (GAX) from V1 to V2

## How to upgrade

Update your `google/gax` dependency to `^2.0`:

```json
{
    "require": {
        "google/gax": "^2.0"
    }
}
```

## Breaking Changes

### Removed Classes, Interfaces, and Traits

- **`Google\ApiCore\ServiceAddressTrait`**: Replaced by `Google\ApiCore\ApiEndpointTrait` (`self::normalizeServiceAddress()` is now `self::normalizeApiEndpoint()`).
- **`Google\ApiCore\Transport\Grpc\UnaryInterceptorInterface`**: Removed. Extend `Grpc\Interceptor` directly instead.
- **`Google\ApiCore\Testing\MockGrpcTransport`**: Moved to the internal test suite (`Google\ApiCore\Tests\Testing\MockGrpcTransport`) and is no longer distributed with the package.

### Removed Dependencies

- **`google/grpc-gcp`**: Removed along with the `gcpApiConfigPath` client option, `ClientOptionsTrait::initGrpcGcpConfig()`, and `Grpc\Gcp\GCPServerStreamCall` handling in `ServerStreamingCallWrapper`.

### Removed Options and Credential Formats

- **`serviceAddress` client option**: Removed. Use `apiEndpoint` instead.
- **`gcpApiConfigPath` client option**: Removed along with `google/grpc-gcp`.
- **`operationsClientClass` client option**: Removed. Pass a pre-constructed client via the `operationsClient` option instead.
- **`string|array` (`keyFile`) in `credentials` client option and `CredentialsWrapper::build()`**:
  - Passing a file path (`string`) or decoded JSON keyfile (`array`) directly to the `credentials` option in `ClientOptions` / `ClientOptionsTrait`, or passing `keyFile` to `CredentialsWrapper::build()`, has been removed.
  - Pass an instance of `Google\Auth\FetchAuthTokenInterface` or `Google\ApiCore\HeaderCredentialsInterface` to `credentials` (or use `credentialsConfig['keyFile']` when configuring client options).
- **`CallOptions::setTransportSpecificOptions()`**: Removed. Use `CallOptions::setTransportOptions()` instead.

### Removed Methods and Legacy V1 Client Surface Support

- **`CredentialsWrapper::getBearerString()`**: Removed. Use `CredentialsWrapper::getAuthorizationHeaderCallback()` instead.
- **`ClientOptionsTrait::modifyClientOptions(array &$options)`**: Removed. Clients using `GapicClientTrait` can override `preBuildClientOptions(array $options): array` instead.
- **`ClientOptionsTrait::initGrpcGcpConfig()`**: Removed.
- **V1 GAPIC surface backwards-compatibility mode**:
  - Removed `GapicClientTrait::$backwardsCompatibilityMode` and `GapicClientTrait::isBackwardsCompatibilityMode()`.
  - Removed the `User-Agent: gcloud-php-legacy/*` and `gcloud-php-new/*` headers previously added in `GapicClientTrait`.
  - Default long-running operations client in `GapicClientTrait` and `OperationResponse` now uses the V2 surface `Google\LongRunning\Client\OperationsClient` instead of `Google\LongRunning\OperationsClient`, and `OperationResponse` requires operation request classes implementing `::build()`.

### Credentials Hierarchy Changes

- **`Google\ApiCore\InsecureCredentialsWrapper`** now implements `Google\ApiCore\HeaderCredentialsInterface` directly and no longer extends `Google\ApiCore\CredentialsWrapper`.
- **`Google\ApiCore\HeaderCredentialsInterface`** now extends `Google\Auth\GetQuotaProjectInterface`.
- **`GapicClientTrait::getCredentialsWrapper()`** now returns `HeaderCredentialsInterface` instead of `CredentialsWrapper`.
- **`ResumableUploadClient::__construct()`** now accepts `HeaderCredentialsInterface` instead of `CredentialsWrapper`.

### Strict Types and Method Signatures

- Added `declare(strict_types=1)` across all `Google\ApiCore` files.
- Added native parameter, property, and return type declarations across `AgentHeader`, `ApiEndpointTrait`, `ArrayTrait`, `BidiStream`, `Call`, `ClientOptionsTrait`, `ClientStream`, `CredentialsWrapper`, `FixedSizeCollection`, `GapicClientTrait`, `KnownTypes`, `OperationResponse`, `Page`, `PagedListResponse`, `PollingTrait`, `ResourceHelperTrait`, `RetrySettings`, `ServerStream`, `ValidationTrait`, and `Version`.
