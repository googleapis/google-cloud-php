# Google Cloud Recommendations AI for PHP

> Idiomatic PHP client for [Google Cloud Recommendations AI](https://cloud.google.com/recommendations-ai).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-recommendations-ai/v/stable)](https://packagist.org/packages/google/cloud-recommendations-ai) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-recommendations-ai.svg)](https://packagist.org/packages/google/cloud-recommendations-ai)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-recommendations-ai/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-recommendations-ai
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\RecommendationEngine\V1beta1\CatalogItem;
use Google\Cloud\RecommendationEngine\V1beta1\Client\CatalogServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\GetCatalogItemRequest;

// Create a client.
$catalogServiceClient = new CatalogServiceClient();

// Prepare the request message.
$request = (new GetCatalogItemRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var CatalogItem $response */
    $response = $catalogServiceClient->getCatalogItem($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered beta. As such, it should be expected to be mostly stable and we're working towards a release candidate. We will address issues and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/recommendations-ai/docs).
