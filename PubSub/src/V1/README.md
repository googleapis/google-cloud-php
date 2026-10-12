# Google Cloud Pub/Sub V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\Topic;

$publisherClient = new PublisherClient();
try {
    $formattedName = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
    $topic = new Topic();
    $topic->setName($formattedName);
    $response = $publisherClient->createTopic($topic);
} finally {
    $publisherClient->close();
}
```
