# Google Cloud Tasks for PHP

> Idiomatic PHP client for Google Cloud Tasks.

[![Latest Stable Version](https://poser.pugx.org/google/cloud-tasks/v/stable)](https://packagist.org/packages/google/cloud-tasks) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-tasks.svg)](https://packagist.org/packages/google/cloud-tasks)

* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-tasks/latest/tasks/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
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

Please see our [Authentication guide](https://github.com/GoogleCloudPlatform/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

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

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.
