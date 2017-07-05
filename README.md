# Google Cloud PHP Client
> Idiomatic PHP client for [Google Cloud Platform](https://cloud.google.com/) services.

[![Travis Build Status](https://travis-ci.org/GoogleCloudPlatform/google-cloud-php.svg?branch=master)](https://travis-ci.org/GoogleCloudPlatform/google-cloud-php/) [![codecov](https://codecov.io/gh/googlecloudplatform/google-cloud-php/branch/master/graph/badge.svg)](https://codecov.io/gh/googlecloudplatform/google-cloud-php)

* [Homepage](http://googlecloudplatform.github.io/google-cloud-php)
* [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs)

This client supports the following Google Cloud Platform services at a [General Availability](#versioning) quality level:
* [Google Stackdriver Logging](#google-stackdriver-logging-ga) (GA)
* [Google Cloud Datastore](#google-cloud-datastore-ga) (GA)
* [Google Cloud Storage](#google-cloud-storage-ga) (GA)
* [Google Cloud Translation](#google-cloud-translation-ga) (GA)

This client supports the following Google Cloud Platform services at a [Beta](#versioning) quality level:

* [Google BigQuery](#google-bigquery-beta) (Beta)
* [Google Cloud Natural Language](#google-cloud-natural-language-beta) (Beta)
* [Google Cloud Pub/Sub](#google-cloud-pubsub-beta) (Beta)
* [Google Cloud Vision](#google-cloud-vision-beta) (Beta)

This client supports the following Google Cloud Platform services at an [Alpha](#versioning) quality level:
* [Cloud Spanner](#cloud-spanner-alpha) (Alpha)
* [Google Cloud Speech](#google-cloud-speech-alpha) (Alpha)
* [Google Cloud Video Intelligence](#google-cloud-video-intelligence-alpha) (Alpha)
* [Google Stackdriver Trace](#google-stackdriver-trace-alpha) (Alpha)

If you need support for other Google APIs, please check out the [Google APIs Client Library for PHP](https://github.com/google/google-api-php-client).

## Quick Start

```sh
$ composer require google/cloud
```

## Google Stackdriver Logging (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/logging/loggingclient)
- [Official Documentation](https://cloud.google.com/logging/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Logging\LoggingClient;

$logging = new LoggingClient([
    'projectId' => 'my_project'
]);

// Get a logger instance.
$logger = $logging->logger('my_log');

// Write a log entry.
$logger->write('my message');

// List log entries from a specific log.
$entries = $logging->entries([
    'filter' => 'logName = projects/my_project/logs/my_log'
]);

foreach ($entries as $entry) {
    echo $entry->info()['textPayload'] . "\n";
}
```

#### google/cloud-logging

Google Stackdriver Logging can be installed separately by requiring the `google/cloud-logging` composer package:

```
$ require google/cloud-logging
```

## Google Cloud Datastore (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/datastore/datastoreclient)
- [Official Documentation](https://cloud.google.com/datastore/docs/)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$datastore = new DatastoreClient([
    'projectId' => 'my_project'
]);

// Create an entity
$bob = $datastore->entity('Person');
$bob['firstName'] = 'Bob';
$bob['email'] = 'bob@example.com';
$datastore->insert($bob);

// Update the entity
$bob['email'] = 'bobV2@example.com';
$datastore->update($bob);

// If you know the ID of the entity, you can look it up
$key = $datastore->key('Person', '12345328897844');
$entity = $datastore->lookup($key);
```

#### google/cloud-datastore

Google Cloud Datastore can be installed separately by requiring the `google/cloud-datastore` composer package:

```
$ require google/cloud-datastore
```

## Google Cloud Storage (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/storage/storageclient)
- [Official Documentation](https://cloud.google.com/storage/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

$storage = new StorageClient([
    'projectId' => 'my_project'
]);

$bucket = $storage->bucket('my_bucket');

// Upload a file to the bucket.
$bucket->upload(
    fopen('/data/file.txt', 'r')
);

// Using Predefined ACLs to manage object permissions, you may
// upload a file and give read access to anyone with the URL. 
$bucket->upload(
    fopen('/data/file.txt', 'r'),
    [
        'predefinedAcl' => 'publicRead'
    ]
);

// Download and store an object from the bucket locally.
$object = $bucket->object('file_backup.txt');
$object->downloadToFile('/data/file_backup.txt');
```

#### Stream Wrapper

```php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

$storage = new StorageClient([
    'projectId' => 'my_project'
]);
$storage->registerStreamWrapper();

$contents = file_get_contents('gs://my_bucket/file_backup.txt');
```

#### google/cloud-storage

Google Cloud Storage can be installed separately by requiring the `google/cloud-storage` composer package:

```
$ require google/cloud-storage
```

## Google Cloud Translation (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/translate/translateclient)
- [Official Documentation](https://cloud.google.com/translation/docs)

#### Preview

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

#### google/cloud-translate

Google Cloud Translation can be installed separately by requiring the `google/cloud-translate` composer package:

```
$ require google/cloud-translate
```

## Google BigQuery (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/bigquery/bigqueryclient)
- [Official Documentation](https://cloud.google.com/bigquery/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\BigQuery\BigQueryClient;

$bigQuery = new BigQueryClient([
    'projectId' => 'my_project'
]);

// Get an instance of a previously created table.
$dataset = $bigQuery->dataset('my_dataset');
$table = $dataset->table('my_table');

// Begin a job to import data from a CSV file into the table.
$job = $table->load(
    fopen('/data/my_data.csv', 'r')
);

// Run a query and inspect the results.
$queryResults = $bigQuery->runQuery('SELECT * FROM [my_project:my_dataset.my_table]');

foreach ($queryResults->rows() as $row) {
    print_r($row);
}
```

#### google/cloud-bigquery

Google BigQuery can be installed separately by requiring the `google/cloud-bigquery` composer package:

```
$ require google/cloud-bigquery
```

## Google Cloud Natural Language (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/language/languageclient)
- [Official Documentation](https://cloud.google.com/natural-language/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Language\LanguageClient;

$language = new LanguageClient([
    'projectId' => 'my_project'
]);

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

#### google/cloud-language

Google Cloud Natural Language can be installed separately by requiring the `google/cloud-language` composer package:

```
$ require google/cloud-language
```

## Google Cloud Pub/Sub (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/pubsub/pubsubclient)
- [Official Documentation](https://cloud.google.com/pubsub/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\PubSub\PubSubClient;

$pubSub = new PubSubClient([
    'projectId' => 'my_project'
]);

// Get an instance of a previously created topic.
$topic = $pubSub->topic('my_topic');

// Publish a message to the topic.
$topic->publish([
    'data' => 'My new message.',
    'attributes' => [
        'location' => 'Detroit'
    ]
]);

// Get an instance of a previously created subscription.
$subscription = $pubSub->subscription('my_subscription');

// Pull all available messages.
$messages = $subscription->pull();

foreach ($messages as $message) {
    echo $message->data() . "\n";
    echo $message->attribute('location');
}
```

#### google/cloud-pubsub

Google Cloud Pub/Sub can be installed separately by requiring the `google/cloud-pubsub` composer package:

```
$ require google/cloud-pubsub
```

## Google Cloud Vision (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/vision/visionclient)
- [Official Documentation](https://cloud.google.com/vision/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Vision\VisionClient;

$vision = new VisionClient([
    'projectId' => 'my_project'
]);

// Annotate an image, detecting faces.
$image = $vision->image(
    fopen('/data/family_photo.jpg', 'r'),
    ['faces']
);

$annotation = $vision->annotate($image);

// Determine if the detected faces have headwear.
foreach ($annotation->faces() as $key => $face) {
    if ($face->hasHeadwear()) {
        echo "Face $key has headwear.\n";
    }
}
```

#### google/cloud-vision

Google Cloud Vision can be installed separately by requiring the `google/cloud-vision` composer package:

```
$ require google/cloud-vision
```

## Cloud Spanner (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/spanner/spannerclient)
- [Official Documentation](https://cloud.google.com/spanner/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Spanner\SpannerClient;

$spanner = new SpannerClient([
    'projectId' => 'my_project'
]);

$db = $spanner->connect('my-instance', 'my-database');

$userQuery = $db->execute('SELECT * FROM Users WHERE id = @id', [
    'parameters' => [
        'id' => $userId
    ]
]);

$user = $userQuery->rows()->current();

echo 'Hello ' . $user['firstName'];
```

#### google/cloud-spanner

Cloud Spanner can be installed separately by requiring the `google/cloud-spanner` composer package:

```
$ require google/cloud-spanner
```

## Google Cloud Speech (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/speech/speechclient)
- [Official Documentation](https://cloud.google.com/speech/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Speech\SpeechClient;

$speech = new SpeechClient([
    'projectId' => 'my_project',
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

#### google/cloud-speech

Google Cloud Speech can be installed separately by requiring the `google/cloud-speech` composer package:

```
$ require google/cloud-speech
```

## Google Cloud Video Intelligence (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/videointelligence/readme)
- [Official Documentation](https://cloud.google.com/video-intelligence/docs)

#### Preview

```php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\VideoIntelligence\V1beta1\VideoIntelligenceServiceClient;
use google\cloud\videointelligence\v1beta1\Feature;

$client = new VideoIntelligenceServiceClient();

$inputUri = "gs://example-bucket/example-video.mp4";
$features = [
    Feature::LABEL_DETECTION,
];
$operationResponse = $client->annotateVideo($inputUri, $features);
$operationResponse->pollUntilComplete();
if ($operationResponse->operationSucceeded()) {
    $results = $operationResponse->getResult();
    foreach ($results->getAnnotationResultsList() as $result) {
        foreach ($result->getLabelAnnotationsList() as $labelAnnotation) {
            echo "Label: " . $labelAnnotation->getDescription() . "\n";
        }
    }
} else {
    $error = $operationResponse->getError();
    echo "error: " . $error->getMessage() . "\n";
}
```

#### google/cloud-videointelligence

Cloud Video Intelligence can be installed separately by requiring the `google/cloud-videointelligence` composer package:

```
$ require google/cloud-videointelligence
```

## Google Stackdriver Trace (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/trace/traceclient)
- [Official Documentation](https://cloud.google.com/trace/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Trace\TraceClient;

$traceClient = new TraceClient([
    'projectId' => 'my_project'
]);

// Create a Trace
$trace = $traceClient->trace();
$span = $trace->span([
    'name' => 'main'
]);
$span->setStart();
$span->setEnd();

$trace->setSpans([$span]);
$traceClient->insert($trace);

// List recent Traces
foreach($traceClient->traces() as $trace) {
    var_dump($trace->traceId());
}
```

#### google/cloud-trace

Stackdriver Trace can be installed separately by requiring the `google/cloud-trace` composer package:

```
$ require google/cloud-trace
```

## Caching Access Tokens

By default the library will use a simple in-memory caching implementation, however it is possible to override this behavior by passing a [PSR-6](http://www.php-fig.org/psr/psr-6/) caching implementation in to the desired client.

The following example takes advantage of [Symfony's Cache Component](https://github.com/symfony/cache).

```php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

// Please take the proper precautions when storing your access tokens in a cache no matter the implementation.
$cache = new ArrayAdapter();

$storage = new StorageClient([
    'authCache' => $cache
]);
```

## Versioning

This library follows [Semantic Versioning](http://semver.org/).

Please note it is currently under active development. Any release versioned
0.x.y is subject to backwards incompatible changes at any time.

**GA**: Libraries defined at a GA quality level are stable, and will not
introduce backwards-incompatible changes in any minor or patch releases. We will
address issues and requests with the highest priority.

**Beta**: Libraries defined at a Beta quality level are expected to be mostly
stable and we're working towards their release candidate. We will address issues
and requests with a higher priority.

**Alpha**: Libraries defined at an Alpha quality level are still a
work-in-progress and are more likely to get backwards-incompatible updates.

## Contributing

Contributions to this library are always welcome and highly encouraged.

See [CONTRIBUTING](CONTRIBUTING.md) for more information on how to get started.

## License

Apache 2.0 - See [LICENSE](LICENSE) for more information.
