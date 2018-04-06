# Google Cloud PHP Spanner

> Idiomatic PHP client for [Cloud Spanner](https://cloud.google.com/spanner/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-spanner/v/stable)](https://packagist.org/packages/google/cloud-spanner) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-spanner.svg)](https://packagist.org/packages/google/cloud-spanner)

* [Homepage](http://googlecloudplatform.github.io/google-cloud-php)
* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-spanner/latest/spanner/spannerclient)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

If it is not already installed, you will also require the gRPC extension. For installation instructions, [see here](https://cloud.google.com/php/grpc).

NOTE: In addition to the gRPC extension, we recommend installing the protobuf extension for improved performance. For installation instructions, [see here](https://cloud.google.com/php/grpc#install_the_protobuf_runtime_library).

## Installation

```
$ composer require google/cloud-spanner
```

## Session warmup

To issue a query against the Spanner service, the client library needs to request a session id from the server under the cover. This API call will add significant latency to your program. The Spanner client library provides a handy way to alleviate this problem by having a cached session pool.

For more details, see: https://github.com/GoogleCloudPlatform/google-cloud-php/blob/master/Spanner/src/Session/CacheSessionPool.php#L30

The following example shows how to use the `CacheSessionPool` with `SysVCacheItemPool` as well as how to configure a proper cache for authentication:

```php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Session\CacheSessionPool;
use Google\Auth\Cache\SysVCacheItemPool;

$authCache = new SysVCacheItemPool();
$sessionCache = new SysVCacheItemPool([
    // Use a different project identifier for ftok than the default
    'proj' => 'B'
]);

$spanner = new SpannerClient([
    'authCache' => $authCache
]);

$sessionPool = new CacheSessionPool(
    $sessionCache,
    [
        'minSession' => 10,
        'maxSession' => 10  // Here it will create 10 sessions under the cover.
    ]
);

$database = $client->connect(
    'my-instance',
    'my-db',
    [
        'sessionPool' => $sessionPool
    ]
);
// `warmup` will actually create the sessions for the first time.
$sessionPool->warmup();

```

By using a cache implementation like `SysVCacheItemPool`, you can share the cached sessions among multiple processes, so that for example, you can warmup the session upon the server startup, then all the other PHP processes will benefit from the warmed up sessions.
