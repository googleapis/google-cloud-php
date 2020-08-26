# Google Cloud OsConfig V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\OsConfig\V1\OsConfigServiceClient;

$client = new OsConfigServiceClient();

$jobs = $client->listPatchJobs(
	OsConfigServiceClient::projectName('[MY_PROJECT_ID]')
);

foreach ($jobs as $job) {
	print $job->getName() . ': ' . $job->getDescription() . PHP_EOL;
}
```
