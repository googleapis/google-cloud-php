# Google Cloud PubSub for PHP

> Idiomatic PHP client for [Cloud Pub/Sub](https://cloud.google.com/pubsub/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-pubsub/v/stable)](https://packagist.org/packages/google/cloud-pubsub) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-pubsub.svg)](https://packagist.org/packages/google/cloud-pubsub)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-pubsub/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A fully-managed real-time messaging service that allows you to send and receive messages between independent applications.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-pubsub
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\GetTopicRequest;
use Google\Cloud\PubSub\V1\Topic;

// Create a client.
$publisherClient = new PublisherClient();

// Prepare the request message.
$request = (new GetTopicRequest())
    ->setTopic($formattedTopic);

// Call the API and handle any network failures.
try {
    /** @var Topic $response */
    $response = $publisherClient->getTopic($request);
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

Please see the [migration guide](./MIGRATING.md) to upgrade from **V1** of the library to **V2**.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/pubsub/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/pubsub/).
