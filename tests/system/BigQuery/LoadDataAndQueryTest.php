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

use Google\Cloud\BigQuery\Bytes;
use Google\Cloud\BigQuery\Date;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\BigQuery\Time;
use Google\Cloud\BigQuery\Timestamp;
use Google\Cloud\BigQuery\ValueMapper;
use GuzzleHttp\Psr7;

/**
 * @group bigquery
 */
class LoadDataAndQueryTest extends BigQueryTestCase
{
    private static $expectedRows = 0;
    private $row;

    public function setUp()
    {
        $this->row = [
            'Name' => 'Dave',
            'Age' => 101,
            'Weight' => 100.5,
            'IsMagic' => true,
            'Spells' => [
                [
                    'Name' => 'Summon Dragon',
                    'LastUsed' => self::$client->timestamp(new \DateTime('2000-01-01 23:59:56 UTC')),
                    'DiscoveredBy' => 'Bobby',
                    'Properties' => [
                        [
                            'Name' => 'Fire',
                            'Power' => 300.2
                        ]
                    ],
                    'Icon' => self::$client->bytes('icon')
                ]
            ],
            'ImportantDates' => [
                'TeaTime' => self::$client->time(new \DateTime('15:15:12')),
                'NextVacation' => self::$client->date(new \DateTime('2020-10-11')),
                'FavoriteTime' => new \DateTime('1920-01-01 15:15:12')
            ],
            'FavoriteNumbers' => [10, 11]
        ];
    }

    public function testInsertRowToTable()
    {
        self::$expectedRows++;
        $insertResponse = self::$table->insertRow($this->row);
        sleep(1);
        $rows = iterator_to_array(self::$table->rows());
        $actualRow = $rows[0];

        $this->assertTrue($insertResponse->isSuccessful());
        $this->assertEquals(self::$expectedRows, count($rows));

        $expectedRow = $this->row;
        $expectedBytes = $expectedRow['Spells'][0]['Icon'];
        $actualBytes = $actualRow['Spells'][0]['Icon'];
        unset($expectedRow['Spells'][0]['Icon']);
        unset($actualRow['Spells'][0]['Icon']);

        $this->assertEquals($expectedRow, $actualRow);
        $this->assertEquals((string) $expectedBytes, (string) $actualBytes);
    }

    /**
     * @depends testInsertRowToTable
     * @dataProvider useLegacySqlProvider
     */
    public function testRunQuery($useLegacySql)
    {
        $query =  sprintf(
            $useLegacySql
                ? 'SELECT Name, Age, Weight, IsMagic, Spells.* FROM [%s.%s]'
                : 'SELECT Name, Age, Weight, IsMagic, Spells FROM `%s.%s`',
            self::$dataset->id(),
            self::$table->id()
        );
        $results = self::$client->runQuery($query, [
            'useLegacySql' => $useLegacySql
        ]);
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

        $actualRow = iterator_to_array($results->rows())[0];

        if ($useLegacySql) {
            $spells = $this->row['Spells'][0];

            $this->assertEquals($this->row['Name'], $actualRow['Name']);
            $this->assertEquals($this->row['Age'], $actualRow['Age']);
            $this->assertEquals($this->row['Weight'], $actualRow['Weight']);
            $this->assertEquals($this->row['IsMagic'], $actualRow['IsMagic']);
            $this->assertEquals($spells['Name'], $actualRow['Spells_Name']);
            $this->assertEquals($spells['LastUsed'], $actualRow['Spells_LastUsed']);
            $this->assertEquals($spells['DiscoveredBy'], $actualRow['Spells_DiscoveredBy']);
            $this->assertEquals($spells['Properties'][0]['Name'], $actualRow['Spells_Properties_Name']);
            $this->assertEquals($spells['Properties'][0]['Power'], $actualRow['Spells_Properties_Power']);
            $this->assertEquals((string) $spells['Icon'], (string) $actualRow['Spells_Icon']);
        } else {
            $expectedRow = $this->row;
            $expectedBytes = $expectedRow['Spells'][0]['Icon'];
            $actualBytes = $actualRow['Spells'][0]['Icon'];
            unset($expectedRow['ImportantDates']);
            unset($expectedRow['FavoriteNumbers']);
            unset($expectedRow['Spells'][0]['Icon']);
            unset($actualRow['Spells'][0]['Icon']);

            $this->assertEquals($expectedRow, $actualRow);
            $this->assertEquals((string) $expectedBytes, (string) $actualBytes);
        }
    }

    /**
     * @depends testInsertRowToTable
     * @dataProvider useLegacySqlProvider
     */
    public function testRunQueryAsJob($useLegacySql)
    {
        $query = sprintf(
            $useLegacySql
                ? 'SELECT FavoriteNumbers, ImportantDates.* FROM [%s.%s]'
                : 'SELECT FavoriteNumbers, ImportantDates FROM `%s.%s`',
            self::$dataset->id(),
            self::$table->id()
        );
        $job = self::$client->runQueryAsJob($query, [
            'jobConfig' => [
                'useLegacySql' => $useLegacySql
            ]
        ]);
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

        $actualRows = iterator_to_array($results->rows());

        if ($useLegacySql) {
            $dates = $this->row['ImportantDates'];
            $numbers = $this->row['FavoriteNumbers'];

            $this->assertEquals($numbers[0], $actualRows[0]['FavoriteNumbers']);
            $this->assertEquals($numbers[1], $actualRows[1]['FavoriteNumbers']);
            $this->assertEquals($dates['TeaTime'], $actualRows[0]['ImportantDates_TeaTime']);
            $this->assertEquals($dates['NextVacation'], $actualRows[0]['ImportantDates_NextVacation']);
            $this->assertEquals($dates['FavoriteTime'], $actualRows[0]['ImportantDates_FavoriteTime']);
        } else {
            $expectedRow = [
                'FavoriteNumbers' => $this->row['FavoriteNumbers'],
                'ImportantDates' => $this->row['ImportantDates']
            ];

            $this->assertEquals($expectedRow, $actualRows[0]);
        }
    }

