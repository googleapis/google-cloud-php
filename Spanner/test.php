<?php

require 'vendor/autoload.php';

use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\LongRunning\ListOperationsRequest;

// $dbAdmin = new DatabaseAdminClient();
// $operationsClient = $dbAdmin->getOperationsClient();
// $request = new ListOperationsRequest();
// // $request->setName('projects/php-docs-samples-kokoro/operations');
// $operationsClient->listOperations($request);
// // exit;

// var_dump(InstanceAdminClient::instanceConfigName('my-project', ''));
// exit;
$spanner = new SpannerClient();
$config = $spanner->instanceConfiguration('regional-us-central1');
$config->create();

foreach ($spanner->instanceConfigOperations() as $instanceConfig) {
  var_dump($instanceConfig->getName());
}

// // $spanner->longRunningOperations();
// foreach ($spanner->instances() as $instance) {
//   foreach ($instance->databases() as $database) {
//     foreach ($database->longRunningOperations() as $operation) {
//       var_dump($operation->getName());
//     }
//     // var_dump($operation->getName());
//   }
// }

