# Google Cloud Video Intelligence V1beta2 generated client for PHP

### Sample
```php
require 'vendor/autoload.php';

use Google\Cloud\VideoIntelligence\V1beta2\VideoIntelligenceServiceClient;

$videoIntelligenceServiceClient = new VideoIntelligenceServiceClient();
try {
    $inputUri = 'gs://demomaker/cat.mp4';
    $featuresElement = Feature::LABEL_DETECTION;
    $features = [$featuresElement];
    $operationResponse = $videoIntelligenceServiceClient->annotateVideo(['inputUri' => $inputUri, 'features' => $features]);
    $operationResponse->pollUntilComplete();
    if ($operationResponse->operationSucceeded()) {
      	$result = $operationResponse->getResult();
      	// doSomethingWith($result)
    } else {
      	$error = $operationResponse->getError();
      	// handleError($error)
    }

    // OR start the operation, keep the operation name, and resume later
    $operationResponse = $videoIntelligenceServiceClient->annotateVideo(['inputUri' => $inputUri, 'features' => $features]);
    $operationName = $operationResponse->getName();
    // ... do other work
    $newOperationResponse = $videoIntelligenceServiceClient->resumeOperation($operationName, 'annotateVideo');
    while (!$newOperationResponse->isDone()) {
        // ... do other work
        $newOperationResponse->reload();
    }
    if ($newOperationResponse->operationSucceeded()) {
      	$result = $newOperationResponse->getResult();
      	// doSomethingWith($result)
    } else {
      	$error = $newOperationResponse->getError();
      	// handleError($error)
    }
} finally {
    $videoIntelligenceServiceClient->close();
}
```
