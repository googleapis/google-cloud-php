# Google Cloud Redis V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Redis\V1\CloudRedisClient;

$client = new CloudRedisClient();

$projectId = '[MY_PROJECT_ID]';
$location = '-'; // The '-' wildcard refers to all regions available to the project for the listInstances method
$formattedLocationName = $client->locationName($projectId, $location);
$response = $client->listInstances($formattedLocationName);
foreach ($response->iterateAllElements() as $instance) {
    printf('Instance: %s : %s' . PHP_EOL,
        $device->getDisplayName(),
        $device->getName()
    );
}
```
