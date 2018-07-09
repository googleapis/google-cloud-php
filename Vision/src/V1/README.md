# Google Cloud Vision V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

$imageAnnotatorClient = new ImageAnnotatorClient();
try {
    $requests = [];
    $response = $imageAnnotatorClient->batchAnnotateImages($requests);
} finally {
    $imageAnnotatorClient->close();
}
```
