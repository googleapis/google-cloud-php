<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests\System\BigQuery;

use Google\Cloud\ExponentialBackoff;
use GuzzleHttp\Psr7;

class LoadDataAndQueryTest extends BigQueryTestCase
{
    private static $expectedRows = 0;

    /**
     * @dataProvider rowProvider
     */
    public function testLoadsDataToTable($data)
    {
        $job = self::$table->load($data, [
            'jobConfig' => [
                'sourceFormat' => 'CSV'
            ]
        ]);
        $backoff = new ExponentialBackoff(8);
        $backoff->execute(function () use ($job) {
            $job->reload();

            if (!$job->isComplete()) {
                throw new \Exception();
            }
        });

        if (!$job->isComplete()) {
            $this->fail('Job failed to complete within the allotted time.');
        }

        self::$expectedRows += count(file(__DIR__ . '/../data/table-data.csv'));
        $actualRows = count(iterator_to_array(self::$table->rows()));

        $this->assertEquals(self::$expectedRows, $actualRows);
    }

    public function rowProvider()
    {
        $data = file_get_contents(__DIR__ . '/../data/table-data.csv');

        return [
            [$data],
            [fopen(__DIR__ . '/../data/table-data.csv', 'r')],
            [Psr7\stream_for($data)]
        ];
    }

    /**
     * @depends testLoadsDataToTable
     */
    public function testLoadsDataFromStorageToTable()
    {
        $object = self::$bucket->upload(
            fopen(__DIR__ . '/../data/table-data.csv', 'r')
        );
        self::$deletionQueue[] = $object;

        $job = self::$table->loadFromStorage($object, [
            'jobConfig' => [
                'sourceFormat' => 'CSV'
            ]
        ]);
        $backoff = new ExponentialBackoff(8);
        $backoff->execute(function () use ($job) {
            $job->reload();

            if (!$job->isComplete()) {
                throw new \Exception();
            }
        });
        if (!$job->isComplete()) {
            $this->fail('Job failed to complete within the allotted time.');
        }

        self::$expectedRows += count(file(__DIR__ . '/../data/table-data.csv'));
        $actualRows = count(iterator_to_array(self::$table->rows()));

        $this->assertEquals(self::$expectedRows, $actualRows);
    }

    /**
     * @depends testLoadsDataFromStorageToTable
     */
    public function testInsertRowToTable()
    {
        self::$expectedRows++;
        $insertResponse = self::$table->insertRow([
            'city' => 'Detroit',
            'state' => 'MI'
        ]);

        $this->assertTrue($insertResponse->isSuccessful());
    }

    /**
     * @depends testInsertRowToTable
     */
    public function testInsertRowsToTable()
    {
        $rows = [
            [
                'data' => [
                    'city' => 'Detroit',
                    'state' => 'MI'
                ]
            ],
            [
                'data' => [
                    'city' => 'Ann Arbor',
                    'state' => 'MI'
                ]
            ]
        ];
        self::$expectedRows += count($rows);
        $insertResponse = self::$table->insertRows($rows);

        $this->assertTrue($insertResponse->isSuccessful());
    }

    /**
     * @depends testInsertRowsToTable
     */
    public function testRunQuery()
    {
        $results = self::$client->runQuery(
            sprintf(
                'SELECT * FROM [%s.%s]',
                self::$dataset->id(),
                self::$table->id()
            )
        );
        $backoff = new ExponentialBackoff(8);
        $backoff->execute(function () use ($results) {
            $results->reload();

            if (!$results->isComplete()) {
                throw new \Exception();
            }
        });

        if (!$results->isComplete()) {
            $this->fail('Query did not complete within the allotted time.');
        }

        $actualRows = count(iterator_to_array($results->rows()));

        $this->assertEquals(self::$expectedRows, $actualRows);
    }

    /**
     * @depends testInsertRowsToTable
     */
    public function testRunQueryAsJob()
    {
        $job = self::$client->runQueryAsJob(
            sprintf(
                'SELECT * FROM [%s.%s]',
                self::$dataset->id(),
                self::$table->id()
            )
        );
        $results = $job->queryResults();
        $backoff = new ExponentialBackoff(8);
        $backoff->execute(function () use ($results) {
            $results->reload();

            if (!$results->isComplete()) {
                throw new \Exception();
            }
        });

        if (!$results->isComplete()) {
            $this->fail('Query did not complete within the allotted time.');
        }

        $actualRows = count(iterator_to_array($results->rows()));

        $this->assertEquals(self::$expectedRows, $actualRows);
    }
}
