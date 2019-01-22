# Google Cloud Datastore V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Datastore\V1\DatastoreClient;
use Google\Cloud\Datastore\V1\Key;
use Google\Cloud\Datastore\V1\Key\PathElement;
use Google\Cloud\Datastore\V1\PartitionId;

$datastoreClient = new DatastoreClient();
$projectId = '[MY_PROJECT_ID]';
$keys = [];
$keys[] = new Key([
    'partition_id' => new PartitionId([
        'project_id' => $projectId
    ]),
    'path' => [
        new PathElement([
            'kind' => 'Company',
            'name' => 'Google'
        ])
    ]
]);

$entity = $datastoreClient->lookup($projectId, $keys);
```
