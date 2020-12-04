# Google Cloud Workflows Executions V1beta generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Workflows\Executions\V1beta\ExecutionsClient;

$client = new ExecutionsClient();

$executions = $client->listExecutions(
    ExecutionsClient::workflowName(
        '[MY_PROJECT_ID]',
        'us-central1',
        '[MY_WORKFLOW_ID]'
    )
);

foreach ($executions as $execution) {
    print 'Found execution: ' . $execution->getName() . PHP_EOL;
}
```
