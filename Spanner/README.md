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

Now install this component:

```sh
$ composer require google/cloud-spanner
```

This component requires the gRPC extension. Please see our [gRPC installation guide](https://cloud.google.com/php/grpc)
for more information on how to configure the extension.

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\Cloud\Spanner\SpannerClient;

// Create a client.
$spannerClient = new SpannerClient();

$db = $spanner->connect('my-instance', 'my-database');

$userQuery = $db->execute('SELECT * FROM Users WHERE id = @id', [
    'parameters' => [
        'id' => $userId
    ]
]);

$user = $userQuery->rows()->current();

echo 'Hello ' . $user['firstName'];
```

### Multiplexed Sessions

The V2 version of the Spanner Client Library for PHP uses [Multiplexed Sessions][mux-sessions]. Multiplexed Sessions
allow your application to create a large number of concurrent requests on a single session. Some advantages include
reduced backend resource consumption due to a more straightforward session management protocol, and less management
as sessions no longer require cleanup after use or keep-alive requests when idle.

#### Session Caching

The session cache is configured with a default cache which uses the PSR-6 compatible [`SysvCacheItemPool`][sysv-cache]
when the [`sysvshm`][sysvshm] extension is enabled, and [`FileSystemCacheItemPool`][file-cache] when `sysvshm` is not
available. This ensures that your processes share a single multiplex session for each database and creator role.

To change the default cache pool, use the option `cacheItemPool` when instantiating your Spanner client:

```php
use Google\Cloud\Spanner\SpannerClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
// available by running `composer install symfony/cache`
$fileCacheItemPool = new FilesystemAdapter();
// configure through SpannerClient constructor
$spanner = new SpannerClient(['cacheItemPool' => $fileCacheItemPool]);
$database = $spanner->instance($instanceId)->database($databaseId);
```

This can also be passed in as an option to the `instance` or `database` methods:
```php
$spanner = new SpannerClient();
// configure through instance method
$database = $spanner
    ->instance($instanceId, ['cacheItemPool' => $fileCacheItemPool])
    ->database($databaseId);
// configure through database method
$database = $spanner
    ->instance($instanceId)
    ->database($databaseId, ['cacheItemPool' => $fileCacheItemPool]);
```

[sysvshm]: https://www.php.net/manual/en/book.sem.php
[file-cache]: https://github.com/googleapis/google-auth-library-php/blob/main/src/Cache/FileSystemCacheItemPool.php
[sysv-cache]: https://github.com/googleapis/google-auth-library-php/blob/main/src/Cache/SysVCacheItemPool.php

#### Refreshing Sessions

Sessions will refresh synchronously every 7 days. You can use this script to refresh the session asynchronously, in
to avoid latency in your application (recommended every ~24 hours):

```php
// If you are using a custom PSR-6 cache via the "cacheItemPool" client option in your
// application, you will need to supply a cache with the same configuration here in
// order to properly refresh the session.
$spanner = new SpannerClient();

$sessionCache = $spanner
    ->instance($instanceId)
    ->database($databaseId)
    ->session();

// this will force-refresh the session
$sessionCache->refresh();
```

[mux-sessions]: https://cloud.google.com/spanner/docs/sessions#multiplexed_sessions

#### Session Locking

Locking occurs when a new session is created, and ensures no race conditions occur when a session expires.
Locking uses a [`Semaphore`][sem-lock] lock when `sysvmsg`, `sysvsem`, and `sysvshm` extensions are enabled, and a
[`Flock`][flock-lock] lock otherwise. To configure a custom lock, supply a class implementing
[`LockInterface`][lock-interface] when calling `Instance::database`. Here's an example which encorporates the
[Symfony Lock component][symfony-lock]:

```php
use Google\Cloud\Core\Lock\LockInterface;
use Google\Cloud\Spanner\SpannerClient;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\SharedLockInterface;
use Symfony\Component\Lock\Store\SemaphoreStore;

// Available by running `composer install symfony/lock`
$store = new SemaphoreStore();
$factory = new LockFactory($store);

// Create an adapter for Symfony's SharedLockInterface and Google's LockInterface
$lock = new class ($factory->createLock($databaseId)) implements LockInterface {
    public function __construct(private SharedLockInterface $lock) {
    }

    public function acquire(array $options = []) {
        return $this->lock->acquire()
    }

    public function release() {
        return $this->lock->acquire()
    }

    public function synchronize(callable $func, array $options = []) {
        if ($this->lock->acquire($options['blocking'] ?? true)) {
            return $func();
        }
    }
}

// Configure our custom lock on our database using the "lock" option
$spanner = new SpannerClient();
$database = $spanner
    ->instance($instanceId)
    ->database($databaseId, ['lock' => $lock]);
```

[sem-lock]: https://github.com/googleapis/google-cloud-php/blob/main/Core/src/Lock/SemaphoreLock.php
[flock-lock]: https://github.com/googleapis/google-cloud-php/blob/main/Core/src/Lock/FlockLock.php
[lock-interface]: https://github.com/googleapis/google-cloud-php/blob/main/Core/src/Lock/LockInterface.php
[symfony-lock]: https://symfony.com/doc/current/components/lock.html

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/spanner/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/spanner/).
