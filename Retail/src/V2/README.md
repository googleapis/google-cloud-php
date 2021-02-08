# Google Cloud Retail V2 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Retail\V2\CatalogServiceClient;

$client = new CatalogServiceClient();

$catalogs = $client->listCatalogs(
    CatalogServiceClient::locationName('[MY_PROJECT_ID]', 'global')
);

foreach ($catalogs as $catalog) {
    print 'Catalog: ' . $catalog->getName() . PHP_EOL;
}
```
