# Cloud AutoML V1beta1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\AutoMl\V1beta1\AutoMlClient;
use Google\Cloud\AutoMl\V1beta1\TranslationDatasetMetadata;

$autoMlClient = new AutoMlClient();
$formattedParent = $autoMlClient->locationName('[PROJECT]', '[LOCATION]');
$dataset = new Dataset([
    'display_name' => '[DISPLAY_NAME]',
    'translation_dataset_metadata' => new TranslationDatasetMetadata([
        'source_language_code' => 'en',
        'target_language_code' => 'es'
    ])
]);
$response = $autoMlClient->createDataset($formattedParent, $dataset);
```
