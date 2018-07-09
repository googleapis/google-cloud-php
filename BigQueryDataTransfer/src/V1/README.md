# BigQuery Data Transfer V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\BigQuery\DataTransfer\V1\DataTransferServiceClient;

$dataTransferServiceClient = new DataTransferServiceClient();
$projectId = '[MY_PROJECT_ID]';
$location = 'us-central1';
$formattedLocation = $dataTransferServiceClient->locationName($projectId, $location);
$dataSources = $dataTransferServiceClient->listDataSources($formattedLocation);
```
