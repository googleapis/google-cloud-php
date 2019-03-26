# Google Cloud Tasks V2Beta2 generated client for PHP

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
