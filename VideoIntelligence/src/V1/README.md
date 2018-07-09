# Google Cloud Video Intelligence V1 generated client for PHP

### Sample

```php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\VideoIntelligence\V1\VideoIntelligenceServiceClient;
use Google\Cloud\VideoIntelligence\V1\Feature;

$videoIntelligenceServiceClient = new VideoIntelligenceServiceClient();

$inputUri = "gs://example-bucket/example-video.mp4";
$features = [
    Feature::LABEL_DETECTION,
];
$operationResponse = $videoIntelligenceServiceClient->annotateVideo($inputUri, $features);
$operationResponse->pollUntilComplete();
if ($operationResponse->operationSucceeded()) {
    $results = $operationResponse->getResult();
    foreach ($results->getAnnotationResultsList() as $result) {
        foreach ($result->getLabelAnnotationsList() as $labelAnnotation) {
            echo "Label: " . $labelAnnotation->getDescription() . "\n";
        }
    }
} else {
    $error = $operationResponse->getError();
    echo "error: " . $error->getMessage() . "\n";
}
```
