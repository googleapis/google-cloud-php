# Google Cloud PHP Client
> Idiomatic PHP client for [Google Cloud Platform](https://cloud.google.com/) services.

## CI Status

PHP Version  | Status
------------ | ------
PHP 7.2 | [![Kokoro CI](https://storage.googleapis.com/cloud-devrel-public/php/badges/google-cloud-php/php72.svg)](https://storage.googleapis.com/cloud-devrel-public/php/badges/google-cloud-php/php72.html)

[![Latest Stable Version](https://poser.pugx.org/google/cloud/v/stable)](https://packagist.org/packages/google/cloud) [![Packagist](https://img.shields.io/packagist/dm/google/cloud.svg)](https://packagist.org/packages/google/cloud) [![Travis Build Status](https://travis-ci.org/googleapis/google-cloud-php.svg?branch=master)](https://travis-ci.org/googleapis/google-cloud-php/) [![codecov](https://codecov.io/gh/googleapis/google-cloud-php/branch/master/graph/badge.svg)](https://codecov.io/gh/googleapis/google-cloud-php)

* [Homepage](http://googleapis.github.io/google-cloud-php)
* [API Documentation](https://googleapis.github.io/google-cloud-php/#/docs/google-cloud/latest/servicebuilder)

This client supports the following Google Cloud Platform services at a [General Availability](#versioning) quality level:
* [Cloud AutoML](AutoMl) (GA)
* [Cloud Firestore](Firestore) (GA)
* [Cloud Spanner](Spanner) (GA)
* [Google BigQuery](BigQuery) (GA)
* [Google Bigtable](Bigtable) (GA)
* [Google Cloud Asset](Asset) (GA)
* [Google Cloud BigQuery Data Transfer](BigQueryDataTransfer) (GA)
* [Google Cloud Billing](Billing) (GA)
* [Google Cloud Container](Container) (GA)
* [Google Cloud Dataproc](Dataproc) (GA)
* [Google Cloud Datastore](Datastore) (GA)
* [Google Cloud IoT](Iot) (GA)
* [Google Cloud KMS](Kms) (GA)
* [Google Cloud OsLogin](OsLogin) (GA)
* [Google Cloud Pub/Sub](PubSub) (GA)
* [Google Cloud Redis](Redis) (GA)
* [Google Cloud Scheduler](Scheduler) (GA)
* [Google Cloud Speech](Speech) (GA)
* [Google Cloud Storage](Storage) (GA)
* [Google Cloud Tasks](Tasks) (GA)
* [Google Cloud Text-to-Speech](TextToSpeech) (GA)
* [Google Cloud Translation](Translate) (GA)
* [Google Cloud Video Intelligence](VideoIntelligence) (GA)
* [Google Cloud Vision](Vision) (GA)
* [Google Stackdriver Debugger](Debugger) (GA)
* [Google Stackdriver Logging](Logging) (GA)
* [Google Stackdriver Monitoring](Monitoring) (GA)
* [Google Stackdriver Trace](Trace) (GA)
* [Recommender](Recommender) (GA)
* [Secret Manager](SecretManager) (GA)

This client supports the following Google Cloud Platform services at a [Beta](#versioning) quality level:

* [Dialogflow API](Dialogflow) (Beta)
* [Google Cloud BigQuery Storage](BigQueryStorage) (Beta)
* [Google Cloud Data Catalog](DataCatalog) (Beta)
* [Google Cloud Natural Language](Language) (Beta)
* [Google Cloud Recaptcha Enterprise](RecaptchaEnterprise) (Beta)
* [Google Cloud Security Command Center](SecurityCenter) (Beta)
* [Google Cloud Talent Solution](Talent) (Beta)
* [Google Cloud Web Risk](WebRisk) (Beta)
* [Google Cloud Web Security Scanner](WebSecurityScanner) (Beta)
* [Google DLP](Dlp) (Beta)
* [Google Service Directory](ServiceDirectory) (Beta)
* [Google Stackdriver Error Reporting](ErrorReporting) (Beta)
* [Memorystore for Memcached](Memcache) (Beta)
* [Recommendations AI](RecommendationEngine) (Beta)

If you need support for other Google APIs, please check out the [Google APIs Client Library for PHP](https://github.com/google/google-api-php-client).

## Quick Start

We recommend installing individual component packages when possible. A list of available packages can be found on [Packagist](https://packagist.org/search/?q=google%2Fcloud-).

For example:

```sh
$ composer require google/cloud-bigquery
$ composer require google/cloud-datastore
```

We also provide the `google/cloud` package, which includes all Google Cloud clients.

```sh
$ composer require google/cloud
```

### Authentication

Authentication is handled by the client library automatically. You just need to provide the authentication details when creating a client. Generally, authentication is accomplished using a Service Account. For more information on obtaining Service Account credentials, see our [Authentication Guide](https://googleapis.github.io/google-cloud-php/#/docs/google-cloud/latest/guides/authentication).

Once you've obtained your credentials file, it may be used to create an authenticated client.

```php
require 'vendor/autoload.php';

use Google\Cloud\Core\ServiceBuilder;

// Authenticate using a keyfile path
$cloud = new ServiceBuilder([
    'keyFilePath' => 'path/to/keyfile.json'
]);

// Authenticate using keyfile data
$cloud = new ServiceBuilder([
    'keyFile' => json_decode(file_get_contents('/path/to/keyfile.json'), true)
]);
```

If you do not wish to embed your authentication information in your application code, you may also make use of [Application Default Credentials](https://developers.google.com/identity/protocols/application-default-credentials).

```php
require 'vendor/autoload.php';

use Google\Cloud\Core\ServiceBuilder;

putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/keyfile.json');

$cloud = new ServiceBuilder();
```

The `GOOGLE_APPLICATION_CREDENTIALS` environment variable may be set in your server configuration.

### gRPC and Protobuf

Many clients in Google Cloud PHP offer support for gRPC, either as an option or a requirement. gRPC is a high-performance RPC framework created by Google. To use gRPC in PHP, you must install the gRPC PHP extension on your server. While not required, it is also recommended that you install the protobuf extension whenever using gRPC in production.

```
$ pecl install grpc
$ pecl install protobuf
```

* [gRPC Installation Instructions](https://cloud.google.com/php/grpc)
* [Protobuf Installation Instructions](https://cloud.google.com/php/grpc#installing_the_protobuf_runtime_library)

## Caching Access Tokens

By default the library will use a simple in-memory caching implementation, however it is possible to override this behavior by passing a [PSR-6](http://www.php-fig.org/psr/psr-6/) caching implementation in to the desired client.

The following example takes advantage of [Symfony's Cache Component](https://github.com/symfony/cache).

```php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

// Please take the proper precautions when storing your access tokens in a cache no matter the implementation.
$cache = new ArrayAdapter();

$storage = new StorageClient([
    'authCache' => $cache
]);
```

This library provides a PSR-6 implementation with the SystemV shared memory at `Google\Auth\Cache\SysVCacheItemPool`. This implementation is only available on *nix machines, but it's the one of the fastest implementations and you can share the cache among multiple processes. The following example shows how to use it.

```php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Spanner\SpannerClient;
use Google\Auth\Cache\SysVCacheItemPool;

$cache = new SysVCacheItemPool();

$spanner = new SpannerClient([
    'authCache' => $cache
]);
```

## Versioning

This library follows [Semantic Versioning](http://semver.org/).

Please note it is currently under active development. Any release versioned
0.x.y is subject to backwards incompatible changes at any time.

**GA**: Libraries defined at a GA quality level are stable, and will not
introduce backwards-incompatible changes in any minor or patch releases. We will
address issues and requests with the highest priority. Please note, for any
components which include generated clients the GA guarantee will only apply to
clients which interact with stable services. For example, in a component which
hosts V1 and V1beta1 generated clients, the GA guarantee will only apply to the
V1 client as the service it interacts with is considered stable.

**Beta**: Libraries defined at a Beta quality level are expected to be mostly
stable and we're working towards their release candidate. We will address issues
and requests with a higher priority.

## Contributing

Contributions to this library are always welcome and highly encouraged.

See [CONTRIBUTING](CONTRIBUTING.md) for more information on how to get started.

## License

Apache 2.0 - See [LICENSE](LICENSE) for more information.
