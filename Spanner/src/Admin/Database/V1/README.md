# Google Cloud Spanner Database Admin V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesRequest;

$databaseAdminClient = new DatabaseAdminClient();
try {
    $formattedParent = $databaseAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
    $request = (new ListDatabasesRequest())
        ->setParent($formattedParent);

    // Iterate through all elements
    $pagedResponse = $databaseAdminClient->listDatabases($request);
    foreach ($pagedResponse->iterateAllElements() as $element) {
        // doSomethingWith($element);
    }

    // OR iterate over pages of elements
    $pagedResponse = $databaseAdminClient->listDatabases($request);
    foreach ($pagedResponse->iteratePages() as $page) {
        foreach ($page as $element) {
            // doSomethingWith($element);
        }
    }
} finally {
    $databaseAdminClient->close();
}
```
