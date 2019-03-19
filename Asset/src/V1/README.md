# Google Cloud Asset V1 generated client for PHP

### Sample

```php
require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Asset\V1\AssetServiceClient;
use Google\Cloud\Asset\V1\GcsDestination;
use Google\Cloud\Asset\V1\OutputConfig;

$objectPath = 'gs://your-bucket/cai-export';
// Now you need to change this with your project number (numeric id)
$project = 'example-project';

$client = new AssetServiceClient();

$gcsDestination = new GcsDestination(['uri' => $objectPath]);
$outputConfig = new OutputConfig(['gcs_destination' => $gcsDestination]);

$resp = $client->exportAssets("projects/$project", $outputConfig);

$resp->pollUntilComplete();

if ($resp->operationSucceeded()) {
    echo "The result is dumped to $objectPath successfully." . PHP_EOL;
} else {
    $error = $resp->getError();
    // handleError($error)
}
```
