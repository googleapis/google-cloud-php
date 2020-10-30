# Google Cloud Talent Solution V4 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Talent\V4\Company;
use Google\Cloud\Talent\V4\CompanyServiceClient;

$client = new CompanyServiceClient();
$response = $client->createCompany(
    CompanyServiceClient::projectName('MY_PROJECT_ID'),
    new Company([
        'display_name' => 'Google, LLC',
        'external_id' => 1,
        'headquarters_address' => '1600 Amphitheatre Parkway, Mountain View, CA'
    ])
);
```
