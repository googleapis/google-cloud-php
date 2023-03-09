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

Now to install just this component:

```sh
$ composer require google/cloud-language
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Language\LanguageClient;

$language = new LanguageClient();

// Analyze a sentence.
$annotation = $language->annotateText('Greetings from Michigan!');

// Check the sentiment.
if ($annotation->sentiment() > 0) {
    echo "This is a positive message.\n";
}

// Detect entities.
$entities = $annotation->entitiesByType('LOCATION');

foreach ($entities as $entity) {
    echo $entity['name'] . "\n";
}

// Parse the syntax.
$tokens = $annotation->tokensByTag('NOUN');

foreach ($tokens as $token) {
    echo $token['text']['content'] . "\n";
}
```

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/natural-language/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/language).
