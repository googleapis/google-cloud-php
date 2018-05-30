# Google Cloud Dataproc V1 generated client for PHP

### Sample

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
