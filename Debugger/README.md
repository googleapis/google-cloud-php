# Google PHP Stackdriver Debugger

> Idiomatic PHP client for [Stackdriver Debugger](https://cloud.google.com/debugger/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-debugger/v/stable)](https://packagist.org/packages/google/cloud-debugger) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-debugger.svg)](https://packagist.org/packages/google/cloud-debugger)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-debugger/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A feature of Google Cloud Platform that lets you inspect the state of an application, at any code location, without
stopping or slowing down the running app. Stackdriver Debugger makes it easier to view the application state without
adding logging statements.

### Installation

1. Install the PHP extension from PECL.

    ```bash
    $ pecl install stackdriver_debugger-alpha
    ```

    On Windows, you can download pre-built .dll files [from PECL][pecl-debugger].

    You may also need to enable the extension in your `php.ini` file:

    ```ini
    # on Unix
    extension=stackdriver_debugger.so

    # on Windows
    extension=php_stackdriver_debugger.dll
    ```

1. Install with `composer` or add to your `composer.json`.

    ```bash
    $ composer require google/cloud-debugger
    ```

1. Run the batch daemon script in the background.

    On Unix-based systems that have
    [semaphore extensions][semaphore-extensions] installed, run the
    [BatchDaemon][batch-daemon]:

    ```bash
    $ vendor/bin/google-cloud-batch daemon
    ```

    On Windows or systems that do not have
    [semaphore extensions][semaphore-extensions] installed, run the Debugger
    [Daemon][debugger-daemon]:

    ```bash
    $ vendor/bin/google-cloud-debugger -s <SOURCE_ROOT>
    ```

    The `SOURCE_ROOT` is the base location of your deployed application.

    Alternatively, you can provide a configuration script:

    ```bash
    $ vendor/bin/google-cloud-debugger -c <CONFIG_FILE>
    ```

1. Include and start the debugger `Agent` as the first action in your
application:

    ```php
    $agent = new Google\Cloud\Debugger\Agent();
    ```

    If this file is not in your source root, you will need to provide the path to
    your application's source root as an optional parameter:

    ```php
    $agent = new Google\Cloud\Debugger\Agent([
        'sourceRoot' => '/path/to/source/root'
    ]);
    ```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\Cloud\Debugger\DebuggerClient;

$debugger = new DebuggerClient();
$debuggee = $debugger->debugee();
$debuggee->register();
```

### Configuration

#### Snapshots

Debugger snapshots allow you to capture and inspect the call stack and local
variables in your application without stopping or slowing it down. In general,
you will set breakpoints via the Stackdriver Debugger UI in the
[Cloud Platform Console][debugger-console].

See [Using Debug Snapshots][using-debug-snapshots] for more information on
snapshots.

#### Logpoints

Debugger logpoints allow you to inject logging into running services without
restarting or interfering with the normal function of the service. This can be
useful for debugging production issues without having to add log statements and
redeploy.

By default, we will send all log messages to Stackdriver Logging, but you can
customize this by providing any PSR-3 compatible logger. For example, to use
`monolog`:

```php
$agent = new Google\Cloud\Debugger\Agent([
    'logger' => new Monolog\Logger('name')
]);
```
See [Using Debug Logpoints][using-debug-logpoints] for more information on
logpoints.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation][official-documentation].
2. Take a look at [in-depth usage samples][usage-samples].

[semaphore-extensions]: http://php.net/manual/en/book.sem.php
[batch-daemon]: https://github.com/googleapis/google-cloud-php/blob/main/src/Core/Batch/BatchDaemon.php
[debugger-daemon]: https://cloud.google.com/php/docs/reference/debugger/latest/Daemon
[pecl-debugger]: https://pecl.php.net/package/stackdriver_debugger
[debugger-console]: https://console.cloud.google.com/debug
[using-debug-snapshots]: https://cloud.google.com/debugger/docs/debugging
[using-debug-logpoints]: https://cloud.google.com/debugger/docs/logpoints
[official-documentation]: https://cloud.google.com/debugger/docs/
[usage-samples]: https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/debugger
