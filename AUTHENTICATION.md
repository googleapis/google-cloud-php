# Authentication

The recommended way to authenticate to the Google Cloud PHP library is to use
[Application Default Credentials (ADC)](https://cloud.google.com/docs/authentication/application-default-credentials),
which discovers your credentials automatically, based on the environment where your code is running.
To review all of your authentication options see [Credential Lookup](#credential-lookup).

For more information about authentication at Google, see [the authentication guide](https://cloud.google.com/docs/authentication).
Specific instructions and environment variables for each individual service are linked from the README documents listed below for each service.

## Credential Lookup

The Google Cloud PHP library provides several mechanisms to configure your system without providing
**Service Account Credentials** directly in code.

**Credentials** are discovered in the following order:

1. Credentials specified in code
2. Path to credential file in environment variables
3. Credentials specified in a local ADC file
4. Credentials from an attached service account (for code running on Google Cloud Platform)

### Google Cloud Platform environments

While running on Google Cloud Platform environments such as Google Compute Engine, Google App Engine
and Google Kubernetes Engine, no extra work is needed. The **Credentials** and are discovered
automatically from the attached service account. Code should be written as if already authenticated.

For more information, see
[Set up ADC for Google Cloud services](https://cloud.google.com/docs/authentication/provide-credentials-adc#attached-sa).

### Environment Variables

**NOTE**: This library uses [`getenv`](https://www.php.net/manual/en/function.getenv.php), so if
your environemnt variables are set in PHP, they must use
[`putenv`](https://www.php.net/manual/en/function.putenv.php),

```php
putenv("GOOGLE_APPLICATION_CREDENTIALS=" . __DIR__ . '/your-credentials-file.json');
```
The **Credentials JSON** can be placed in environment variables instead of
declaring them directly in code.

Here are the environment variables that Google Cloud PHP checks for credentials:

1. `GOOGLE_APPLICATION_CREDENTIALS` - Path to JSON file

The JSON file can contain credentials created for
[workload identity federation](https://cloud.google.com/iam/docs/workload-identity-federation),
[workforce identity federation](https://cloud.google.com/iam/docs/workforce-identity-federation), or a
[service account key](https://cloud.google.com/docs/authentication/provide-credentials-adc#local-key).

Note: Service account keys are a security risk if not managed correctly. You should
[choose a more secure alternative to service account keys](https://cloud.google.com/docs/authentication#auth-decision-tree)
whenever possible.

### Project ID detection

Some libraries support setting up the project ID via the `GOOGLE_CLOUD_PROJECT` environment variable.
```php
putenv("GOOGLE_CLOUD_PROJECT=<YOUR_PROJECT_ID>");
```
The libraries that support this environment variable are:
- Bigtable
- PubSub
- Storage
- Spanner
- BigQuery
- Datastore
- Firestore
- Logging
- Trace
- Translate

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

### Local ADC file

This option allows for an easy way to authenticate in a local environment during development. If
credentials are not provided in code or in environment variables, then your user credentials can be
discovered from your local ADC file.

To set up a local ADC file:

1. [Download, install, and initialize the Cloud SDK](https://cloud.google.com/sdk)
2. Create your local ADC file:

```sh
gcloud auth application-default login
```

3. Write code as if already authenticated.

**NOTE:** Because this method relies on your user credentials, it is _not_ recommended for running
in production.

For more information about setting up authentication for a local development environment, see
[Set up Application Default Credentials](https://cloud.google.com/docs/authentication/provide-credentials-adc#local-dev).

### API Keys

[API keys][api_keys] are a great way to quickly authenticate in a local environment during development. If
you'd like to authenticate your client with API keys, use the `apiKey` client option when creating a new
instance of your client:

```php
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\ListKeysRequest;

// Create a client.
$recaptcha = new RecaptchaEnterpriseServiceClient([
    'apiKey' => $yourApiKey,
]);

// Prepare the request message.
$formattedParent = RecaptchaEnterpriseServiceClient::projectName('[PROJECT]');
$request = (new ListKeysRequest())->setParent($formattedParent);

// Call the API
$response = $recaptchaEnterpriseServiceClient->listKeys($request);
```

[api_keys]: https://cloud.google.com/docs/authentication/api-keys

## Troubleshooting

If you're having trouble authenticating open a
[Github Issue](https://github.com/googleapis/google-cloud-php/issues/new?title=Authentication+question)
to get help. Also consider searching or asking
[questions](http://stackoverflow.com/questions/tagged/google-cloud-platform+php) on
[StackOverflow](http://stackoverflow.com).
