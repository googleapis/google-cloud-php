# Google Cloud Billing V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Billing\V1\CloudBillingClient;

$client = new CloudBillingClient();
$accounts = $client->listBillingAccounts();

foreach ($accounts as $account) {
    print('Billing account: ' . $account->getName() . PHP_EOL);
}
```
