<?php

// Provide a project ID. If you're mocking your service calls (and if you aren't
// start now) you don't need anything else.
putenv('GOOGLE_APPLICATION_CREDENTIALS='. __DIR__ .'/keyfile-stub.json');

use Google\Cloud\Dev\Snippet\Container;
use Google\Cloud\Dev\Snippet\Coverage\Coverage;
use Google\Cloud\Dev\Snippet\Coverage\Scanner;
use Google\Cloud\Dev\Snippet\Parser\Parser;

require __DIR__ . '/../../vendor/autoload.php';

$parser = new Parser;
$scanner = new Scanner($parser, __DIR__ .'/../../src');
$coverage = new Coverage($scanner);
$coverage->buildListToCover();

Container::$coverage = $coverage;
Container::$parser = $parser;

register_shutdown_function(function () {
    $uncovered = Container::$coverage->uncovered();

    if (!file_exists(__DIR__ .'/../../build')) {
        mkdir(__DIR__ .'/../../build', 0777, true);
    }

    file_put_contents(__DIR__ .'/../../build/snippets-uncovered.json', json_encode($uncovered, JSON_PRETTY_PRINT));

    if (!empty($uncovered)) {
        echo sprintf("\033[31mNOTICE: %s uncovered snippets! See build/snippets-uncovered.json for a report.\n", count($uncovered));
    }
});

function stub($name, $extends)
{
    $tpl = 'class %s extends %s {use \Google\Cloud\Dev\SetStubConnectionTrait; }';

    eval(sprintf($tpl, $name, $extends));
}

stub('AclStub', Google\Cloud\Storage\Acl::class);
stub('BigQueryClientStub', Google\Cloud\BigQuery\BigQueryClient::class);
stub('BucketStub', Google\Cloud\Storage\Bucket::class);
stub('DatastoreClientStub', Google\Cloud\Datastore\DatastoreClient::class);
stub('IamStub', Google\Cloud\Core\Iam\Iam::class);
stub('LoggerStub', Google\Cloud\Logging\Logger::class);
stub('LoggingClientStub', Google\Cloud\Logging\LoggingClient::class);
stub('MetricStub', Google\Cloud\Logging\Metric::class);
stub('OperationStub', Google\Cloud\Datastore\Operation::class);
stub('PubSubClientStub', Google\Cloud\PubSub\PubSubClient::class);
stub('QueryResultsStub', Google\Cloud\BigQuery\QueryResults::class);
stub('SinkStub', Google\Cloud\Logging\Sink::class);
stub('SpeechClientStub', Google\Cloud\Speech\SpeechClient::class);
stub('SpeechOperationStub', Google\Cloud\Speech\Operation::class);
stub('StorageClientStub', Google\Cloud\Storage\StorageClient::class);
stub('StorageObjectStub', Google\Cloud\Storage\StorageObject::class);
stub('SubscriptionStub', Google\Cloud\PubSub\Subscription::class);
stub('TableStub', Google\Cloud\BigQuery\Table::class);
stub('TopicStub', Google\Cloud\PubSub\Topic::class);
stub('TranslateClientStub', Google\Cloud\Translate\TranslateClient::class);
stub('VisionClientStub', Google\Cloud\Vision\VisionClient::class);
