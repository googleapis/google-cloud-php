# Migration Guide

This migration guide shows how to migrate `google/cloud-translate` to v2.

**NOTE**: The package version (e.g. `google/cloud-translate:^2.0`) is distinct
from the Translate API version `V3`, which this package calls.

## Client Initialization

The `TranslateClient` has been replaced by `TranslationServiceClient`.

**Before**
```php
use Google\Cloud\Translate\TranslateClient;

$translate = new TranslateClient();
```

**After**
```php
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;

$translate = new TranslationServiceClient();
```

## Translate Text

The `translate()` method has been replaced by `translateText()`. The arguments have also changed to accept a request object.

### Single Translation

**Before**
```php
use Google\Cloud\Translate\TranslateClient;

$translate = new TranslateClient([
    'projectId' => 'my-project'
]);

$result = $translate->translate('Hello, world!', [
    'target' => 'fr'
]);

echo $result['text'];
```

**After**
```php
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;

$translate = new TranslationServiceClient();

$projectId = 'my-project';
$location = 'global';
$parent = $translate->locationName($projectId, $location);

$request = (new TranslateTextRequest())
    ->setContents(['Hello, world!'])
    ->setTargetLanguageCode('fr')
    ->setParent($parent);

$response = $translate->translateText($request);

echo $response->getTranslations()[0]->getTranslatedText();
```

### Batch Translation

**Before**
```php
use Google\Cloud\Translate\TranslateClient;

$translate = new TranslateClient([
    'projectId' => 'my-project'
]);

$results = $translate->translateBatch([
    'Hello, world!',
    'My name is Jeff.'
], [
    'target' => 'fr'
]);

foreach ($results as $result) {
    echo $result['text'] . "
";
}
```

**After**
```php
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;

$translate = new TranslationServiceClient();

$projectId = 'my-project';
$location = 'global';
$parent = $translate->locationName($projectId, $location);

$request = (new TranslateTextRequest())
    ->setContents([
        'Hello, world!',
        'My name is Jeff.'
    ])
    ->setTargetLanguageCode('fr')
    ->setParent($parent);

$response = $translate->translateText($request);

foreach ($response->getTranslations() as $translation) {
    echo $translation->getTranslatedText() . "
";
}
```

## Formatting Project Name

In `v2`, you need to provide a formatted project name as the parent. You can use
the `locationName` method on the client to format this.

```php
$projectId = 'my-project';
$location = 'global';
$parent = $translate->locationName($projectId, $location);
```
