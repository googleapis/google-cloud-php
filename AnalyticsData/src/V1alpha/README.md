# Google Analytics Data V1alpha generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Analytics\Data\V1alpha\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\Entity;

$client = new AlphaAnalyticsDataClient();

$response = $client->runReport([
    'entity' => new Entity([
        'property_id' => '[YOUR_PROPERTY_ID]'
    ])
]);

foreach ($response->getRows() as $row) {
    foreach ($row->getDimensionValues() as $dimensionValue) {
        print 'Dimension Value: ' . $dimensionValue->getValue() . PHP_EOL;
    }
}
```
