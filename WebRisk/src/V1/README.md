# Google Cloud Web Risk V1 generated client for PHP

### Sample

```php
use Google\Cloud\WebRisk\V1\ThreatType;
use Google\Cloud\WebRisk\V1\WebRiskServiceClient;

$webrisk = new WebRiskServiceClient();

$uri = 'http://testsafebrowsing.appspot.com/s/malware.html';
$response = $webrisk->searchUris($uri, [
    ThreatType::MALWARE,
    ThreatType::SOCIAL_ENGINEERING
]);

$threats = $response->getThreat();
if ($threats) {
    echo $uri . ' has the following threats:' . PHP_EOL;
    foreach ($threats->getThreatTypes() as $threat) {
        echo ThreatType::name($threat) . PHP_EOL;
    }
}
```
