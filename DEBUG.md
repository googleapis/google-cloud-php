# Debugging

There are a few features built into the Google Cloud PHP client libraries which can help you debug
your application. This guide will show you how to log client library requests and responses.

> :warning:
>
> These logs are not intended to be used in production and are meant to be used only for quickly
> debugging a project. The logs consists of basic logging to STDOUT, which may or may not include
> sensitive information. Make sure that once you are done debugging to disable the debugging flag or
> configuration used to avoid leaking sensitive user data. This may also include authentication
> tokens.

## Log examples

```php
// debug-logging-example.php
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;

$client = new TranslationServiceClient();

$request = new TranslateTextRequest();
$request->setTargetLanguageCode('en-US');
$request->setContents(['こんにちは']);
$request->setParent('projects/php-docs-samples-kokoro');

// The request and response will be logged to STDOUT when the environment
// variable GOOGLE_SDK_PHP_LOGGING=true
$response = $client->translateText($request);
```

```sh
$ GOOGLE_SDK_PHP_LOGGING=true php debug-logging-example.php
{"timestamp":"2024-12-11T19:40:00+00:00","severity":"DEBUG","processId":44180,"jsonPayload":{"serviceName":"google.cloud.translation.v3.TranslationService","clientConfiguration":[]}}
{"timestamp":"2024-12-11T19:40:00+00:00","severity":"DEBUG","processId":44180,"requestId":3821560043,"jsonPayload":{"request.method":"POST","request.url":"https://oauth2.googleapis.com/token","request.headers":{"Host":["oauth2.googleapis.com"],"Cache-Control":["no-store"],"Content-Type":["application/x-www-form-urlencoded"],"x-goog-api-client":["gl-php/8.3.14 auth/1.45.0 auth-request-type/at cred-type/u"]},"request.payload":"grant_type=refresh_token&refresh_token=<REFRESH_TOKEN>&client_id=<CLIENT_ID>&client_secret=<CLIENT_SECRET>"}}
{"timestamp":"2024-12-11T19:40:00+00:00","severity":"DEBUG","processId":44180,"requestId":3821560043,"jsonPayload":{"response.status":200,"response.headers":{"x-google-esf-cloud-client-params":["backend_service_name: \"oauth2.googleapis.com\" backend_fully_qualified_method: \"google.identity.oauth2.OAuth2Service.GetToken\""],"X-Google-Session-Info":["<SESSION_INFO>"],"Date":["Wed, 11 Dec 2024 19:40:00 GMT"],"Pragma":["no-cache"],"Expires":["Mon, 01 Jan 1990 00:00:00 GMT"],"Cache-Control":["no-cache, no-store, max-age=0, must-revalidate"],"Content-Type":["application/json; charset=utf-8"],"X-Google-Security-Signals":["FRAMEWORK=ONE_PLATFORM,ENV=borg,ENV_DEBUG=borg_user:identity-oauth2-proxy;borg_job:prod.identity-oauth2-proxy","FRAMEWORK=HTTPSERVER2,BUILD=GOOGLE3,BUILD_DEBUG=cl:694072944,ENV=borg,ENV_DEBUG=borg_user:identity-oauth2-proxy;borg_job:prod.identity-oauth2-proxy"],"Vary":["X-Origin","Referer","Origin,Accept-Encoding"],"Server":["scaffolding on HTTPServer2"],"X-Google-Netmon-Label":["/bns/dz/borg/dz/bns/identity-oauth2-proxy/prod.identity-oauth2-proxy/4"],"X-XSS-Protection":["0"],"X-Frame-Options":["SAMEORIGIN"],"X-Content-Type-Options":["nosniff"],"X-Google-GFE-Service-Trace":["google-identity-oauth2-oauth2proxyservice-prod"],"X-Google-Backends":["unix:/tmp/esfbackend.1733439890.116447.177528,/bns/dz/borg/dz/bns/identity-oauth2-proxy/prod.identity-oauth2-proxy/4,/bns/ncsfoa/borg/ncsfoa/bns/blue-layer1-gfe-prod-edge/prod.blue-layer1-gfe.sfo03s27/15"],"X-Google-GFE-Request-Trace":["acsfon13:443,/bns/dz/borg/dz/bns/identity-oauth2-proxy/prod.identity-oauth2-proxy/4,acsfon13:443"],"X-Google-DOS-Service-Trace":["main:google-identity-oauth2-oauth2proxyservice-prod,main:GLOBAL_all_non_cloud"],"X-Google-GFE-Handshake-Trace":["GFE: /bns/ncsfoa/borg/ncsfoa/bns/blue-layer1-gfe-prod-edge/prod.blue-layer1-gfe.sfo03s27/15,Mentat oracle: [2002:a05:635e:38e:b0:178:f5eb:ee40]:9801"],"X-Google-Service":["google-identity-oauth2-oauth2proxyservice-prod"],"X-Google-GFE-Response-Code-Details-Trace":["response_code_set_by_backend"],"X-Google-GFE-Response-Body-Transformations":["gunzipped,chunked"],"X-Google-Shellfish-Status":["CA0gBEBG"],"X-Google-GFE-Version":["2.903.2"],"Alt-Svc":["h3=\":443\"; ma=2592000,h3-29=\":443\"; ma=2592000"],"Accept-Ranges":["none"],"Transfer-Encoding":["chunked"]},"response.payload":"{\n  \"access_token\": \"<ACCESS_TOKEN>\",\n  \"expires_in\": 3599,\n  \"scope\": \"https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/sqlservice.login https://www.googleapis.com/auth/cloud-platform openid\",\n  \"token_type\": \"Bearer\",\n  \"id_token\": \"<ID_TOKEN>","latencyMillis":114}}
{"timestamp":"2024-12-11T19:40:00+00:00","severity":"DEBUG","processId":44180,"requestId":4274868307,"jsonPayload":{"request.headers":{"x-goog-api-client":["gl-php/8.3.14 gapic/1.20.0 gax/1.36.0 grpc/1.59.1 rest/1.36.0 pb/+n"],"User-Agent":["gcloud-php-new/1.20.0"],"X-Goog-User-Project":["<YOUR_PROJECT>"],"x-goog-request-params":["parent=projects%2F<YOUR_PROJECT>"]},"request.payload":"{\"contents\":[\"こんにちは\"],\"targetLanguageCode\":\"en-US\",\"parent\":\"projects\\/<YOUR_PROJECT>\"}"}}
{"timestamp":"2024-12-11T19:40:00+00:00","severity":"DEBUG","processId":44180,"requestId":4274868307,"jsonPayload":{"response.status":0,"response.headers":{"pc-high-bwd-bin":["KgIYJQ"]},"response.payload":"{\"translations\":[{\"translatedText\":\"Hello\",\"detectedLanguageCode\":\"ja\"}]}","latencyMillis":242}}
```

