# Cloud Scheduler V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Scheduler\V1\AppEngineHttpTarget;
use Google\Cloud\Scheduler\V1\CloudSchedulerClient;
use Google\Cloud\Scheduler\V1\Job;
use Google\Cloud\Scheduler\V1\Job\State;

$client = new CloudSchedulerClient();
$projectId = '[MY_PROJECT_ID]';
$location = 'us-central1';
$parent = CloudSchedulerClient::locationName($projectId, $location);
$job = new Job([
    'name' => CloudSchedulerClient::jobName(
        $projectId,
        $location,
        uniqid()
    ),
    'app_engine_http_target' => new AppEngineHttpTarget([
        'relative_uri' => '/'
    ]),
    'schedule' => '* * * * *'
]);
$client->createJob($parent, $job);

foreach ($client->listJobs($parent) as $job) {
    printf(
        'Job: %s : %s' . PHP_EOL,
        $job->getName(),
        State::name($job->getState())
    );
}
```
