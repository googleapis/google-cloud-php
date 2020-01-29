# Recommender V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Recommender\V1\RecommenderClient;

$client = new RecommenderClient();

$recommendations = $client->listRecommendations(
    RecommenderClient::recommenderName(
        '[MY_PROJECT_ID]',
        'us-central1',
        'google.compute.instance.MachineTypeRecommender'
    )
);

foreach ($recommendations as $recommendation) {
    printf(
        'Found recommendation: %s' . PHP_EOL,
        $recommendation->getName()
    );
}
```
