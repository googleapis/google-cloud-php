# Cloud Text-to-Speech for PHP

> Idiomatic PHP client for [Cloud Text-to-Speech](https://cloud.google.com/text-to-speech/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-text-to-speech/v/stable)](https://packagist.org/packages/google/cloud-text-to-speech) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-text-to-speech.svg)](https://packagist.org/packages/google/cloud-text-to-speech)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-text-to-speech/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-text-to-speech
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
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

$textToSpeechClient = new TextToSpeechClient();

$input = new SynthesisInput();
$input->setText('Japan\'s national soccer team won against Colombia!');
$voice = new VoiceSelectionParams();
$voice->setLanguageCode('en-US');
$audioConfig = new AudioConfig();
$audioConfig->setAudioEncoding(AudioEncoding::MP3);

$resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
file_put_contents('test.mp3', $resp->getAudioContent());
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/text-to-speech/docs).
