# Google Cloud Translate V3 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Translate\V3\TranslationServiceClient;

$translationClient = new TranslationServiceClient();
$content = ['one', 'two', 'three'];
$targetLanguage = 'es';
$response = $translationClient->translateText(
    $content,
    $targetLanguage,
    TranslationServiceClient::locationName('[PROJECT_ID]', 'global')
);

foreach ($response->getTranslations() as $key => $translation) {
    $separator = $key === 2
        ? '!'
        : ', ';
    echo $translation->getTranslatedText() . $separator;
}
```
