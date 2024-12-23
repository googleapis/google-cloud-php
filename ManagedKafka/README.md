# Google Cloud Managed Kafka for PHP

> Idiomatic PHP client for [Google Cloud Managed Kafka](https://cloud.google.com/managed-kafka).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-managedkafka/v/stable)](https://packagist.org/packages/google/cloud-managedkafka) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-managedkafka.svg)](https://packagist.org/packages/google/cloud-managedkafka)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-managedkafka/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-managedkafka
```

> Browse the complete list of [Google Cloud APIs](https://cloud.google.com/php/docs/reference)
> for PHP

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits
offered by gRPC (such as streaming methods) please see our
[gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
Google\ApiCore\ApiException;
Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaClient;
Google\Cloud\ManagedKafka\V1\Cluster;
Google\Cloud\ManagedKafka\V1\GetClusterRequest;

// Create a client.
$managedKafkaClient = new ManagedKafkaClient();

// Prepare the request message.
$request = (new GetClusterRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Cluster $response */
    $response = $managedKafkaClient->getCluster($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-managedkafka/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/managed-kafka).
