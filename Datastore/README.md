# Google Cloud PHP Datastore

> Idiomatic PHP client for [Cloud Datastore](https://cloud.google.com/datastore/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-datastore/v/stable)](https://packagist.org/packages/google/cloud-datastore) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-datastore.svg)](https://packagist.org/packages/google/cloud-datastore)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-datastore/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A NoSQL document database built for automatic scaling, high performance, and
ease of application development. While the Cloud Datastore interface has many of
the same features as traditional databases, as a NoSQL database it differs from
them in the way it describes relationships between data objects.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-datastore
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Datastore\V1\BeginTransactionRequest;
use Google\Cloud\Datastore\V1\BeginTransactionResponse;
use Google\Cloud\Datastore\V1\Client\DatastoreClient;

// Create a client.
$datastoreClient = new DatastoreClient();

// Prepare the request message.
$request = (new BeginTransactionRequest())
    ->setProjectId($projectId);

// Call the API and handle any network failures.
try {
    /** @var BeginTransactionResponse $response */
    $response = $datastoreClient->beginTransaction($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Compatibility with Google App Engine

This component is compatible with PHP projects on Google App Engine in the Standard or Flexible environments. To maximize the performance of datastore operations in your app, we recommend the following configuration:
1. PHP 7 runtime
2. Enable grpc.so and protobuf.so in your php.ini file
3. Set your DatastoreClient object's 'transport' option to 'grpc'

You are likely to experience less optimal datastore performance using the PHP 5 runtime on App Engine standard due to the lack of the protobuf extension.


### Next Steps

1. Understand the [official documentation](https://cloud.google.com/datastore/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/datastore).
