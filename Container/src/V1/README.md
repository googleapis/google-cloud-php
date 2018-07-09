# Google Cloud Container V1 generated client for PHP

### Sample

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
