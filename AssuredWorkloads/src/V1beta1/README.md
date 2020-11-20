# Google Cloud Assured Workloads V1beta1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\AssuredWorkloads\V1beta1\AssuredWorkloadsServiceClient;

$client = new AssuredWorkloadsServiceClient();

$workloads = $client->listWorkloads(
    AssuredWorkloadsServiceClient::locationNAme('[MY_ORGANIZATION'], 'us-west1')
);

foreach ($workloads as $workload) {
    print 'Workload: ' . $workload->getName() . PHP_EOL;
}
```
