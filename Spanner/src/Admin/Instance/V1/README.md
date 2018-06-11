# Google Cloud Spanner Instance Admin V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;

$instanceAdminClient = new InstanceAdminClient();
try {
    $formattedParent = $instanceAdminClient->projectName('[PROJECT]');
    // Iterate through all elements
    $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent);
    foreach ($pagedResponse->iterateAllElements() as $element) {
        // doSomethingWith($element);
    }

    // OR iterate over pages of elements
    $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent);
    foreach ($pagedResponse->iteratePages() as $page) {
        foreach ($page as $element) {
            // doSomethingWith($element);
        }
    }
} finally {
    $instanceAdminClient->close();
}
```
