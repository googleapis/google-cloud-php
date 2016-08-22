# Google Cloud PHP Client
[![Travis Build Status](https://travis-ci.org/GoogleCloudPlatform/gcloud-php.svg?branch=master)](https://travis-ci.org/GoogleCloudPlatform/gcloud-php/)
[![Coverage Status](https://coveralls.io/repos/github/GoogleCloudPlatform/gcloud-php/badge.svg?branch=master)](https://coveralls.io/github/GoogleCloudPlatform/gcloud-php?branch=master)

> Idiomatic PHP client for [Google Cloud Platform](https://cloud.google.com/) services.

* [Homepage](http://googlecloudplatform.github.io/gcloud-php)
* [API Documentation](http://googlecloudplatform.github.io/gcloud-php/#/docs)

This client supports the following Google Cloud Platform services:

* [Google BigQuery](#google-bigquery)
* [Google Stackdriver Logging](#google-stackdriver-logging)
* [Google Cloud Natural Language](#google-cloud-natural-language)
* [Google Cloud Pub/Sub](#google-cloud-pubsub)
* [Google Cloud Storage](#google-cloud-storage)
* [Google Cloud Vision](#google-cloud-vision)

If you need support for other Google APIs, please check out the [Google APIs Client Library for PHP](https://github.com/google/google-api-php-client).

## Quick Start

```sh
$ composer require google/cloud
```

## Google BigQuery

- [API Documentation](http://googlecloudplatform.github.io/gcloud-php/#/docs/latest/bigquery/bigqueryclient)
- [Official Documentation](https://cloud.google.com/bigquery/docs)

#### Preview

```php
<?php
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

## Google Stackdriver Logging

- [API Documentation](http://googlecloudplatform.github.io/gcloud-php/#/docs/latest/logging/loggingclient)
- [Official Documentation](https://cloud.google.com/logging/docs)

#### Preview

```php
<?php
require 'vendor/autoload.php';

use Google\Cloud\Logging\LoggingClient;

$logging = new LoggingClient([
	'projectId' => 'my_project'
]);

// Get a logger instance.
$logger = $logging->logger('my_log');

// Write a log entry.
$entry = $logger->entry('my message', [
	'type' => 'gcs_bucket',
	'labels' => [
		'bucket_name' => 'my_bucket'
	]
]);

$logger->write($entry);

// List log entries from a specific log.
$entries = $logging->entries([
	'filter' => 'logName = projects/my_project/logs/my_log'
]);

foreach ($entries as $entry) {
    echo $entry->info()['textPayload'] . "\n";
}
```

## Google Cloud Natural Language

- [API Documentation](http://googlecloudplatform.github.io/gcloud-php/#/docs/latest/naturallanguage/naturallanguageclient)
- [Official Documentation](https://cloud.google.com/natural-language/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\NaturalLanguage\NaturalLanguageClient;

$language = new NaturalLanguageClient([
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

## Google Cloud Pub/Sub

- [API Documentation](http://googlecloudplatform.github.io/gcloud-php/#/docs/latest/pubsub/pubsubclient)
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
    echo $message['message']['data'] . "\n";
}
```

## Google Cloud Storage

- [API Documentation](http://googlecloudplatform.github.io/gcloud-php/#/docs/latest/storage/storageclient)
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

// Download and store an object from the bucket locally.
$object = $bucket->object('file_backup.txt');
$object->downloadToFile('/data/file_backup.txt');
```

## Google Cloud Vision

- [API Documentation](http://googlecloudplatform.github.io/gcloud-php/#/docs/latest/vision/visionclient)
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

## Versioning

This library follows [Semantic Versioning](http://semver.org/)

Please note it is currently under active development. Any release versioned 0.x.y is subject to backwards incompatible changes at any time.

## Contributing

Contributions to this library are always welcome and highly encouraged.

See [CONTRIBUTING](CONTRIBUTING.md) for more information on how to get started.

## License

Apache 2.0 - See [LICENSE](LICENSE) for more information.
