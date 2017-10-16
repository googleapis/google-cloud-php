<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require 'vendor/autoload.php';

use Google\Cloud\BigQuery\BigQueryClient;

if (count($argv) < 2) {
  print("usage: php {$argv[0]} <queries.json>");
  exit(1);
}

$requests = json_decode(file_get_contents($argv[1]));

$bigQuery = new BigQueryClient();

foreach ($requests as $request) {
  $start = microtime(true);
  $queryResults = $bigQuery->runQuery($request, [
    'useLegacySql' => false,
  ]);

  while (!$queryResults->isComplete()) {
    sleep(1);
    $queryResults->reload();
  }

  $rows = 0;
  $cols = 0;
  $firstByteDur = 0;

  foreach ($queryResults->rows() as $row) {
    $rows++;
    if ($cols == 0) {
      $firstByteDur = microtime(true) - $start;
      $cols = count($row);
    } else if ($cols != count($row)) {
      throw new Exception("expected $cols cols, found " . count($row));
    }
  }

  $totalDur = microtime(true)-$start;
  print "query $request: $rows rows, $cols cols, first byte $firstByteDur, total $totalDur\n";
}
?>
