# Stackdriver Trace V2 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Trace\V2\TraceServiceClient;

$traceServiceClient = new TraceServiceClient();
try {
    $formattedName = $traceServiceClient->projectName('[PROJECT]');
    $spans = [];
    $traceServiceClient->batchWriteSpans($formattedName, $spans);
} finally {
    $traceServiceClient->close();
}
```
