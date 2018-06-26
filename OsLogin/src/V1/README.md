# Google Cloud OsLogin V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\OsLogin\V1\OsLoginServiceClient;

$osLoginServiceClient = new OsLoginServiceClient();
$userId = '[MY_USER_ID]';
$formattedName = $osLoginServiceClient->userName($userId);
$loginProfile = $osLoginServiceClient->getLoginProfile($formattedName);
```
