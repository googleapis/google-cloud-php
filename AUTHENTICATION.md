# Authentication

In general, the Google Cloud PHP library uses [Service Account](https://cloud.google.com/iam/docs/creating-managing-service-accounts) credentials to connect to Google Cloud services. When running on Compute Engine the credentials will be discovered automatically. When running on other environments, the Service Account credentials can be specified by providing the path to the [JSON keyfile](https://cloud.google.com/iam/docs/managing-service-account-keys) for the account (or the JSON itself) in environment variables.

General instructions, environment variables, and configuration options are covered in the general [Authentication guide](https://cloud.google.com/docs/authentication/production) for the `google-cloud` umbrella package. Specific instructions and environment variables for each individual service are linked from the README documents listed below for each service.

## Creating a Service Account

Google Cloud requires a **Project ID** and **Service Account Credentials** to connect to the APIs. For detailed instructions on how to create a service account, see the [Authentication guide](https://cloud.google.com/docs/authentication/production#manually).

You will use the **Project ID** and **JSON key file** to connect to most services with Google Cloud PHP.

## Project and Credential Lookup

The Google Cloud PHP library aims to make authentication as simple as possible, and provides several mechanisms to configure your system without providing **Project ID** and **Service Account Credentials** directly in code.

**Project ID** is discovered in the following order:

1. Specify project ID in code
2. Discover project ID in environment variables
3. Discover GCE project ID

**Credentials** are discovered in the following order:

1. Specify credentials in code
2. Discover credentials path in environment variables
3. Discover credentials file in the Cloud SDK's path
4. Discover GCE credentials

### Google Cloud Platform environments

While running on Google Cloud Platform environments such as Google Compute Engine, Google App Engine and Google Kubernetes Engine, no extra work is needed. The **Project ID** and **Credentials** and are discovered automatically. Code should be written as if already authenticated.

### Environment Variables

The **Project ID** and **Credentials JSON** can be placed in environment variables instead of declaring them directly in code.

Here are the environment variables that Google Cloud PHP checks for project ID:

1. `GOOGLE_CLOUD_PROJECT`
2. `GCLOUD_PROJECT` (deprecated)

Here are the environment variables that Google Cloud PHP checks for credentials:

1. `GOOGLE_APPLICATION_CREDENTIALS` - Path to JSON file

### Client Authentication

Each Google Cloud PHP client may be authenticated in code when creating a client library instance.

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

Generated clients use a slightly different method to provide authentication in code.

```php
require 'vendor/autoload.php';

use Google\Cloud\VideoIntelligence\V1\VideoIntelligenceServiceClient;

// Authenticating with keyfile data.
$video = new VideoIntelligenceServiceClient([
    'credentials' => json_decode(file_get_contents('/path/to/keyfile.json'), true)
]);

// Authenticating with a keyfile path.
$video = new VideoIntelligenceServiceClient([
    'credentials' => '/path/to/keyfile.json'
]);
```

### Cloud SDK

This option allows for an easy way to authenticate during development. If credentials are not provided in code or in environment variables, then Cloud SDK credentials are discovered.

To configure your system for this, simply:

1. [Download and install the Cloud SDK](https://cloud.google.com/sdk)
2. Authenticate using OAuth 2.0 `$ gcloud auth login`
3. Write code as if already authenticated.

**NOTE:** This is _not_ recommended for running in production. The Cloud SDK should only be used during development.

## Troubleshooting

If you're having trouble authenticating open a [Github Issue](https://github.com/googleapis/google-cloud-php/issues/new?title=Authentication+question) to get help.  Also consider searching or asking [questions](http://stackoverflow.com/questions/tagged/google-cloud-platform+php) on [StackOverflow](http://stackoverflow.com).
