# Cloud Scheduler V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Scheduler\V1\CloudSchedulerClient;

$schedulerClient = new CloudSchedulerClient();
$projectId = '[MY_PROJECT_ID]';
$formattedName = $schedulerClient->projectName($projectId);
$jobs = $schedulerClient->listJobs($formattedName);
```
