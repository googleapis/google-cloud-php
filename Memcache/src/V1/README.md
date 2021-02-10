# Memorystore for Memcached V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Memcache\V1\CloudMemcacheClient;

$client = new CloudMemcacheClient();
$location = CloudMemcacheClient::locationName('[MY_PROJECT_ID]', '-');

foreach ($client->listInstances($location) as $response) {
    foreach ($response->getResources() as $instance) {
        printf('Discovered instance: %s', $instance->getDisplayName());
    }
}
```
