# Authentication

The recommended way to authenticate to the Google Cloud PHP library is to use
[Application Default Credentials (ADC)](https://cloud.google.com/docs/authentication/application-default-credentials),
which discovers your credentials automatically, based on the environment where your code is running.
To review all of your authentication options, see Project and Credential lookup.

## Quickstart

Here is a quick an opinionated quickstart guide that serves as a mean to get started as quick as possible. There are different ways to authenticate
a client that we will go over this guide, but we wanted to offer a quick way to get started. We will go over the steps of what needs to be done in
order to authenticate a client first and then we will explain said steps in detail for a quickstart.

### Steps:
* Install the Google Cloud CLI.
* Authenticate with `gcloud` to generate the credentials file.
* Instantiate a client.

### Installing the Google Cloud CLI
In order to generate our needed credentials file we need to authenticate to gcloud first. Installation is handled differently depending on your platform.
Here is a link to help you setup the Google Cloud CLI:

https://cloud.google.com/sdk/docs/install

### Authenticate via the `gcloud` command
Once the Google Cloud CLI tools are installed it is required that we authenticate via the `gcloud`:
```shell
$ gcloud init
$ gcloud auth application-default login
```

This will create a local file in your system that the authentication library for our client will read in order to make requests to the apis with those credentials.
This file is located in different place depending on your system.

Windows:
```
%APPDATA%\gcloud\application_default_credentials.json
```

Linux and MacOS:
```
$HOME/.config/gcloud/application_default_credentials.json
```

### Instantiating the client
Once we have the `application_default_credentials.json` that we created on the previous step now we can instantiate a client which internally using the Google Auth library
will take that file and use it to authenticate your requests:
```php
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;

// Instantiating the client gathers the credentials from the `application_default_credentials.json`
$client = new TranslationServiceClient();

$request = new TranslateTextRequest();
$request->setParent('<YOUR_PROJECT_ID>');
$request->setTargetLanguageCode('en-US');
$request->setContents('こんにちは');

// The request will contain the authentication token based on the default credentials file
$response = $client->translateText($request);
var_dump($response);
```

This quickstart guide is meant to be used as a quick and easy way to start development and get started on how you can authenticate your requests. There are diferent ways to authenticate your
requests which are explained in this document.

For more information about authentication at Google, see [the authentication guide](https://cloud.google.com/docs/authentication).
Specific instructions and environment variables for each individual service are linked from the README documents listed below for each service.

## Credential Lookup

The Google Cloud PHP library provides several mechanisms to configure your system without
providing **Service Account Credentials** directly in code.

**Credentials** are discovered in the following order:

1. Credentials specified in code
2. Path to credential file in environment variables
3. Credentials specified in a local ADC file
4. Credentials from an attached service account (for code running on Google Cloud Platform)

### Google Cloud Platform environments

While running on Google Cloud Platform environments such as Google Compute Engine, Google App Engine and
Google Kubernetes Engine, no extra work is needed. The **Project ID** and **Credentials** and are
discovered automatically from the attached service account. Code should be written as if already authenticated.

For more information, see
[Set up ADC for Google Cloud services](https://cloud.google.com/docs/authentication/provide-credentials-adc#attached-sa).

### Environment Variables

**NOTE**: This library uses [`getenv`](https://www.php.net/manual/en/function.getenv.php), so if your environemnt
variables are set in PHP, they must use [`putenv`](https://www.php.net/manual/en/function.putenv.php),

```php
putenv("GOOGLE_APPLICATION_CREDENTIALS=" . __DIR__ . '/your-credentials-file.json');
```
The **Project ID** and **Credentials JSON** can be placed in environment variables instead of declaring them directly in code.

Here are the environment variables that Google Cloud PHP checks for project ID:

1. `GOOGLE_CLOUD_PROJECT`
2. `GCLOUD_PROJECT` (deprecated)

Here are the environment variables that Google Cloud PHP checks for credentials:

1. `GOOGLE_APPLICATION_CREDENTIALS` - Path to JSON file

The JSON file can contain credentials created for
[workload identity federation](https://cloud.google.com/iam/docs/workload-identity-federation),
[workforce identity federation](https://cloud.google.com/iam/docs/workforce-identity-federation), or a
[service account key](https://cloud.google.com/docs/authentication/provide-credentials-adc#local-key).

Note: Service account keys are a security risk if not managed correctly. You should
[choose a more secure alternative to service account keys](https://cloud.google.com/docs/authentication#auth-decision-tree)
whenever possible.

### Client Authentication

Each Google Cloud PHP client may be authenticated in code when creating a client library instance.

Most clients use the `credentials` option for providing credentials as a constructor option:

```php
require 'vendor/autoload.php';

use Google\Cloud\VideoIntelligence\V1\VideoIntelligenceServiceClient;

// Authenticating with keyfile data.
$video = new VideoIntelligenceServiceClient([
    'credentials' => json_decode(file_get_contents('/path/to/credential-file.json'), true)
]);

// Authenticating with a keyfile path.
$video = new VideoIntelligenceServiceClient([
    'credentials' => '/path/to/credential-file.json'
]);
```

However, some clients use the `keyFile` or `keyFilePath` option:

```php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

// Authenticating with keyfile data.
$storage = new StorageClient([
    'keyFile' => json_decode(file_get_contents('/path/to/keyfile.json'), true)
]);

// Authenticating with a keyfile path.
$storage = new StorageClient([
    'keyFilePath' => '/path/to/keyfile.json'
]);

// Providing the Google Cloud project ID.
$storage = new StorageClient([
    'projectId' => 'myProject'
]);
```

Check the [client documentation][php-ref-docs] for the client library you're using.

[php-ref-docs]: https://cloud.google.com/php/docs/reference

### Local ADC file

This option allows for an easy way to authenticate in a local environment during development.
If credentials are not provided in code or in environment variables, then your user credentials can be discovered
from your local ADC file.

To set up a local ADC file:

1. [Download, install, and initialize the Cloud SDK](https://cloud.google.com/sdk)
2. Create your local ADC file:

```sh
gcloud auth application-default login
```

3. Write code as if already authenticated.

**NOTE:** Because this method relies on your user credentials, it is _not_ recommended for running in production.

For more information about setting up authentication for a local development environment, see
[Set up Application Default Credentials](https://cloud.google.com/docs/authentication/provide-credentials-adc#local-dev).

## Troubleshooting

If you're having trouble authenticating open a [Github Issue](https://github.com/googleapis/google-cloud-php/issues/new?title=Authentication+question) to get help.  Also consider searching or asking [questions](http://stackoverflow.com/questions/tagged/google-cloud-platform+php) on [StackOverflow](http://stackoverflow.com).
