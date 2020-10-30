# Google Certificate Authority Service V1beta1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthorityServiceClient;

$client = new CertificateAuthorityServiceClient();

$parent = CertificateAuthorityServiceClient::locationName(
    '[MY_PROJECT]',
    'us-west1',
);
$authorities = $client->listCertificateAuthorities(
    $parent,
);

foreach ($authorities as $authority) {
    print 'Found authority: ' . $authority->getName() . PHP_EOL;
}
```
