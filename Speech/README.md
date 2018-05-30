# Google Cloud Speech for PHP

> Idiomatic PHP client for [Cloud Speech](https://cloud.google.com/speech/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-speech/v/stable)](https://packagist.org/packages/google/cloud-speech) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-speech.svg)](https://packagist.org/packages/google/cloud-speech)

* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-speech/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Enables easy integration of Google speech recognition technologies into developer applications. Send audio and receive a
text transcription from the Speech-to-Text API service.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-speech
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/GoogleCloudPlatform/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Speech\SpeechClient;

$speech = new SpeechClient([
    'languageCode' => 'en-US'
]);

// Recognize the speech in an audio file.
$results = $speech->recognize(
    fopen(__DIR__ . '/audio_sample.flac', 'r')
);

foreach ($results as $result) {
    echo $result->topAlternative()['transcript'] . "\n";
}
```

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/speech/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/speech/).

