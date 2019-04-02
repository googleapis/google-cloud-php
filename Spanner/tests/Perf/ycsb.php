<?php
/**
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Spanner\Tests\Perf;

use Google\Cloud\Spanner\SpannerClient;

if (!class_exists(SpannerClient::class)) {
    $possibleLocations = [
        __DIR__ . '/../../vendor/autoload.php',
        __DIR__ . '/../../../vendor/autoload.php'
    ];

    $found = false;
    foreach ($possibleLocations as $path) {
        if (file_exists($path)) {
            $found = true;
            include $path;

            break;
        }
    }

    if (!$found) {
        throw new \RuntimeException('Could not find composer autoload.php file.');
    }
}

/*
Usage:
php ycsb.php
  --operationcount={number of operations} \
  --instance=[gcloud instance] \
  --database={database name} \
  --workload={workload file}

Note: all arguments above are mandatory
Note: This benchmark script assumes that the table has a PK field named "id".

*/

$parameters = Config::getParameters();
$report = Report::getReporter();

$database = (new SpannerClient)->connect($parameters['instance'], $parameters['database']);

$totalWeight = 0.0;
$weights = [];
$operations = [];
$latency = [];

foreach (Config::$operations as $operation) {
    $weight = (float) $parameters[$operation];
    if ($weight <= 0.0) {
        continue;
    }

    $totalWeight += $weight;
    $operationCode = explode('proportion', $operation);
    $operations[] = $operationCode[0];

    $weights[] = $totalWeight;
    $latency[$operationCode[0]] = [];
}

$timeStart = microtime(true);

$testOp = new Operation($database, $parameters, $totalWeight, $weights, $operations, $latency);
$testOp->load();
$latency = $testOp->run();

$timeEnd = microtime(true) - $timeStart;

// Unfortunately, latencies not stored and reported like in the original script.
// aggregateMetrics(latency, (end - start) * 1000.0, parameters['num_bucket']);
$report->report("[OVERALL] Operation run time: $timeEnd s\n");
$report->aggregateMetrics($latency, $timeEnd);