<details>
<summary>Request example log (expanded)</summary>

```json
{
    "timestamp": "2024-12-03T15:21:47-05:00",
    "severity": "DEBUG",
    "processId": 44180,
    "requestId": 3821560043,
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

</details>
<details>
<summary>Response example log (expanded)</summary>

```json
{
    "timestamp": "2024-12-03T15:21:47-05:00",
    "severity": "DEBUG",
    "processId": 44180,
    "requestId": 3821560043,
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
        "response.payload": "{\"translations\":[{\"translatedText\": \"Hello\",\"detectedLanguageCode\":\"ja\"}]}",
        "latencyMillis": 152
    }
}
```

</details>

## Configuration

There are a few ways to configure debug logging which we will go through in this document.

### The `GOOGLE_SDK_PHP_LOGGING` environment variable

You can enable logging on all the different clients on your code by using this environment variable
to `true`. Once this environment variable is set, all the clients used on your code will start
logging the requests into `STDOUT`.

```php
putenv('GOOGLE_SDK_PHP_LOGGING=true');

$client = new TranslationServiceClient();
```

Logs usually come with a request log and a response log the exception being streaming requests
where depending on the type of streaming it logs each stream packet. This means that if the client
performs a request to the auth server it will also log that request-response pair before the main
request.


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
$client = new BigtableClient();

// The TranslationServiceClient will not log any requests
$client = new TranslationServiceClient([
    'logger' => false
]);
```
