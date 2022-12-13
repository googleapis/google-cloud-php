# Google Cloud Spanner for PHP

> Idiomatic PHP client for [Cloud Spanner](https://cloud.google.com/spanner/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-spanner/v/stable)](https://packagist.org/packages/google/cloud-spanner) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-spanner.svg)](https://packagist.org/packages/google/cloud-spanner)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-spanner/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A fully managed, mission-critical, relational database service that offers transactional consistency at global scale,
schemas, SQL (ANSI 2011 with extensions), and automatic, synchronous replication for high availability.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-spanner
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component requires the gRPC extension. Please see our [gRPC installation guide](https://cloud.google.com/php/grpc)
for more information on how to configure the extension.

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Spanner\SpannerClient;

$spanner = new SpannerClient();

$db = $spanner->connect('my-instance', 'my-database');

$userQuery = $db->execute('SELECT * FROM Users WHERE id = @id', [
    'parameters' => [
        'id' => $userId
    ]
]);

$user = $userQuery->rows()->current();

echo 'Hello ' . $user['firstName'];
```

### Session warmup

To issue a query against the Spanner service, the client library needs to request a session id from the server under the cover. This API call will add significant latency to your program. The Spanner client library provides a handy way to alleviate this problem by having a cached session pool.

For more details, see: https://github.com/googleapis/google-cloud-php/blob/main/Spanner/src/Session/CacheSessionPool.php#L30

The following example shows how to use the `CacheSessionPool` with `SysVCacheItemPool` as well as how to configure a proper cache for authentication:

```php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Session\CacheSessionPool;
use Google\Auth\Cache\SysVCacheItemPool;

$authCache = new SysVCacheItemPool();
$sessionCache = new SysVCacheItemPool([
    // Use a different project identifier for ftok than the default
    'proj' => 'B',
    // We highly recommend using 250kb as it should safely contain the default
    // 500 maximum sessions the pool can handle. Please modify this value
    // accordingly depending on the number of maximum sessions you would like
    // for the pool to handle.
    'memsize' => 250000
]);

$spanner = new SpannerClient([
    'authCache' => $authCache
]);

$sessionPool = new CacheSessionPool(
    $sessionCache,
    [
        'minSessions' => 10,
        'maxSessions' => 10  // Here it will create 10 sessions under the cover.
    ]
);

$database = $spanner->connect(
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

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/spanner/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/spanner/).
