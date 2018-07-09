# Google Cloud Bigtable Admin V2 for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Table;

$bigtableTableAdminClient = new BigtableTableAdminClient();
try {
    $formattedParent = $bigtableTableAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
    $tableId = '[TABLE_ID]';
    $table = new Table();
    $response = $bigtableTableAdminClient->createTable($formattedParent, $tableId, $table);
} finally {
    $bigtableTableAdminClient->close();
}
```
