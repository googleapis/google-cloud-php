# Google Cloud Channel V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Channel\V1\CloudChannelServiceClient;

$client = new CloudChannelServiceClient();

$customers = $client->listCustomers('accounts/[MY_ACCOUNT_ID]');

foreach ($customers as $customer) {
    print 'Customer: ' . $customer->getName() . PHP_EOL;
}
```
