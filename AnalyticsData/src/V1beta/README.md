# Google Analytics Data V1beta generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;

$client = new BetaAnalyticsDataClient();

$response = $client->runReport([
    'property' => '[YOUR_PROPERTY_ID]'
]);

foreach ($response->getRows() as $row) {
    foreach ($row->getDimensionValues() as $dimensionValue) {
        print 'Dimension Value: ' . $dimensionValue->getValue() . PHP_EOL;
    }
}
```
