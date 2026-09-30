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

- **`Google\ApiCore\GPBType` and `Google\ApiCore\GPBLabel`**: Removed. Use `Google\Protobuf\Internal\GPBType` and `Google\Protobuf\Internal\GPBLabel` instead.
- **`Google\ApiCore\ServiceAddressTrait`**: Replaced by `Google\ApiCore\ApiEndpointTrait` (`self::normalizeServiceAddress()` is now `self::normalizeApiEndpoint()`).
- **`Google\ApiCore\Transport\Grpc\UnaryInterceptorInterface`**: Removed. Extend `Grpc\Interceptor` directly instead.
- **`Google\ApiCore\Testing\MockGrpcTransport`**: Moved to the internal test suite (`Google\ApiCore\Tests\Testing\MockGrpcTransport`) and is no longer distributed with the package.

### Removed Dependencies

- **`google/grpc-gcp`**: Removed along with the `gcpApiConfigPath` client option, `ClientOptionsTrait::initGrpcGcpConfig()`, and `Grpc\Gcp\GCPServerStreamCall` handling in `ServerStreamingCallWrapper`.

### Removed Options

- **`gcpApiConfigPath` client option**: Removed along with `google/grpc-gcp`.
- **`operationsClientClass` client option**: Removed. Pass a pre-constructed client via the `operationsClient` option instead.
- **`CallOptions::setTransportSpecificOptions()`**: Removed. Use `CallOptions::setTransportOptions()` instead.

### Removed Methods and Legacy V1 Client Surface Support

- **`CredentialsWrapper::getBearerString()`**: Removed. Use `CredentialsWrapper::getAuthorizationHeaderCallback()` instead.
- **`ClientOptionsTrait::initGrpcGcpConfig()`**: Removed.
- **`ClientOptionsTrait::modifyClientOptions()`**: Removed. Instead of mutating the options array in `modifyClientOptions()`, extend `Google\ApiCore\Options\ClientOptions`, pass the `ClientOptions` instance to `buildClientOptions()` / `setClientOptions()` (or override `protected function createClientOptions(array $options): ClientOptions`), and read `$this->getClientOptions()` on the client.
- **`HttpUnaryTransportTrait::startServerStreamingCall()`**: Removed (along with the `unsupportedServerStreamingCall` trait alias on `RestTransport`).
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
- Added native parameter, property, and return type declarations across all `Google\ApiCore` classes, interfaces (`TransportInterface`, `MiddlewareInterface`, `ResourceTemplateInterface`, `ServerStreamingCallInterface`, `ResumableUploadTransportInterface`, `HeaderCredentialsInterface`), and traits.
- **`PathTemplate::__construct(string $path)`** now requires a non-null `string`.
- **`OperationResponse`**:
  - `__construct(string $operationName, object $operationsClient, array $options = [])` now requires non-null `$operationName` (`string`) and `$operationsClient` (`object`).
  - `getName()` now returns non-nullable `string`.
  - `getError()` now returns `?Google\Rpc\Status`.
  - `getLastProtoResponse()` now returns `?Google\LongRunning\Operation`.
  - `getOperationsClient()` now returns `Google\LongRunning\Client\OperationsClient|Google\ApiCore\OperationsClientInterface`.
  - Custom operations clients (e.g., Compute's `ZoneOperationsClient`) and custom operation options are now encapsulated in `Google\ApiCore\CustomOperationsClient` (implementing `Google\ApiCore\OperationsClientInterface`), which normalizes custom operation proto responses into `Google\LongRunning\Operation`.

