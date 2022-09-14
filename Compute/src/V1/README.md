
# Google Cloud Compute V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Compute\V1\InstancesClient;

$instances = new InstancesClient();
foreach ($instances->list_('[MY_PROJECT_ID]', 'us-west1') as $instance) {
    print($instance->getName() . PHP_EOL);
}
```
