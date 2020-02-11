# Google Cloud Security Command Center V1p1beta1 generated client for PHP

### Sample

```php
use Google\Cloud\SecurityCenter\V1p1beta1\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1p1beta1\Source;

$security = new SecurityCenterClient();
$parent = SecurityCenterClient::organizationName('[YOUR ORGANIZATION]');
$source = new Source([
    'name' => SecurityCenterClient::sourceName('[YOUR ORGANIZATION]', '[YOUR SOURCE]'),
    'displayName' => '[YOUR SOURCE]'
]);

$res = $security->createSource($parent, $source);
```
