# Google BigQuery Storage V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\BigQuery\Storage\V1\BigQueryReadClient;
use Google\Cloud\BigQuery\Storage\V1\DataFormat;
use Google\Cloud\BigQuery\Storage\V1\ReadSession;
use Google\Cloud\BigQuery\Storage\V1\ReadSession\TableReadOptions;

$client = new BigQueryReadClient();

$project = sprintf(
    'projects/%s',
    '[MY_PROJECT_ID]'
);
$table = sprintf(
    'projects/%s/datasets/%s/tables/%s',
    'bigquery-public-data',
    'usa_names',
    'usa_1910_current'
);
$readOptions = (new TableReadOptions())
    ->setRowRestriction('state = "WA"');
$readSession = (new ReadSession())
    ->setTable($table)
    ->setDataFormat(DataFormat::AVRO)
    ->setReadOptions($readOptions);
$session = $client->createReadSession([
    'parent' => $project,
    'readSession' => $readSession,
    'maxStreamCount' => 1
]);

$stream = $client->readRows([
    'readStream' => $session->getStreams()[0]->getName()
]);

foreach ($stream->readAll() as $response) {
    printf(
        'Discovered %s rows in response.' . PHP_EOL,
        $response->getRowCount()
    );
}
```
