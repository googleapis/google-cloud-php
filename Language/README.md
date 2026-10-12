# Google Cloud PHP Natural Language

> Idiomatic PHP client for [Cloud Natural Language](https://cloud.google.com/natural-language/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-language/v/stable)](https://packagist.org/packages/google/cloud-language) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-language.svg)](https://packagist.org/packages/google/cloud-language)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-language/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Provides natural language understanding technologies to developers, including sentiment analysis, entity analysis,
entity sentiment analysis, content classification, and syntax analysis. This API is part of the larger Cloud Machine Learning API family.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-language
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Language\V2\AnalyzeSentimentRequest;
use Google\Cloud\Language\V2\AnalyzeSentimentResponse;
use Google\Cloud\Language\V2\Client\LanguageServiceClient;
use Google\Cloud\Language\V2\Document;

// Create a client.
$languageServiceClient = new LanguageServiceClient();

// Prepare the request message.
$document = new Document();
$request = (new AnalyzeSentimentRequest())
    ->setDocument($document);

// Call the API and handle any network failures.
try {
    /** @var AnalyzeSentimentResponse $response */
    $response = $languageServiceClient->analyzeSentiment($request);
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

1. Understand the [official documentation](https://cloud.google.com/natural-language/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/language).
