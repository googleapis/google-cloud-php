# Google Cloud Pub/Sub V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\PubSub\V1\PublisherClient;

$publisherClient = new PublisherClient();
try {
    $formattedName = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
    $response = $publisherClient->createTopic($formattedName);
} finally {
    $publisherClient->close();
}
```
