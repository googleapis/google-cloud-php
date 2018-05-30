# Google Cloud Speech V1p1beta1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;

$speechClient = new SpeechClient();
try {
    $encoding = RecognitionConfig_AudioEncoding::FLAC;
    $sampleRateHertz = 44100;
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setEncoding($encoding);
    $config->setSampleRateHertz($sampleRateHertz);
    $config->setLanguageCode($languageCode);
    $uri = 'gs://bucket_name/file_name.flac';
    $audio = new RecognitionAudio();
    $audio->setUri($uri);
    $response = $speechClient->recognize($config, $audio);
} finally {
    $speechClient->close();
}
```
