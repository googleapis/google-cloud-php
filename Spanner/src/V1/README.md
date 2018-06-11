# Google Cloud Spanner V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Spanner\V1\SpannerClient;

$spannerClient = new SpannerClient();
try {
    $formattedDatabase = $spannerClient->databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
    $response = $spannerClient->createSession($formattedDatabase);
} finally {
    $spannerClient->close();
}
```
