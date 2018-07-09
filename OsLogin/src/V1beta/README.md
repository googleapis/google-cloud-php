# Google Cloud OsLogin V1beta generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\OsLogin\V1beta\OsLoginServiceClient;

$osLoginServiceClient = new OsLoginServiceClient();
$userId = '[MY_USER_ID]';
$formattedName = $osLoginServiceClient->userName($userId);
$loginProfile = $osLoginServiceClient->getLoginProfile($formattedName);
```
