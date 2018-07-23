# Google Cloud PHP Client
> Idiomatic PHP client for [Google Cloud Platform](https://cloud.google.com/) services.

[![Latest Stable Version](https://poser.pugx.org/google/cloud/v/stable)](https://packagist.org/packages/google/cloud) [![Packagist](https://img.shields.io/packagist/dm/google/cloud.svg)](https://packagist.org/packages/google/cloud) [![Travis Build Status](https://travis-ci.org/GoogleCloudPlatform/google-cloud-php.svg?branch=master)](https://travis-ci.org/GoogleCloudPlatform/google-cloud-php/) [![codecov](https://codecov.io/gh/googlecloudplatform/google-cloud-php/branch/master/graph/badge.svg)](https://codecov.io/gh/googlecloudplatform/google-cloud-php)

* [Homepage](http://googlecloudplatform.github.io/google-cloud-php)
* [API Documentation](https://googlecloudplatform.github.io/google-cloud-php/#/docs/google-cloud/latest/servicebuilder)

This client supports the following Google Cloud Platform services at a [General Availability](#versioning) quality level:
* [Cloud Spanner](#cloud-spanner-ga) (GA)
* [Google BigQuery](#google-bigquery-ga) (GA)
* [Google Cloud Datastore](#google-cloud-datastore-ga) (GA)
* [Google Cloud Pub/Sub](#google-cloud-pubsub-ga) (GA)
* [Google Cloud Storage](#google-cloud-storage-ga) (GA)
* [Google Cloud Translation](#google-cloud-translation-ga) (GA)
* [Google Cloud Video Intelligence](#google-cloud-video-intelligence-ga) (GA)
* [Google Stackdriver Logging](#google-stackdriver-logging-ga) (GA)

This client supports the following Google Cloud Platform services at a [Beta](#versioning) quality level:

* [Cloud Firestore](#cloud-firestore-beta) (Beta)
* [Google Cloud Container](#google-cloud-container-beta) (Beta)
* [Google Cloud Dataproc](#google-cloud-dataproc-beta) (Beta)
* [Google Cloud KMS](#google-cloud-kms-beta) (Beta)
* [Google Cloud Natural Language](#google-cloud-natural-language-beta) (Beta)
* [Google Cloud OsLogin](#google-cloud-oslogin-beta) (Beta)
* [Google Cloud Tasks](#google-cloud-tasks-beta) (Beta)
* [Google Cloud Text-to-Speech](#google-cloud-text-to-speech-beta) (Beta)
* [Google Cloud Vision](#google-cloud-vision-beta) (Beta)
* [Google DLP](#google-dlp-beta) (Beta)
* [Google Stackdriver Error Reporting](#google-stackdriver-error-reporting-beta) (Beta)
* [Google Stackdriver Monitoring](#google-stackdriver-monitoring-beta) (Beta)

This client supports the following Google Cloud Platform services at an [Alpha](#versioning) quality level:
* [Dialogflow API](#dialogflow-api-alpha) (Alpha)
* [Google Bigtable](#google-bigtable-alpha) (Alpha)
* [Google Cloud BigQuery Data Transfer](#google-cloud-bigquery-data-transfer-alpha) (Alpha)
* [Google Cloud IoT](#google-cloud-iot-alpha) (Alpha)
* [Google Cloud Redis](#google-cloud-redis-alpha) (Alpha)
* [Google Cloud Speech](#google-cloud-speech-alpha) (Alpha)
* [Google Stackdriver Debugger](#google-stackdriver-debugger-alpha) (Alpha)
* [Google Stackdriver Trace](#google-stackdriver-trace-alpha) (Alpha)

If you need support for other Google APIs, please check out the [Google APIs Client Library for PHP](https://github.com/google/google-api-php-client).

## Quick Start

We recommend installing individual component packages when possible. A list of available packages can be found on [Packagist](https://packagist.org/search/?q=google%2Fcloud-).

For example:

```sh
$ composer require google/cloud-bigquery
$ composer require google/cloud-datastore
```

We also provide the `google/cloud` package, which includes all Google Cloud clients.

```sh
$ composer require google/cloud
```

### Authentication

Authentication is handled by the client library automatically. You just need to provide the authentication details when creating a client. Generally, authentication is accomplished using a Service Account. For more information on obtaining Service Account credentials, see our [Authentication Guide](https://googlecloudplatform.github.io/google-cloud-php/#/docs/google-cloud/latest/guides/authentication).

Once you've obtained your credentials file, it may be used to create an authenticated client.

```php
require 'vendor/autoload.php';

use Google\Cloud\Core\ServiceBuilder;

// Authenticate using a keyfile path
$cloud = new ServiceBuilder([
    'keyFilePath' => 'path/to/keyfile.json'
]);

// Authenticate using keyfile data
$cloud = new ServiceBuilder([
    'keyFile' => json_decode(file_get_contents('/path/to/keyfile.json'), true)
]);
```

If you do not wish to embed your authentication information in your application code, you may also make use of [Application Default Credentials](https://developers.google.com/identity/protocols/application-default-credentials).

```php
require 'vendor/autoload.php';

use Google\Cloud\Core\ServiceBuilder;

putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/keyfile.json');

$cloud = new ServiceBuilder();
```

The `GOOGLE_APPLICATION_CREDENTIALS` environment variable may be set in your server configuration.

### gRPC and Protobuf

Many clients in Google Cloud PHP offer support for gRPC, either as an option or a requirement. gRPC is a high-performance RPC framework created by Google. To use gRPC in PHP, you must install the gRPC PHP extension on your server. While not required, it is also recommended that you install the protobuf extension whenever using gRPC in production.

```
$ pecl install grpc
$ pecl install protobuf
```

* [gRPC Installation Instructions](https://cloud.google.com/php/grpc)
* [Protobuf Installation Instructions](https://cloud.google.com/php/grpc#install_the_protobuf_runtime_library)

## Cloud Spanner (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/spanner/spannerclient)
- [Official Documentation](https://cloud.google.com/spanner/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Spanner\SpannerClient;

$spanner = new SpannerClient();

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

[Cloud Spanner](https://github.com/GoogleCloudPlatform/google-cloud-php-spanner) can be installed separately by requiring the [`google/cloud-spanner`](https://packagist.org/packages/google/cloud-spanner) composer package:

```
$ composer require google/cloud-spanner
```

## Google BigQuery (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/bigquery/bigqueryclient)
- [Official Documentation](https://cloud.google.com/bigquery/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\BigQuery\BigQueryClient;

$bigQuery = new BigQueryClient();

// Get an instance of a previously created table.
$dataset = $bigQuery->dataset('my_dataset');
$table = $dataset->table('my_table');

// Begin a job to import data from a CSV file into the table.
$loadJobConfig = $table->load(
    fopen('/data/my_data.csv', 'r')
);
$job = $table->runJob($loadJobConfig);

// Run a query and inspect the results.
$queryJobConfig = 'SELECT * FROM [my_project:my_dataset.my_table]';
$queryResults = $bigQuery->runQuery($queryConfig);

foreach ($queryResults as $row) {
    print_r($row);
}
```

#### google/cloud-bigquery

[Google BigQuery](https://github.com/GoogleCloudPlatform/google-cloud-php-bigquery) can be installed separately by requiring the [`google/cloud-bigquery`](https://packagist.org/packages/google/cloud-bigquery) composer package:

```
$ composer require google/cloud-bigquery
```

## Google Cloud Datastore (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/datastore/datastoreclient)
- [Official Documentation](https://cloud.google.com/datastore/docs/)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$datastore = new DatastoreClient();

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

[Google Cloud Datastore](https://github.com/GoogleCloudPlatform/google-cloud-php-datastore) can be installed separately by requiring the [`google/cloud-datastore`](https://packagist.org/packages/google/cloud-datastore) composer package:

```
$ composer require google/cloud-datastore
```

## Google Cloud Pub/Sub (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/pubsub/pubsubclient)
- [Official Documentation](https://cloud.google.com/pubsub/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\PubSub\PubSubClient;

$pubSub = new PubSubClient();

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

[Google Cloud Pub/Sub](https://github.com/GoogleCloudPlatform/google-cloud-php-pubsub) can be installed separately by requiring the [`google/cloud-pubsub`](https://packagist.org/packages/google/cloud-pubsub) composer package:

```
$ composer require google/cloud-pubsub
```

## Google Cloud Storage (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/storage/storageclient)
- [Official Documentation](https://cloud.google.com/storage/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

$storage = new StorageClient();

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

$storage = new StorageClient();
$storage->registerStreamWrapper();

$contents = file_get_contents('gs://my_bucket/file_backup.txt');
```

#### google/cloud-storage

[Google Cloud Storage](https://github.com/GoogleCloudPlatform/google-cloud-php-storage) can be installed separately by requiring the [`google/cloud-storage`](https://packagist.org/packages/google/cloud-storage) composer package:

```
$ composer require google/cloud-storage
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

[Google Cloud Translation](https://github.com/GoogleCloudPlatform/google-cloud-php-translate) can be installed separately by requiring the [`google/cloud-translate`](https://packagist.org/packages/google/cloud-translate) composer package:

```
$ composer require google/cloud-translate
```

## Google Cloud Video Intelligence (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/videointelligence/readme)
- [Official Documentation](https://cloud.google.com/video-intelligence/docs)

#### Preview

```php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\VideoIntelligence\V1\VideoIntelligenceServiceClient;
use Google\Cloud\VideoIntelligence\V1\Feature;

$videoIntelligenceServiceClient = new VideoIntelligenceServiceClient();

$inputUri = "gs://example-bucket/example-video.mp4";

$features = [
    Feature::LABEL_DETECTION,
];
$operationResponse = $videoIntelligenceServiceClient->annotateVideo([
    'inputUri' => $inputUri,
    'features' => $features
]);
$operationResponse->pollUntilComplete();
if ($operationResponse->operationSucceeded()) {
    $results = $operationResponse->getResult();
    foreach ($results->getAnnotationResults() as $result) {
        echo 'Segment labels' . PHP_EOL;
        foreach ($result->getSegmentLabelAnnotations() as $labelAnnotation) {
            echo "Label: " . $labelAnnotation->getEntity()->getDescription()
                . PHP_EOL;
        }
        echo 'Shot labels' . PHP_EOL;
        foreach ($result->getShotLabelAnnotations() as $labelAnnotation) {
            echo "Label: " . $labelAnnotation->getEntity()->getDescription()
                . PHP_EOL;
        }
        echo 'Frame labels' . PHP_EOL;
        foreach ($result->getFrameLabelAnnotations() as $labelAnnotation) {
            echo "Label: " . $labelAnnotation->getEntity()->getDescription()
                . PHP_EOL;
        }
    }
} else {
    $error = $operationResponse->getError();
    echo "error: " . $error->getMessage() . PHP_EOL;

}
```

#### google/cloud-videointelligence

[Cloud Video Intelligence](https://github.com/GoogleCloudPlatform/google-cloud-php-videointelligence) can be installed separately by requiring the [`google/cloud-videointelligence`](https://packagist.org/packages/google/cloud-videointelligence) composer package:

```
$ composer require google/cloud-videointelligence
```

## Google Stackdriver Logging (GA)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/logging/loggingclient)
- [Official Documentation](https://cloud.google.com/logging/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Logging\LoggingClient;

$logging = new LoggingClient();

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

[Google Stackdriver Logging](https://github.com/GoogleCloudPlatform/google-cloud-php-logging) can be installed separately by requiring the [`google/cloud-logging`](https://packagist.org/packages/google/cloud-logging) composer package:

```
$ composer require google/cloud-logging
```

## Cloud Firestore (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/firestore/firestoreclient)
- [Official Documentation](https://cloud.google.com/firestore/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;

$firestore = new FirestoreClient();

$collectionReference = $firestore->collection('Users');
$documentReference = $collectionReference->document($userId);
$snapshot = $documentReference->snapshot();

echo "Hello " . $snapshot['firstName'];
```

#### google/cloud-firestore

[Cloud Firestore](https://github.com/GoogleCloudPlatform/google-cloud-php-firestore) can be installed separately by requiring the [`google/cloud-firestore`](https://packagist.org/packages/google/cloud-firestore) composer package:

```
$ composer require google/cloud-firestore
```

## Google Cloud Container (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/container/readme)
- [Official Documentation](https://cloud.google.com/kubernetes-engine/docs)

```php
require 'vendor/autoload.php';

use Google\Cloud\Container\V1\ClusterManagerClient;

$clusterManagerClient = new ClusterManagerClient();

$projectId = '[MY-PROJECT-ID]';
$zone = 'us-central1-a';

try {
    $clusters = $clusterManagerClient->listClusters($projectId, $zone);
    foreach ($clusters->getClusters() as $cluster) {
        print('Cluster: ' . $cluster->getName() . PHP_EOL);
    }
} finally {
    $clusterManagerClient->close();
}
```

#### google/cloud-container

[Google Cloud Container](https://github.com/GoogleCloudPlatform/google-cloud-php-container) can be installed separately by requiring the [`google/cloud-container`](https://packagist.org/packages/google/cloud-container) composer package:

```
$ composer require google/cloud-container
```

## Google Cloud Dataproc (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/dataproc/readme)
- [Official Documentation](https://cloud.google.com/dataproc/docs)

```php
require 'vendor/autoload.php';

use Google\Cloud\Dataproc\V1\JobControllerClient;
use Google\Cloud\Dataproc\V1\Job;
use Google\Cloud\Dataproc\V1\HadoopJob;
use Google\Cloud\Dataproc\V1\JobPlacement;

$projectId = '[MY_PROJECT_ID]';
$region = 'global';
$clusterName = '[MY_CLUSTER]';

$jobPlacement = new JobPlacement();
$jobPlacement->setClusterName($clusterName);

$hadoopJob = new HadoopJob();
$hadoopJob->setMainJarFileUri('gs://my-bucket/my-hadoop-job.jar');

$job = new Job();
$job->setPlacement($jobPlacement);
$job->setHadoopJob($hadoopJob);

$jobControllerClient = new JobControllerClient();
$submittedJob = $jobControllerClient->submitJob($projectId, $region, $job);
```

#### google/cloud-dataproc

[Google Cloud Dataproc](https://github.com/GoogleCloudPlatform/google-cloud-php-dataproc) can be installed separately by requiring the [`google/cloud-dataproc`](https://packagist.org/packages/google/cloud-dataproc) composer package:

```
$ composer require google/cloud-dataproc
```

## Google Cloud KMS (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/kms/readme)
- [Official Documentation](https://cloud.google.com/kms/docs/reference/rest/)

```php
require __DIR__ . '/vendor/autoload.php';

use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\CryptoKey;
use Google\Cloud\Kms\V1\CryptoKey\CryptoKeyPurpose;
use Google\Cloud\Kms\V1\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\KeyRing;

$client = new KeyManagementServiceClient();

$projectId = 'example-project';
$location = 'global';

// Create a keyring
$keyRingId = 'example-keyring';
$locationName = $client::locationName($projectId, $location);
$keyRingName = $client::keyRingName($projectId, $location, $keyRingId);

try {
    $keyRing = $client->getKeyRing($keyRingName);
} catch (ApiException $e) {
    if ($e->getStatus() === 'NOT_FOUND') {
        $keyRing = new KeyRing();
        $keyRing->setName($keyRingName);
        $client->createKeyRing($locationName, $keyRingId, $keyRing);
    }
}

// Create a cryptokey
$keyId = 'example-key';
$keyName = $client::cryptoKeyName($projectId, $location, $keyRingId, $keyId);

try {
    $cryptoKey = $client->getCryptoKey($keyName);
} catch (ApiException $e) {
    if ($e->getStatus() === 'NOT_FOUND') {
        $cryptoKey = new CryptoKey();
        $cryptoKey->setPurpose(CryptoKeyPurpose::ENCRYPT_DECRYPT);
        $cryptoKey = $client->createCryptoKey($keyRingName, $keyId, $cryptoKey);
    }
}

// Encrypt and decrypt
$secret = 'My secret text';
$response = $client->encrypt($keyName, $secret);
$cipherText = $response->getCiphertext();

$response = $client->decrypt($keyName, $cipherText);

$plainText = $response->getPlaintext();

assert($secret === $plainText);
```

#### google/cloud-kms

[Google Cloud KMS](https://github.com/GoogleCloudPlatform/google-cloud-php-kms) can be installed separately by requiring the [`google/cloud-kms`](https://packagist.org/packages/google/cloud-kms) composer package:

```
$ composer require google/cloud-kms
```

## Google Cloud Natural Language (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/language/languageclient)
- [Official Documentation](https://cloud.google.com/natural-language/docs)

#### Preview

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

#### google/cloud-language

[Google Cloud Natural Language](https://github.com/GoogleCloudPlatform/google-cloud-php-language) can be installed separately by requiring the [`google/cloud-language`](https://packagist.org/packages/google/cloud-language) composer package:

```
$ composer require google/cloud-language
```

## Google Cloud OsLogin (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/oslogin/readme)
- [Official Documentation](https://cloud.google.com/compute/docs/oslogin/rest/)

```php
require 'vendor/autoload.php';

use Google\Cloud\OsLogin\V1\OsLoginServiceClient;

$osLoginServiceClient = new OsLoginServiceClient();
$userId = '[MY_USER_ID]';
$formattedName = $osLoginServiceClient->userName($userId);
$loginProfile = $osLoginServiceClient->getLoginProfile($formattedName);
```

#### google/cloud-oslogin

[Google Cloud OsLogin](https://github.com/GoogleCloudPlatform/google-cloud-php-oslogin) can be installed separately by requiring the [`google/cloud-oslogin`](https://packagist.org/packages/google/cloud-oslogin) composer package:

```
$ composer require google/cloud-oslogin
```

## Google Cloud Tasks (Beta)
- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/tasks/readme)

#### Preview

```php
require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Tasks\V2beta2\CloudTasksClient;
use Google\Cloud\Tasks\V2beta2\LeaseDuration;
use Google\Cloud\Tasks\V2beta2\PullMessage;
use Google\Cloud\Tasks\V2beta2\PullTarget;
use Google\Cloud\Tasks\V2beta2\Queue;
use Google\Cloud\Tasks\V2beta2\Task;
use Google\Cloud\Tasks\V2beta2\Task_View;
use Google\Protobuf\Duration;

$client = new CloudTasksClient();

$project = 'example-project';
$location = 'us-central1';
$queue = uniqid('example-queue-');
$queueName = $client::queueName($project, $location, $queue);

// Create a pull queue
$locationName = $client::locationName($project, $location);
$queue = new Queue();
$queue->setName($queueName);
$queue->setPullTarget(new PullTarget());
$client->createQueue($locationName, $queue);

echo "$queueName created." . PHP_EOL;

// After the creation, wait at least a minute
echo 'Waiting for the queue to settle...' . PHP_EOL;
sleep(60);

// Create a task
$pullMessage = new PullMessage();
$payload = 'a message for the consumer: ' . uniqid();
$pullMessage->setPayload($payload);
$task = new Task();
$task->setPullMessage($pullMessage);
$client->createTask($queueName, $task);

// Lease a task
$leaseDuration = new Duration();
$leaseDuration->setSeconds(600);
$resp = $client->leaseTasks(
    $queueName,
    $leaseDuration,
    [
        'maxTasks' => 1,
        'responseView' => Task_View::FULL
    ]
);
$task = $resp->getTasks()[0];
assert($task->getPullMessage()->getPayload() === $payload);

// Acknowledge the task
$client->acknowledgeTask($task->getName(), $task->getScheduleTime());

// Delete the queue
$client->deleteQueue($queueName);
```

#### google/cloud-tasks

[Google Cloud Tasks](https://github.com/GoogleCloudPlatform/google-cloud-php-tasks) can be installed separately by requiring the [`google/cloud-tasks`](https://packagist.org/packages/google/cloud-tasks) composer package:

```
$ composer require google/cloud-tasks
```

## Google Cloud Text-to-Speech (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/text-to-speech/readme)
- [Official Documentation](https://cloud.google.com/text-to-speech/docs/reference/rpc/)

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

#### google/cloud-text-to-speech

[Google Cloud Text-to-Speech](https://github.com/GoogleCloudPlatform/google-cloud-php-text-to-speech) can be installed separately by requiring the [`google/cloud-text-to-speech`](https://packagist.org/packages/google/cloud-text-to-speech) composer package:

```
$ composer require google/cloud-text-to-speech
```

## Google Cloud Vision (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/vision/visionclient)
- [Official Documentation](https://cloud.google.com/vision/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Vision\VisionClient;

$vision = new VisionClient();

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

[Google Cloud Vision](https://github.com/GoogleCloudPlatform/google-cloud-php-vision) can be installed separately by requiring the [`google/cloud-vision`](https://packagist.org/packages/google/cloud-vision) composer package:

```
$ composer require google/cloud-vision
```

## Google DLP (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/dlp/readme)
- [Official Documentation](https://cloud.google.com/dlp/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Dlp\V2\DlpServiceClient;
use Google\Cloud\Dlp\V2\ContentItem;
use Google\Cloud\Dlp\V2\InfoType;
use Google\Cloud\Dlp\V2\InspectConfig;

$dlpServiceClient = new DlpServiceClient();
$infoTypesElement = (new InfoType())
    ->setName('EMAIL_ADDRESS');
$inspectConfig = (new InspectConfig())
    ->setInfoTypes([$infoTypesElement]);
$item = (new ContentItem())
    ->setValue('My email is example@example.com.');
$formattedParent = $dlpServiceClient
    ->projectName('[PROJECT_ID]');

$response = $dlpServiceClient->inspectContent($formattedParent, [
    'inspectConfig' => $inspectConfig,
    'item' => $item
]);

$findings = $response->getResult()
    ->getFindings();

foreach ($findings as $finding) {
    print $finding->getInfoType()
        ->getName() . PHP_EOL;
}
```

#### google/cloud-dlp

[Google DLP](https://github.com/GoogleCloudPlatform/google-cloud-php-dlp) can be installed separately by requiring the [`google/cloud-dlp`](https://packagist.org/packages/google/cloud-dlp) composer package:

```
$ composer require google/cloud-dlp
```

## Google Stackdriver Error Reporting (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/errorreporting/readme)
- [Official Documentation](https://cloud.google.com/error-reporting/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\ErrorReporting\V1beta1\ReportErrorsServiceClient;
use Google\Cloud\ErrorReporting\V1beta1\ReportedErrorEvent;

$reportErrorsServiceClient = new ReportErrorsServiceClient();
$formattedProjectName = $reportErrorsServiceClient->projectName('[PROJECT]');
$event = new ReportedErrorEvent();

try {
    $response = $reportErrorsServiceClient->reportErrorEvent($formattedProjectName, $event);
} finally {
    $reportErrorsServiceClient->close();
}
```

#### google/cloud-error-reporting

[Google Stackdriver Error Reporting](https://github.com/GoogleCloudPlatform/google-cloud-php-errorreporting) can be installed separately by requiring the [`google/cloud-errorreporting`](https://packagist.org/packages/google/cloud-error-reporting) composer package:

```
$ composer require google/cloud-error-reporting
```

## Google Stackdriver Monitoring (Beta)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/monitoring/readme)
- [Official Documentation](https://cloud.google.com/monitoring/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Api\Metric;
use Google\Api\MonitoredResource;
use Google\Cloud\Monitoring\V3\MetricServiceClient;
use Google\Cloud\Monitoring\V3\Point;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\TimeSeries;
use Google\Cloud\Monitoring\V3\TypedValue;
use Google\Protobuf\Timestamp;

$metricServiceClient = new MetricServiceClient();
$formattedProjectName = $metricServiceClient->projectName($projectId);
$labels = [
    'instance_id' => $instanceId,
    'zone' => $zone,
];

$m = new Metric();
$m->setType('custom.googleapis.com/my_metric');

$r = new MonitoredResource();
$r->setType('gce_instance');
$r->setLabels($labels);

$value = new TypedValue();
$value->setDoubleValue(3.14);

$timestamp = new Timestamp();
$timestamp->setSeconds(time());

$interval = new TimeInterval();
$interval->setStartTime($timestamp);
$interval->setEndTime($timestamp);

$point = new Point();
$point->setValue($value);
$point->setInterval($interval);
$points = [$point];

$timeSeries = new TimeSeries();
$timeSeries->setMetric($m);
$timeSeries->setResource($r);
$timeSeries->setPoints($points);

try {
    $metricServiceClient->createTimeSeries($formattedProjectName, [$timeSeries]);
    print('Successfully submitted a time series' . PHP_EOL);
} finally {
    $metricServiceClient->close();
}
```

#### google/cloud-monitoring

[Google Stackdriver Monitoring](https://github.com/GoogleCloudPlatform/google-cloud-php-monitoring) can be installed separately by requiring the [`google/cloud-monitoring`](https://packagist.org/packages/google/cloud-monitoring) composer package:

```
$ composer require google/cloud-monitoring
```

## Dialogflow API (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/dialogflow/readme)
- [Official Documentation](https://cloud.google.com/dialogflow-enterprise/docs/)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Dialogflow\V2\EntityTypesClient;

$entityTypesClient = new EntityTypesClient();
$projectId = '[MY_PROJECT_ID]';
$entityTypeId = '[ENTITY_TYPE_ID]';
$formattedEntityTypeName = $entityTypesClient->entityTypeName($projectId, $entityTypeId);

$entityType = $entityTypesClient->getEntityType($formattedEntityTypeName);
foreach ($entityType->getEntities() as $entity) {
    print(PHP_EOL);
    printf('Entity value: %s' . PHP_EOL, $entity->getValue());
    print('Synonyms: ');
    foreach ($entity->getSynonyms() as $synonym) {
        print($synonym . "\t");
    }
    print(PHP_EOL);
}
```

#### google/cloud-dialogflow

[Dialogflow](https://github.com/GoogleCloudPlatform/google-cloud-php-dialogflow) can be installed separately by requiring the [`google/cloud-dialogflow`](https://packagist.org/packages/google/cloud-dialogflow) composer package:

```
$ composer require google/cloud-dialogflow
```

## Google Bigtable (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/bigtable/readme)
- [Official Documentation](https://cloud.google.com/bigtable/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Bigtable\V2\BigtableClient;

$bigtableClient = new BigtableClient();
$formattedTableName = $bigtableClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');

try {
    $stream = $bigtableClient->readRows($formattedTableName);
    foreach ($stream->readAll() as $element) {
        // doSomethingWith($element);
    }
} finally {
    $bigtableClient->close();
}
```

#### google/cloud-bigtable

[Google Bigtable](https://github.com/GoogleCloudPlatform/google-cloud-php-bigtable) can be installed separately by requiring the [`google/cloud-bigtable`](https://packagist.org/packages/google/cloud-bigtable) composer package:

```
$ composer require google/cloud-bigtable
```

## Google Cloud BigQuery Data Transfer (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/bigquerydatatransfer/readme)
- [Official Documentation](https://cloud.google.com/bigquery/docs/transfer-service-overview)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\BigQuery\DataTransfer\V1\DataTransferServiceClient;

$dataTransferServiceClient = new DataTransferServiceClient();
$projectId = '[MY_PROJECT_ID]';
$location = 'us-central1';
$formattedLocation = $dataTransferServiceClient->locationName($projectId, $location);
$dataSources = $dataTransferServiceClient->listDataSources($formattedLocation);
```

#### google/cloud-bigquerydatatransfer

[Google Cloud BigQuery Data Transfer](https://github.com/GoogleCloudPlatform/google-cloud-php-bigquerydatatransfer) can be installed separately by requiring the [`google/cloud-bigquerydatatransfer`](https://packagist.org/packages/google/cloud-bigquerydatatransfer) composer package:

```
$ composer require google/cloud-bigquerydatatransfer
```

## Google Cloud IoT (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/iot/readme)
- [Official Documentation](https://cloud.google.com/iot/docs/)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Iot\V1\DeviceManagerClient;

$deviceManager = new DeviceManagerClient();

$projectId = '[MY_PROJECT_ID]';
$location = 'us-central1';
$registryId = '[MY_REGISTRY_ID]';
$registryName = $deviceManager->registryName($projectId, $location, $registryId);
$devices = $deviceManager->listDevices($registryName);
foreach ($devices->iterateAllElements() as $device) {
    printf('Device: %s : %s' . PHP_EOL,
        $device->getNumId(),
        $device->getId()
    );
}
```

#### google/cloud-iot

[Google Cloud IoT](https://github.com/GoogleCloudPlatform/google-cloud-php-iot) can be installed separately by requiring the [`google/cloud-iot`](https://packagist.org/packages/google/cloud-iot) composer package:

```
$ composer require google/cloud-iot
```

## Google Cloud Redis (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/redis/readme)
- [Official Documentation](https://cloud.google.com/memorystore/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Redis\V1beta1\CloudRedisClient;

$client = new CloudRedisClient();

$projectId = '[MY_PROJECT_ID]';
$location = '-'; // The '-' wildcard refers to all regions available to the project for the listInstances method
$formattedLocationName = $client->locationName($projectId, $location);
$response = $client->listInstances($formattedLocationName);
foreach ($response->iterateAllElements() as $instance) {
    printf('Instance: %s : %s' . PHP_EOL,
        $device->getDisplayName(),
        $device->getName()
    );
}

```

#### google/cloud-redis

[Google Cloud Redis](https://github.com/GoogleCloudPlatform/google-cloud-php-redis) can be installed separately by requiring the [`google/cloud-redis`](https://packagist.org/packages/google/cloud-redis) composer package:

```
$ composer require google/cloud-redis
```

## Google Cloud Speech (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/speech/speechclient)
- [Official Documentation](https://cloud.google.com/speech/docs)

#### Preview

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

#### google/cloud-speech

[Google Cloud Speech](https://github.com/GoogleCloudPlatform/google-cloud-php-speech) can be installed separately by requiring the [`google/cloud-speech`](https://packagist.org/packages/google/cloud-speech) composer package:

```
$ composer require google/cloud-speech
```

## Google Stackdriver Debugger (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/debugger/debuggerclient)
- [Official Documentation](https://cloud.google.com/debugger/docs)

#### Preview

```php
use Google\Cloud\Debugger\DebuggerClient;

$debugger = new DebuggerClient();
$debuggee = $debugger->debugee();
$debuggee->register();
```

#### google/cloud-debugger

[Stackdriver Debugger](https://github.com/GoogleCloudPlatform/google-cloud-php-debugger) can be installed separately by requiring the [`google/cloud-debugger`](https://packagist.org/packages/google/cloud-debugger) composer package:

```
$ composer require google/cloud-debugger
```

## Google Stackdriver Trace (Alpha)

- [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/trace/traceclient)
- [Official Documentation](https://cloud.google.com/trace/docs)

#### Preview

```php
require 'vendor/autoload.php';

use Google\Cloud\Trace\TraceClient;

$traceClient = new TraceClient();

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

[Stackdriver Trace](https://github.com/GoogleCloudPlatform/google-cloud-php-trace) can be installed separately by requiring the [`google/cloud-trace`](https://packagist.org/packages/google/cloud-trace) composer package:

```
$ composer require google/cloud-trace
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

This library provides a PSR-6 implementation with the SystemV shared memory at `Google\Auth\Cache\SysVCacheItemPool`. This implementation is only available on *nix machines, but it's the one of the fastest implementations and you can share the cache among multiple processes. The following example shows how to use it.

```php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Spanner\SpannerClient;
use Google\Auth\Cache\SysVCacheItemPool;

$cache = new SysVCacheItemPool();

$spanner = new SpannerClient([
    'authCache' => $cache
]);
```

## Versioning

This library follows [Semantic Versioning](http://semver.org/).

Please note it is currently under active development. Any release versioned
0.x.y is subject to backwards incompatible changes at any time.

**GA**: Libraries defined at a GA quality level are stable, and will not
introduce backwards-incompatible changes in any minor or patch releases. We will
address issues and requests with the highest priority. Please note, for any
components which include generated clients the GA guarantee will only apply to
clients which interact with stable services. For example, in a component which
hosts V1 and V1beta1 generated clients, the GA guarantee will only apply to the
V1 client as the service it interacts with is considered stable.

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
