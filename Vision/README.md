# Google Cloud Vision for PHP

> Idiomatic PHP client for [Cloud Vision](https://cloud.google.com/vision/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-vision/v/stable)](https://packagist.org/packages/google/cloud-vision) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-vision.svg)](https://packagist.org/packages/google/cloud-vision)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-vision/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows developers to easily integrate vision detection features within applications, including image labeling, face and
landmark detection, optical character recognition (OCR), and tagging of explicit content.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-vision
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Vision\V1\Client\ProductSearchClient;
use Google\Cloud\Vision\V1\GetProductRequest;
use Google\Cloud\Vision\V1\Product;

// Create a client.
$productSearchClient = new ProductSearchClient();

// Prepare the request message.
$request = (new GetProductRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Product $response */
    $response = $productSearchClient->getProduct($request);
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

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/vision/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/vision/).
