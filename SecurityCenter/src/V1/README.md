# Google Cloud Security Command Center V1 generated client for PHP

### Sample

```php
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1\Source;

$security = new SecurityCenterClient();
$parent = SecurityCenterClient::organizationName('[YOUR ORGANIZATION]');
$source = new Source([
    'name' => SecurityCenterClient::sourceName('[YOUR ORGANIZATION]', '[YOUR SOURCE]'),
    'displayName' => '[YOUR SOURCE]'
]);

$res = $security->createSource($parent, $source);
```
