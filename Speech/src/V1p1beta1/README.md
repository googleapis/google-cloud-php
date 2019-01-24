# Google Cloud Speech V1p1beta1 generated client for PHP

### Sample

```php
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\StreamingRecognitionConfig;

$recognitionConfig = new RecognitionConfig();
$recognitionConfig->setEncoding(AudioEncoding::FLAC);
$recognitionConfig->setSampleRateHertz(44100);
$recognitionConfig->setLanguageCode('en-US');
$config = new StreamingRecognitionConfig();
$config->setConfig($recognitionConfig);

$audioResource = fopen('path/to/audio.flac', 'r');

$responses = $speechClient->recognizeAudioStream($config, $audioResource);

foreach ($responses as $element) {
    // doSomethingWith($element);
}
```
