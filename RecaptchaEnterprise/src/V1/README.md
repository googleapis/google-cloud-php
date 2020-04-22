# Google Cloud Recaptcha Enterprise V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\RecaptchaEnterprise\V1\Key;
use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\WebKeySettings;
use Google\Cloud\RecaptchaEnterprise\V1\WebKeySettings\IntegrationType;


$client = new RecaptchaEnterpriseServiceClient();
$project = RecaptchaEnterpriseServiceClient::projectName('[MY_PROJECT_ID]');
$webKeySettings = (new WebKeySettings())
    ->setAllowedDomains(['example.com'])
    ->setAllowAmpTraffic(false)
    ->setIntegrationType(IntegrationType::CHECKBOX);
$key = (new Key())
    ->setWebSettings($webKeySettings)
    ->setDisplayName('my sample key')
    ->setName('my_key');

$response = $client->createKey($project, $key);

printf('Created key: %s' . PHP_EOL, $response->getName());
```
