# Google Cloud Web Risk V1beta1 generated client for PHP

### Sample

```php
use Google\Cloud\WebRisk\V1beta1\ThreatType;
use Google\Cloud\WebRisk\V1beta1\WebRiskServiceV1Beta1Client;

$webrisk = new WebRiskServiceV1Beta1Client();

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
