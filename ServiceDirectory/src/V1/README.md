# Google Cloud Service Directory V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\ServiceDirectory\V1\RegistrationServiceClient;
use Google\Cloud\ServiceDirectory\V1\Service;

$client = new RegistrationServiceClient();

$projectId = '[YOUR_PROJECT_ID]';
$location = 'us-central1';
$serviceId = '[YOUR_SERVICE_ID]';
$namespace = '[YOUR_NAMESPACE]';

$service = $client->createService(
    RegistrationServiceClient::namespaceName(
        $projectId,
        $location,
        $namespace
    ),
    $serviceId,
    new Service()
);

printf(
    'Created service: %s' . PHP_EOL,
    $service->getName()
);
```
