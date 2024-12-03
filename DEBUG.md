# Debugging

There are a few features built into the Google Cloud PHP client libraries which can help you debug
your application. This guide will show you how to enable logging the requests and responses the
client libraries are performing internally.

> :warning:
>
> These logs are not intended to be used in production and is meant to be used for quickly
> debugging a project. The logs consists of basic logging into the STDOUT of your system which may
> or may not include sensitive information. Make sure that once you are done debugging to disable
> the debugging flag or configuration used to avoid leaking sensitive user data. This may also
> include authentication tokens.

## Configuration

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

Logs usually come with a request log and a response log the exception being streaming requests
where depending on the type of streaming it logs each stream packet. This means that if the client performs a request to the auth server it will also log that request-response pair before the main request.

<details>
<summary>Log examples</summary>

### Request example log
```json
{
    "timestamp": "2024-12-03T15:21:47-05:00",
    "severity": "DEBUG",
    "clientId": 83,
    "requestId": 2435,
    "jsonPayload": {
        "request.method": "POST",
        "request.url": "https://translate.googleapis.com/v3/projects/<YOUR_PROJECT",
        "request.headers": {
            "Host": [
                "translate.googleapis.com"
            ],
            "Content-Type": [
                "application/json"
            ],
            "x-goog-api-client": [
                "gl-php/8.2.24 gapic/1.20.0 gax/1.35.0 grpc/1.66.0 rest/1.35.0 pb/+n"
            ],
            "User-Agent": [
                "gcloud-php-new/1.20.0"
            ],
            "X-Goog-User-Project": [
                "<YOUR_PROJECT>"
            ],
            "x-goog-request-params": [
                "parent=projects%2F<YOUR_PROJECT>"
            ],
            "authorization": [
                "Bearer <YOUR_AUTHORIZATION_TOKEN>"
            ]
        },
        "request.payload": "{\"contents\":[\"こんにちは\"],\"targetLanguageCode\":\"en-US\",\"parent\":\"projects\\/<YOUR_PROJECT>\"}"
    }
}
```

### Response example log
```json
{
    "timestamp": "2024-12-03T15:21:47-05:00",
    "severity": "DEBUG",
    "clientId": 83,
    "requestId": 2435,
    "jsonPayload": {
        "response.headers": {
            "Content-Type": [
                "application/json; charset=UTF-8"
            ],
            "Vary": [
                "X-Origin",
                "Referer",
                "Origin,Accept-Encoding"
            ],
            "Date": [
                "Tue, 03 Dec 2024 20:21:47 GMT"
            ],
            "Server": [
                "ESF"
            ],
            "Cache-Control": [
                "private"
            ],
            "X-XSS-Protection": [
                "0"
            ],
            "X-Frame-Options": [
                "SAMEORIGIN"
            ],
            "X-Content-Type-Options": [
                "nosniff"
            ],
            "Accept-Ranges": [
                "none"
            ],
            "Transfer-Encoding": [
                "chunked"
            ]
        },
        "response.payload": "{\n  \"translations\": [\n    {\n      \"translatedText\": \"Hello\",\n      \"detectedLanguageCode\": \"ja\"\n    }\n  ]\n}\n",
        "latencyMillis": 152
    }
}
```

</details>

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
