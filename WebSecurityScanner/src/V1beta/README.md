# Google Cloud Web Security Scanner V1beta generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\WebSecurityScanner\V1beta\ScanConfig;
use Google\Cloud\WebSecurityScanner\V1beta\ScanConfig\UserAgent;
use Google\Cloud\WebSecurityScanner\V1beta\ScanRun\ExecutionState;
use Google\Cloud\WebSecurityScanner\V1beta\WebSecurityScannerClient;

$client = new WebSecurityScannerClient();
$scanConfig = $client->createScanConfig(
    WebSecurityScannerClient::projectName('[MY_PROJECT_ID'),
    new ScanConfig([
        'display_name' => 'Test Scan',
        'starting_urls' => ['https://[MY_APPLICATION_ID].appspot.com/'],
        'user_agent' => UserAgent::CHROME_LINUX
    ])
);
$scanRun = $client->startScanRun($scanConfig->getName());

echo 'Scan execution state: ' . ExecutionState::name($scanRun->getExecutionState()) . PHP_EOL;
```