    public function useLegacySqlProvider()
    {
        return [
            [true],
            [false]
        ];
    }

    public function testRunQueryWithNamedParameters()
    {
        $query = 'SELECT'
            . '@structType as structType,'
            . '@arrayStruct as arrayStruct,'
            . '@nestedStruct as nestedStruct,'
            . '@arrayType as arrayType,'
            . '@name as name,'
            . '@int as int,'
            . '@float as float,'
            . '@timestamp as timestamp,'
            . '@datetime as datetime,'
            . '@date as date,'
            . '@time as time,'
            . '@bytes as bytes';

        $bytes = self::$client->bytes('123');
        $params = [
            'structType' => [
                'hello' => 'world'
            ],
            'arrayStruct' => [
                [
                    'hello' => 'world'
                ]
            ],
            'nestedStruct' => [
                'hello' => [
                    'wor' => 'ld'
                ]
            ],
            'arrayType' => [1,2,3],
            'name' => 'Dave',
            'int' => 5,
            'float' => 5.5,
            'timestamp' => self::$client->timestamp(new \DateTime('2003-02-05 11:15:02.421827Z')),
            'datetime' => new \DateTime('2003-02-05 11:15:02.421827Z'),
            'date' => self::$client->date(new \DateTime('2003-12-12')),
            'time' => self::$client->time(new \DateTime('11:15:02')),
            'bytes' => $bytes
        ];
        $results = self::$client->runQuery($query, ['parameters' => $params]);

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

        $actualRow = iterator_to_array($results->rows())[0];
        $actualBytes = $actualRow['bytes'];
        unset($params['bytes']);
        unset($actualRow['bytes']);

        $this->assertEquals($params, $actualRow);
        $this->assertEquals((string) $bytes, (string) $actualBytes);
    }

    public function testRunQueryWithPositionalParameters()
    {
        $results = self::$client->runQuery('SELECT 1 IN UNNEST(?) AS arr', [
            'parameters' => [
                [1, 2, 3]
            ]
        ]);
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

        $actualRows = iterator_to_array($results->rows());
        $expectedRows = [
            ['arr' => true]
        ];

        $this->assertEquals($expectedRows, $actualRows);
    }

    public function testRunQueryAsJobWithNamedParameters()
    {
        $query = 'SELECT @int as int';
        $job = self::$client->runQueryAsJob($query, [
            'parameters' => [
                'int' => 5
            ]
        ]);
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

        $actualRows = iterator_to_array($results->rows());
        $expectedRows = [['int' => 5]];

        $this->assertEquals($expectedRows, $actualRows);
    }

    public function testRunQueryAsJobWithPositionalParameters()
    {
        $job = self::$client->runQueryAsJob('SELECT 1 IN UNNEST(?) AS arr', [
            'parameters' => [
                [1, 2, 3]
            ]
        ]);
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

        $actualRows = iterator_to_array($results->rows());
        $expectedRows = [
            ['arr' => true]
        ];

        $this->assertEquals($expectedRows, $actualRows);
    }

    /**
     * @dataProvider rowProvider
     * @depends testInsertRowToTable
     */
    public function testLoadsDataToTable($data)
    {
        $job = self::$table->load($data, [
            'jobConfig' => [
                'sourceFormat' => 'NEWLINE_DELIMITED_JSON'
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

        self::$expectedRows += count(file(__DIR__ . '/../data/table-data.json'));
        $actualRows = count(iterator_to_array(self::$table->rows()));

        $this->assertEquals(self::$expectedRows, $actualRows);
    }

    public function rowProvider()
    {
        $data = file_get_contents(__DIR__ . '/../data/table-data.json');

        return [
            [$data],
            [fopen(__DIR__ . '/../data/table-data.json', 'r')],
            [Psr7\stream_for($data)]
        ];
    }

    /**
     * @depends testLoadsDataToTable
     */
    public function testLoadsDataFromStorageToTable()
    {
        $object = self::$bucket->upload(
            fopen(__DIR__ . '/../data/table-data.json', 'r')
        );
        self::$deletionQueue[] = $object;

        $job = self::$table->loadFromStorage($object, [
            'jobConfig' => [
                'sourceFormat' => 'NEWLINE_DELIMITED_JSON'
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

        self::$expectedRows += count(file(__DIR__ . '/../data/table-data.json'));
        $actualRows = count(iterator_to_array(self::$table->rows()));

        $this->assertEquals(self::$expectedRows, $actualRows);
    }

    /**
     * @depends testLoadsDataToTable
     */
    public function testInsertRowsToTable()
    {
        $rows = [
            ['data' => $this->row],
            ['data' => $this->row]
        ];
        self::$expectedRows += count($rows);
        $insertResponse = self::$table->insertRows($rows);
        $actualRows = count(iterator_to_array(self::$table->rows()));

        $this->assertTrue($insertResponse->isSuccessful());
        $this->assertEquals(self::$expectedRows, $actualRows);
    }
}
