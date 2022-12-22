# Google Cloud Tasks for PHP

> Idiomatic PHP client for Google Cloud Tasks.

[![Latest Stable Version](https://poser.pugx.org/google/cloud-tasks/v/stable)](https://packagist.org/packages/google/cloud-tasks) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-tasks.svg)](https://packagist.org/packages/google/cloud-tasks)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-tasks/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-tasks
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).


### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Tasks\V2\CloudTasksClient;
use Google\Cloud\Tasks\V2\Queue;

$client = new CloudTasksClient();

$project = 'example-project';
$location = 'us-central1';
$queue = uniqid('example-queue-');
$queueName = $client::queueName($project, $location, $queue);

// Create a queue
$locationName = $client::locationName($project, $location);
$queue = new Queue([
    'name' => $queueName
]);
$queue->setName($queueName);
$client->createQueue($locationName, $queue);

echo "$queueName created." . PHP_EOL;

// List queues
echo 'Listing the queues' . PHP_EOL;
$resp = $client->listQueues($locationName);
foreach ($resp->iterateAllElements() as $q) {
    echo $q->getName() . PHP_EOL;
}

// Delete the queue
$client->deleteQueue($queueName);
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Removal of pull queue

The past version (V2beta2) supported pull queues, but we removed the
pull queue support from V2/V2beta3. For more details, read
[our documentation](https://cloud.google.com/tasks/docs/alpha-to-beta#pull)
about the removal.
