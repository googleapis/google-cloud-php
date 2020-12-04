# Google Cloud Workflows V1beta generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Workflows\V1beta\WorkflowsClient;

$client = new WorkflowsClient();

$workflows = $client->listWorkflows(
    WorkflowsClient::locationName('[MY_PROJECT_ID]', 'us-central1')
);

foreach ($workflows as $workflow) {
    print 'Found workflow: ' . $workflow->getName() . PHP_EOL;
}
```
