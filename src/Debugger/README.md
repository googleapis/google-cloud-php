# Google PHP Stackdriver Debugger

> Idiomatic PHP client for [Stackdriver Debugger](https://cloud.google.com/debugger/).

* [Homepage](http://googlecloudplatform.github.io/google-cloud-php)
* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-debugger/latest/debugger/debuggerclient)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

## Installation

1. Install the PHP extension from PECL.

    ```bash
    $ pecl install stackdriver_debugger-alpha
    ```

    On Windows, you can download pre-built .dll files [from PECL][pecl-debugger].

    You may also need to enable the extension in your `php.ini` file:

    ```
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

## Configuration

### Snapshots

Debugger snapshots allow you to capture and inspect the call stack and local
variables in your application without stopping or slowing it down. In general,
you will set breakpoints via the Stackdriver Debugger UI in the
[Cloud Platform Console][debugger-console].

See [Using Debug Snapshots][using-debug-snapshots] for more information on
snapshots.

### Logpoints

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

[semaphore-extensions]: http://php.net/manual/en/book.sem.php
[batch-daemon]: https://github.com/GoogleCloudPlatform/google-cloud-php/blob/master/src/Core/Batch/BatchDaemon.php
[debugger-daemon]: http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-debugger/master/debugger/daemon
[pecl-debugger]: https://pecl.php.net/package/stackdriver_debugger
[debugger-console]: https://console.cloud.google.com/debug
[using-debug-snapshots]: https://cloud.google.com/debugger/docs/debugging
[using-debug-logpoints]: https://cloud.google.com/debugger/docs/logpoints
