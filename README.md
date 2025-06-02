# Google Cloud PHP Client
> Idiomatic PHP client for [Google Cloud Platform](https://cloud.google.com/) services.

View the [list of supported APIs and Services](https://cloud.google.com/php/docs/reference).

If you need support for other Google APIs, please check out the
[Google APIs Client Library for PHP](https://github.com/google/google-api-php-client).

We recommend installing individual component packages. A list of available packages can be found on
[Packagist](https://packagist.org/search/?q=google%2Fcloud-).

For example:
```sh
$ composer require google/cloud-storage
$ composer require google/cloud-bigquery
$ composer require google/cloud-datastore
```

## Quickstart

In this guide we'll focus on how to configure your client for local development using the Google
Cloud CLI (`gcloud`).

### For local development:
* Install the Google Cloud CLI.
* Authenticate with `gcloud` to generate the credentials file.
* Instantiate a client.

### Installing the Google Cloud CLI
In order to generate our needed credentials file we need to authenticate to gcloud first.
Installation is handled differently depending on your platform. Here is a link to help you setup
the Google Cloud CLI:

https://cloud.google.com/sdk/docs/install

### Authenticate via the `gcloud` command
Once the Google Cloud CLI tools are installed it is required that we authenticate via the `gcloud`:
```shell
$ gcloud init
$ gcloud auth application-default login
```

This will create a local file in your system that the authentication library for our client will
read in order to make requests to the apis with those credentials. This file is located in different
place depending on your system.

Windows:
```
%APPDATA%\gcloud\application_default_credentials.json
```

Linux and MacOS:
```
$HOME/.config/gcloud/application_default_credentials.json
```

To read more about Authentication, see [AUTHENTICATION.md](AUTHENTICATION.md)

### Installing a client
Install the Google Translate client library with composer
```sh
composer install google/cloud-translate
```
**Note**: For this example, we are using the Google Translate client library. Check the
[the complete list of packages](https://cloud.google.com/php/docs/reference/) to find your required
library.

### Instantiating the client
Now that we've authenticated and installed the client library, we can instantiate a client which will
detect the JSON file created by the gcloud CLI and use it to authenticate your requests:

```php
require_once 'vendor/autoload.php';

use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;

// Instantiating the client gathers the credentials from the `application_default_credentials.json`
$client = new TranslationServiceClient([]);

$request = new TranslateTextRequest();
$request->setParent('projects/<YOUR_PROJECT_ID>');
$request->setTargetLanguageCode('en-US');
$request->setContents(['こんにちは']);

// The request will contain the authentication token based on the default credentials file
$response = $client->translateText($request);

var_dump($response->getTranslations()[0]);
// {
//     ["translatedText"]=>
//     string(5) "Hello"
//     ["detectedLanguageCode"]=>
//     string(2) "ja"
// }

```

### Authentication

#### Note
This quickstart is built with local development in mind. The steps for deploying your project are
different depending on the environment you use. Here we provide some basic instruction in how to get
started with deployment of your project:

 * For applications running elsewhere, authentication is usually accomplished using a Service
   Account.

For more information on obtaining Service Account credentials see our
[Authentication Guide](https://cloud.google.com/docs/authentication/production#manually). Set the
`GOOGLE_APPLICATION_CREDENTIALS` environment variable pointing to your credentials file.

#### Note:
Some clients accept the `keyFilePath` and `keyFile` configuration options pointing to the credentials file:

```php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

// Authenticate using a keyfile path
$cloud = new StorageClient([
    'keyFilePath' => 'path/to/keyfile.json'
]);

// Authenticate using keyfile data
$cloud = new StorageClient([
    'keyFile' => json_decode(file_get_contents('/path/to/keyfile.json'), true)
]);
```
A list of clients that accept these parameters are:
- [Bigtable](https://github.com/googleapis/google-cloud-php-bigtable)
- [Spanner](https://github.com/googleapis/google-cloud-php-spanner)
- [Firestore](https://github.com/googleapis/google-cloud-php-firestore)
- [Datastore](https://github.com/googleapis/google-cloud-php-datastore)
- [Pubsub](https://github.com/googleapis/google-cloud-php-pubsub)
- [Logging](https://github.com/googleapis/google-cloud-php-logging)
- [Translate](https://github.com/googleapis/google-cloud-php-translate)
- [Bigquery](https://github.com/googleapis/google-cloud-php-bigquery)
- [Storage](https://github.com/googleapis/google-cloud-php-storage)

We recommend to visit the Check the [client documentation][php-ref-docs] for the client library you're using for more in depth information.

[php-ref-docs]: https://cloud.google.com/php/docs/reference

If you do not wish to embed your authentication information in your application code, you may also make use of [Application Default Credentials](https://developers.google.com/identity/protocols/application-default-credentials).

```php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/keyfile.json');

$cloud = new StorageClient();
```

The `GOOGLE_APPLICATION_CREDENTIALS` environment variable may be set in your server configuration.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

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

## PHP Versions Supported

All client libraries support PHP 8.0 and above.

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

This repository is not an official support channel. If you have support questions,
file a support request through the normal Google support channels,
or post questions on a forum such as [StackOverflow](http://stackoverflow.com/questions/tagged/google-cloud-platform+php).

## License

Apache 2.0 - See [LICENSE](LICENSE) for more information.
