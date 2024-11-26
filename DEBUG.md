# Debugging logs

We have support for simple debugging in our libraries. This debugging support logs the requests that
the Client Libraries are performing internally and provides a quick glance of what the request and
response contains.

> :warning:
>
> These logs are not intended to be used in production and is meant to be used for quickly
> debugging a project. The logs consists on basic logging into the STDOUT of your system which may
> or may not include sensitive information. Make sure that once you are done debugging to disable
> the debugging flag or configuration used to avoid leaking sensitive user data, This may also
> include authentication tokens.

## Debugging usage

There are multiple ways to configure the debugging logs which we will go through in this document.

### The `GOOGLE_SDK_PHP_LOGGING` environment variable

You can enable logging on all the different clients on your code by using this environment variable
to `true`. Once this environment variable is set, all the clients used on your code will start
logging the requests into `STDOUT`.

```php
putenv('GOOGLE_SDK_PHP_LOGGING=true');

$client = new TranslationServiceClient([]);

$request = new TranslateTextRequest();
$request->setTargetLanguageCode('en-US');
$request->setContents(['こんにちは']);
$request->setParent('projects/php-docs-samples-kokoro');

// This will be logged to STDOUT
$response = $client->translateText($request);
```

### Passing a PSR-3 compliant logger

The debugging code has been made to comply with the PSR-3 logging interface. With in mind we can
pass a compatible logger to the client configuration.
```php
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

$monologLogger = new Logger('sdk client');
$monologLogger->pushHandler(new StreamHandler('php://stdout', Level::Debug));

$client = new TranslationServiceClient([
    'logger' => $monologLogger
]);
```

With this you now you will be using Monolog's logger instead of the internal one. This also opens
the opportunity to extend the capabilities of logging in case that you have specific needs, a PSR-3
logger implementation can be passed to manage the logs in any way that are needed.

### Passing `false` to the configuration

The `logger` option on the client configuration options disables any logging for that specific
client.

```php
$client = new TranslationServiceClient([
    'logger' => false
]);
```

With this you can have different clients and either log in only one or disable individual clients
from logging to avoid excessive noise.

```php
putenv('GOOGLE_SDK_PHP_LOGGING=true');

// The Big Table client will log all the requests
$client = new BigtableClient([]);

// The TranslationServiceClient will not log any requests
$client = new TranslationServiceClient([
    'logger' => false
]);
```
