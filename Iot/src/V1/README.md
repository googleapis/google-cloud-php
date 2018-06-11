# Google Cloud IoT Core V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Iot\V1\DeviceManagerClient;

$deviceManager = new DeviceManagerClient();

$projectId = '[MY_PROJECT_ID]';
$location = 'us-central1';
$registryId = '[MY_REGISTRY_ID]';
$registryName = $deviceManager->registryName($projectId, $location, $registryId);
$devices = $deviceManager->listDevices($registryName);
foreach ($devices->iterateAllElements() as $device) {
    printf('Device: %s : %s' . PHP_EOL,
        $device->getNumId(),
        $device->getId()
    );
}
```
