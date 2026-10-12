# Google Cloud Translation for PHP

> Idiomatic PHP client for [Translation](https://cloud.google.com/translate/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-translate/v/stable)](https://packagist.org/packages/google/cloud-translate) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-translate.svg)](https://packagist.org/packages/google/cloud-translate)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-translate/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Dynamically translates text between thousands of language pairs. The Cloud
Translation API lets websites and programs integrate with the translation
service programmatically. The Google Translation API is part of the larger Cloud
Machine Learning API family.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-translate
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Translate\V3\AdaptiveMtDataset;
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\GetAdaptiveMtDatasetRequest;

// Create a client.
$translationServiceClient = new TranslationServiceClient();

// Prepare the request message.
$request = (new GetAdaptiveMtDatasetRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var AdaptiveMtDataset $response */
    $response = $translationServiceClient->getAdaptiveMtDataset($request);
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

1. Understand the [official documentation](https://cloud.google.com/translation/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/translate/).
