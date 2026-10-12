<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\BigQuery\Tests\Perf;

use Google\Cloud\BigQuery\BigQueryClient;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 */
class BigQueryTest extends TestCase
{
    const SOURCE = 'bigquery.json';

    private $client;

    public function setUp(): void
    {
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $this->client = new BigQueryClient([
            'keyFilePath' => $keyFilePath
        ]);
    }

    /**
     * @dataProvider queries
     * @runInSeparateProcess
     */
    public function testPerf($query)
    {
        $start = microtime(true);
        $config = $this->client->query($query);
        $queryResults = $this->client->runQuery($config);

        $rows = 0;
        $cols = 0;
        $firstByteDur = 0;

        foreach ($queryResults as $row) {
            $rows++;
            if ($cols == 0) {
                $firstByteDur = microtime(true) - $start;
                $cols = count($row);
            } elseif ($cols != count($row)) {
                throw new Exception("expected $cols cols, found " . count($row));
            }
        }

        $totalDur = microtime(true)-$start;
        echo "query $query: $rows rows, $cols cols, first byte $firstByteDur, total $totalDur" . PHP_EOL;
    }

    public function queries()
    {
        $queries = json_decode(file_get_contents(__DIR__ . '/fixtures/' . self::SOURCE), true);
        foreach ($queries as $key => $q) {
            $queries[$key] = is_array($q)
                ? $q
                : [$q];
        }

        return $queries;
    }
}
