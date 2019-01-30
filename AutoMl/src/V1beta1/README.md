# Cloud AutoML V1beta1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\AutoMl\V1beta1\AutoMlClient;

$autoMlClient = new AutoMlClient();
$formattedParent = $autoMlClient->locationName('[PROJECT]', '[LOCATION]');
$dataset = new Dataset();
$response = $autoMlClient->createDataset($formattedParent, $dataset);
```
