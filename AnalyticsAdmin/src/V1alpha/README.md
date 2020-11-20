# Google Analytics Admin V1alpha generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;

$client = new AnalyticsAdminServiceClient();

$accounts = $client->listAccounts();

foreach ($accounts as $account) {
    print 'Found account: ' . $account->getName() . PHP_EOL;
}
```
