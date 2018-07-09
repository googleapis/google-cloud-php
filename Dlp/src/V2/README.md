# Data Loss Prevention V2 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Dlp\V2\DlpServiceClient;
use Google\Cloud\Dlp\V2\ContentItem;
use Google\Cloud\Dlp\V2\InfoType;
use Google\Cloud\Dlp\V2\InspectConfig;

$dlpServiceClient = new DlpServiceClient();
$infoTypesElement = (new InfoType())
    ->setName('EMAIL_ADDRESS');
$inspectConfig = (new InspectConfig())
    ->setInfoTypes([$infoTypesElement]);
$item = (new ContentItem())
    ->setValue('My email is example@example.com.');
$formattedParent = $dlpServiceClient
    ->projectName('[PROJECT_ID]');

$response = $dlpServiceClient->inspectContent($formattedParent, [
    'inspectConfig' => $inspectConfig,
    'item' => $item
]);

$findings = $response->getResult()
    ->getFindings();

foreach ($findings as $finding) {
    print $finding->getInfoType()
        ->getName() . PHP_EOL;
}
```
