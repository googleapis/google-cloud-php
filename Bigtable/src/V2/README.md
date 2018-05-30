# Google Cloud Bigtable V2 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Bigtable\V2\BigtableClient;

$bigtableClient = new BigtableClient();
$formattedTableName = $bigtableClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');

try {
    $stream = $bigtableClient->readRows($formattedTableName);
    foreach ($stream->readAll() as $element) {
        // doSomethingWith($element);
    }
} finally {
    $bigtableClient->close();
}
```
