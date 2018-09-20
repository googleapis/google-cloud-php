# Google Cloud Translation for PHP

> Idiomatic PHP client for [Translation](https://cloud.google.com/translate/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-translate/v/stable)](https://packagist.org/packages/google/cloud-translate) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-translate.svg)](https://packagist.org/packages/google/cloud-translate)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-translate/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Dynamically translates text between thousands of language pairs. The Cloud
Translation API lets websites and programs integrate with the translation
service programmatically. The Google Translation API is part of the larger Cloud
Machine Learning API family.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-translate
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Translate\TranslateClient;

$translate = new TranslateClient([
    'key' => 'your_key'
]);

// Translate text from english to french.
$result = $translate->translate('Hello world!', [
    'target' => 'fr'
]);

echo $result['text'] . "\n";

// Detect the language of a string.
$result = $translate->detectLanguage('Greetings from Michigan!');

echo $result['languageCode'] . "\n";

// Get the languages supported for translation specifically for your target language.
$languages = $translate->localizedLanguages([
    'target' => 'en'
]);

foreach ($languages as $language) {
    echo $language['name'] . "\n";
    echo $language['code'] . "\n";
}

// Get all languages supported for translation.
$languages = $translate->languages();

foreach ($languages as $language) {
    echo $language . "\n";
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/translation/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/translate/).
