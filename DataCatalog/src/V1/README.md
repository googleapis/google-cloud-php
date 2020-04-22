# Google Cloud Data Catalog V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\DataCatalog\V1\DataCatalogClient;

$client = new DataCatalogClient();
$location = DataCatalogClient::locationName('[MY_PROJECT_ID]', 'us-central1');

$entryGroup = $client->createEntryGroup($location, 'sample_entry_group');

printf('Created entry group: %s' . PHP_EOL, $entryGroup->getName());
```
