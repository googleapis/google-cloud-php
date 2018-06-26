# Google Cloud Tasks V2Beta2 generated client for PHP

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
