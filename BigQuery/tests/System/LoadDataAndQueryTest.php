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

namespace Google\Cloud\BigQuery\Tests\System;

use Google\Cloud\BigQuery\BigNumeric;
use Google\Cloud\BigQuery\Geography;
use Google\Cloud\BigQuery\Json;
use Google\Cloud\BigQuery\Numeric;
use Google\Cloud\BigQuery\Timestamp;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\ExponentialBackoff;
use GuzzleHttp\Psr7\Utils;

/**
 * @group bigquery
 * @group bigquery-load
 */
class LoadDataAndQueryTest extends BigQueryTestCase
{
    const US_STATES_ORC_DATA = 'gs://cloud-samples-data/bigquery/us-states/us-states.orc';

    private static $expectedRows = 0;
    private $row;
    private $legacyRow;
    private $geographyPattern;

    public function setUp(): void
    {
        $this->legacyRow = [
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
            'FavoriteNumbers' => [new Numeric('0.123'), new Numeric('0.123')],
            'BiggerNumbers' => [
                new BigNumeric('0.999999999999999999'),
                new BigNumeric('343343434343433434343.2')
            ],
            'Location' => new Geography('POINT(12 34)'),
        ];
        $this->row = $this->legacyRow;
        $this->row['Json'] = new Json([
            'City' => 'Bangalore',
            'HouseNumber' => 1234
        ]);
        $this->geographyPattern = '/POINT\\s*\\(\\s*12\\s+34\\s*\\)/';
    }

    public function testInsertRowToTable()
    {
        self::$expectedRows++;
        $insertResponse = self::$table->insertRow($this->row);
        $insertResponseLegacy = self::$legacyTable->insertRow($this->legacyRow);
        sleep(1);
        $rows = iterator_to_array(self::$table->rows());
        $actualRow = $rows[self::$expectedRows-1];

        $this->assertTrue($insertResponse->isSuccessful());
        $this->assertTrue($insertResponseLegacy->isSuccessful());
        $this->assertCount(self::$expectedRows, $rows);

        $expectedRow = $this->row;
        $expectedBytes = $expectedRow['Spells'][0]['Icon'];
        $actualBytes = $actualRow['Spells'][0]['Icon'];
        unset($expectedRow['Spells'][0]['Icon']);
        unset($actualRow['Spells'][0]['Icon']);
        unset($actualRow['CreatedTimestamp']);
        $actualGeography = $actualRow['Location'];
        unset($expectedRow['Location'], $actualRow['Location']);

        $this->assertEquals($expectedRow, $actualRow);
        $this->assertEquals((string) $expectedBytes, (string) $actualBytes);
        $this->assertMatchesRegularExpression($this->geographyPattern, (string) $actualGeography);
    }

    /**
     * @depends testInsertRowToTable
     * @dataProvider useLegacySqlProvider
     */
    public function testRunQuery($useLegacySql)
    {
        $queryString = $useLegacySql ?
        sprintf(
            'SELECT Name, Age, Weight, IsMagic, Spells.*, Location FROM [%s.%s]',
            self::$dataset->id(),
            self::$legacyTable->id()
        ) : sprintf(
            'SELECT Name, Age, Weight, IsMagic, Spells, Location, Json FROM `%s.%s`',
            self::$dataset->id(),
            self::$table->id()
        );
        $query = self::$client->query($queryString)
            ->useLegacySql($useLegacySql);
        $results = self::$client->runQuery($query);
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
            $this->assertMatchesRegularExpression($this->geographyPattern, (string) $actualRow['Location']);
        } else {
            $expectedRow = $this->row;
            $expectedBytes = $expectedRow['Spells'][0]['Icon'];
            $actualBytes = $actualRow['Spells'][0]['Icon'];
            unset($expectedRow['FavoriteNumbers']);
            unset($expectedRow['BiggerNumbers']);
            unset($expectedRow['ImportantDates']);
            unset($expectedRow['Spells'][0]['Icon']);
            unset($actualRow['Spells'][0]['Icon']);
            $actualGeography = $actualRow['Location'];
            unset($actualRow['Location'], $expectedRow['Location']);

            $this->assertEquals($expectedRow, $actualRow);
            $this->assertEquals((string) $expectedBytes, (string) $actualBytes);
            $this->assertMatchesRegularExpression($this->geographyPattern, (string) $actualGeography);
        }
    }

    public function testInsertRowToTableWithDefaultValueExpression()
    {
        $row = $this->row;
        // unset default value expression fields so that they are populated automatically
        unset(
            $row['Name'],
            $row['Age'],
            $row['Weight'],
            $row['IsMagic'],
            $row['CreatedTimestamp']
        );
        self::$expectedRows++;
        $insertResponse = self::$table->insertRow($row);
        sleep(1);
        $rows = iterator_to_array(self::$table->rows());

        $this->assertTrue($insertResponse->isSuccessful());
        $this->assertCount(self::$expectedRows, $rows);

        $actualRow = $rows[self::$expectedRows-1];

        $expectedRow = $this->row;
        // default values from schema
        $expectedRow['Name'] = 'Default Name';
        $expectedRow['Age'] = 1;
        $expectedRow['Weight'] = 0.5;
        $expectedRow['IsMagic'] = false;

        $expectedBytes = $expectedRow['Spells'][0]['Icon'];
        $actualBytes = $actualRow['Spells'][0]['Icon'];
        unset($expectedRow['Spells'][0]['Icon'], $actualRow['Spells'][0]['Icon']);

        $actualGeography = $actualRow['Location'];
        unset($expectedRow['Location'], $actualRow['Location']);

        $expectedTimestamp = new Timestamp(new \DateTimeImmutable());
        $actualTimestamp = $actualRow['CreatedTimestamp'];
        unset($actualRow['CreatedTimestamp']);

        $this->assertEquals($expectedRow, $actualRow);
        $this->assertEquals((string) $expectedBytes, (string) $actualBytes);
        $this->assertMatchesRegularExpression($this->geographyPattern, (string) $actualGeography);
        $this->assertEqualsWithDelta(
            $expectedTimestamp->get()->getTimestamp(),
            $actualTimestamp->get()->getTimestamp(),
            10
        );
    }

    /**
     * @depends testInsertRowToTable
     * @dataProvider useLegacySqlProvider
     */
    public function testStartQuery($useLegacySql)
    {
        $queryString = $useLegacySql ? sprintf(
            'SELECT FavoriteNumbers, BiggerNumbers, ImportantDates.* FROM [%s.%s]',
            self::$dataset->id(),
            self::$legacyTable->id()
        ) : sprintf(
            'SELECT FavoriteNumbers, BiggerNumbers, ImportantDates FROM `%s.%s`',
            self::$dataset->id(),
            self::$table->id()
        );
        $query = self::$client->query($queryString)
            ->useLegacySql($useLegacySql);
        $job = self::$client->startQuery($query);
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
            $biggerNumbers = $this->row['BiggerNumbers'];

            $this->assertEquals($numbers[0], $actualRows[0]['FavoriteNumbers']);
            $this->assertEquals($numbers[1], $actualRows[1]['FavoriteNumbers']);

            $this->assertEquals($biggerNumbers[0], $actualRows[0]['BiggerNumbers']);
            $this->assertEquals($biggerNumbers[1], $actualRows[1]['BiggerNumbers']);

            $this->assertEquals($dates['TeaTime'], $actualRows[0]['ImportantDates_TeaTime']);
            $this->assertEquals($dates['NextVacation'], $actualRows[0]['ImportantDates_NextVacation']);
            $this->assertEquals($dates['FavoriteTime'], $actualRows[0]['ImportantDates_FavoriteTime']);
        } else {
            $expectedRow = [
                'FavoriteNumbers' => $this->row['FavoriteNumbers'],
                'BiggerNumbers' => $this->row['BiggerNumbers'],
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
        $queryString = 'SELECT'
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
            . '@bytes as bytes, '
            . '@numeric as numeric, '
            . '@geography as geography';

        $bytes = self::$client->bytes('123');
        $numeric = self::$client->numeric('9.999999999');
        $geography = self::$client->geography('POINT(10 20)');
        $geographyPattern = '/POINT\\s*\\(\\s*10\\s+20\\s*\\)/';
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
            'bytes' => $bytes,
            'numeric' => $numeric,
            'geography' => $geography,
        ];
        $query = self::$client->query($queryString)
            ->parameters($params);
        $results = self::$client->runQuery($query);

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
        $actualGeography = $actualRow['geography'];
        unset($params['geography'], $actualRow['geography']);

        $this->assertEquals($params, $actualRow);
        $this->assertEquals((string) $bytes, (string) $actualBytes);
        $this->assertMatchesRegularExpression($geographyPattern, (string) $actualGeography);
    }

    public function testRunQueryWithPositionalParameters()
    {
        $query = self::$client->query('SELECT 1 IN UNNEST(?) AS arr')
            ->parameters([
                [1, 2, 3]
            ]);
        $results = self::$client->runQuery($query);

        if (!$results->isComplete()) {
            $this->fail('Query did not complete within the allotted time.');
        }

        $actualRows = iterator_to_array($results->rows());
        $expectedRows = [
            ['arr' => true]
        ];

        $this->assertEquals($expectedRows, $actualRows);
    }

    public function testRunQueryWithEmptyPositionalArrayParams()
    {
        $queryStr = sprintf(
            'SELECT Name Location FROM `%s.%s` WHERE Age IN UNNEST(?)',
            self::$dataset->id(),
            self::$table->id()
        );

        $query = self::$client->query($queryStr)->parameters([
            []
        ])->setParamTypes(['INT64']);
        $results = self::$client->runQuery($query);
        $actualRows = iterator_to_array($results->rows());
        $this->assertEquals(0, count($actualRows));


        // Test the same w/o the call to setParamTypes
        $query = self::$client->query($queryStr)->parameters([
            []
        ]);

        // we expect an exception as we didn't use setParamTypes with an empty array
        $this->expectException(BadRequestException::class);
        $results = self::$client->runQuery($query);
    }

    public function testRunQueryWithEmptyNamedArrayParams()
    {
        // we expect an exception as we didn't use setParamTypes with an empty array
        $this->expectException(BadRequestException::class);
        $queryStr = sprintf(
            'SELECT Name Location FROM `%s.%s` WHERE Age IN UNNEST(@ages)',
            self::$dataset->id(),
            self::$table->id()
        );

        $query = self::$client->query($queryStr)->parameters([
            'ages' => []
        ])->setParamTypes(['ages' => 'INT64']);
        $results = self::$client->runQuery($query);
        $actualRows = iterator_to_array($results->rows());
        $this->assertEquals(0, count($actualRows));


        // Test the same w/o the call to setParamTypes
        $query = self::$client->query($queryStr)->parameters([
            'ages' => []
        ]);

        self::$client->runQuery($query);
    }

    public function testStartQueryWithNamedParameters()
    {
        $query = self::$client->query('SELECT @int as int')
            ->parameters([
                'int' => 5
            ]);
        $job = self::$client->startQuery($query);
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

    public function testStartQueryWithPositionalParameters()
    {
        $query = self::$client->query('SELECT 1 IN UNNEST(?) AS arr')
            ->parameters([
                [1, 2, 3]
            ]);
        $job = self::$client->startQuery($query);
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
     */
    public function testLoadsDataToTable($data)
    {
        $loadJobConfig = self::$table->load($data)
            ->sourceFormat('NEWLINE_DELIMITED_JSON');

        $job = self::$client->startJob($loadJobConfig);
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

        self::$expectedRows += count(file(__DIR__ . '/data/table-data.json'));
        $actualRows = count(iterator_to_array(self::$table->rows()));

        $this->assertEquals(self::$expectedRows, $actualRows);
    }

    public function rowProvider()
    {
        $data = file_get_contents(__DIR__ . '/data/table-data.json');

        return [
            [$data],
            [fopen(__DIR__ . '/data/table-data.json', 'r')],
            [Utils::streamFor($data)]
        ];
    }

    /**
     * @depends testLoadsDataToTable
     */
    public function testQueryDatatoClusteredTable()
    {
        $table = self::$dataset->table(uniqid(self::TESTING_PREFIX));
        $queryConfig = self::$client->query('SELECT * FROM ' . self::$dataset->id() . '.' . self::$table->id())
            ->timePartitioning([
                'expirationMs' => 10000
            ])
            ->clustering([
                'fields' => [
                    'Name'
                ]
            ])
            ->destinationTable($table);

        $res = self::$client->runQuery($queryConfig);
        $actualRows = count(iterator_to_array($table->rows()));
        $this->assertEquals(self::$expectedRows, $actualRows);

        $info = $table->reload();
        $this->assertEquals([
            'fields' => [
                'Name'
            ]
        ], $info['clustering']);
    }

    public function testLoadDataToClusteredTable()
    {
        $data = file_get_contents(__DIR__ . '/data/table-data.json');
        $table = self::$dataset->table(uniqid(self::TESTING_PREFIX));
        $loadJobConfig = $table->load($data)
            ->autodetect(true)
            ->timePartitioning([
                'expirationMs' => 10000
            ])
            ->clustering([
                'fields' => [
                    'Name'
                ]
            ])
            ->sourceFormat('NEWLINE_DELIMITED_JSON');

        $job = self::$client->startJob($loadJobConfig);
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

        $expectedRows = count(file(__DIR__ . '/data/table-data.json'));
        $actualRows = count(iterator_to_array($table->rows()));

        $this->assertEquals($expectedRows, $actualRows);
    }

    /**
     * @depends testLoadsDataToTable
     */
    public function testLoadsDataFromStorageToTable()
    {
        $object = self::$bucket->upload(
            fopen(__DIR__ . '/data/table-data.json', 'r')
        );

        $loadJobConfig = self::$table->loadFromStorage($object)
            ->sourceFormat('NEWLINE_DELIMITED_JSON');
        $job = self::$client->startJob($loadJobConfig);
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

        self::$expectedRows += count(file(__DIR__ . '/data/table-data.json'));
        $actualRows = count(iterator_to_array(self::$table->rows()));

        $this->assertEquals(self::$expectedRows, $actualRows);
    }

    public function testLoadsOrcDataFromStorageToTable()
    {
        $table = self::$dataset->createTable('orc_test_data', [
            'metadata' => [
                'schema' => [
                    'fields' => [
                        [
                            'name' => 'name',
                            'type' => 'STRING'
                        ],
                        [
                            'name' => 'post_abbr',
                            'type' => 'STRING'
                        ]
                    ]
                ]
            ]
        ]);
        $loadJobConfig = $table->loadFromStorage(self::US_STATES_ORC_DATA)
            ->sourceFormat('ORC');
        $job = self::$client->runJob($loadJobConfig, [
            'maxRetries' => 8
        ]);

        $this->assertGreaterThan(
            0,
            count(iterator_to_array($table->rows()))
        );
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

    public function testInsertRowsToTableWithAutoCreate()
    {
        $tName = uniqid(BigQueryTestCase::TESTING_PREFIX);
        $rows = [
            ['data' => ['hello' => 'world']]
        ];
        $insertResponse = self::$dataset->table($tName)
            ->insertRows($rows, [
                'autoCreate' => true,
                'tableMetadata' => [
                    'schema' => [
                        'fields' => [
                            [
                                'name' => 'hello',
                                'type' => 'STRING'
                            ]
                        ]
                    ]
                ]
            ]);
        $results = self::$dataset
            ->table($tName)
            ->rows();
        $actualRows = count(iterator_to_array($results));

        $this->assertTrue($insertResponse->isSuccessful());
        $this->assertEquals(count($rows), $actualRows);
    }

    public function testLoadAndQueryDataWithIntegerRangePartitioning()
    {
        $partitioning = [
            'field' => 'age',
            'range' => [
                'start' => '0',
                'interval' => '100',
                'end' => '1000'
            ]
        ];

        $data = file_get_contents(__DIR__ . '/data/table-data.json');
        $table = self::$dataset->table(uniqid(self::TESTING_PREFIX));
        $loadJobConfig = $table->load($data)
            ->autodetect(true)
            ->rangePartitioning($partitioning)
            ->sourceFormat('NEWLINE_DELIMITED_JSON');

        $job = self::$client->startJob($loadJobConfig);
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

        $expectedRows = count(file(__DIR__ . '/data/table-data.json'));
        $actualRows = count(iterator_to_array($table->rows()));

        $this->assertEquals($partitioning, $table->info()['rangePartitioning']);
        $this->assertEquals($expectedRows, $actualRows);

        $queryTable = self::$dataset->table(uniqid(self::TESTING_PREFIX));
        $queryJobConfig = self::$client->query('SELECT * FROM ' . $table->identity()['tableId'])
            ->defaultDataset(self::$dataset)
            ->destinationTable($queryTable)
            ->rangePartitioning($partitioning);

        $job = self::$client->startJob($queryJobConfig);
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

        $actualRows = count(iterator_to_array($table->rows()));

        $this->assertEquals($partitioning, $queryTable->info()['rangePartitioning']);
        $this->assertEquals($expectedRows, $actualRows);
    }

    public function testLoadAndQueryDataWithHivePartitioning()
    {
        $autoTable = self::$dataset->table(uniqid(self::TESTING_PREFIX));
        $loadJobConfig = $autoTable->load('')
            ->sourceFormat("PARQUET")
            ->sourceUris([
                "gs://cloud-samples-data/bigquery/hive-partitioning-samples/autolayout/*"
            ])
            ->autoDetect(true)
            ->hivePartitioningOptions([
                'mode' => 'AUTO',
                'sourceUriPrefix' => "gs://cloud-samples-data/bigquery/hive-partitioning-samples/autolayout/",
                'requirePartitionFilter' => true,
            ]);

        $job = self::$client->startJob($loadJobConfig);
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

        $customTable = self::$dataset->table(uniqid(self::TESTING_PREFIX));
        $loadJobConfig = $customTable->load('')
            ->sourceFormat("PARQUET")
            ->sourceUris([
                "gs://cloud-samples-data/bigquery/hive-partitioning-samples/customlayout/*"
            ])
            ->autoDetect(true)
            ->hivePartitioningOptions([
                'mode' => 'CUSTOM',
                'sourceUriPrefix' => "gs://cloud-samples-data/bigquery/hive-partitioning-samples/" .
                    "customlayout/{pkey:STRING}/",
            ]);

        $job = self::$client->startJob($loadJobConfig);
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

        $query = 'SELECT COUNT(*) as ct FROM `%s`.%s.%s WHERE pkey="foo"';
        $q = self::$client->query(sprintf(
            $query,
            $customTable->identity()['projectId'],
            $customTable->identity()['datasetId'],
            $customTable->identity()['tableId']
        ));

        $qr = self::$client->runQuery($q);
        $rows = iterator_to_array($qr->rows());
        $this->assertEquals(50, $rows[0]['ct']);
    }

    /**
     * @depends testInsertRowToTable
     */
    public function testJsonDatatype()
    {
        $rows = iterator_to_array(self::$table->rows());
        $actualRow = $rows[self::$expectedRows-1];

        $this->assertEquals(
            json_decode($this->row['Json'], true)['HouseNumber'],
            json_decode($actualRow['Json']->get(), true)['HouseNumber']
        );
        $this->assertEquals(
            json_decode($this->row['Json'], true)['City'],
            json_decode($actualRow['Json']->get(), true)['City']
        );
    }

    public function testInsertFaultyJsonToTable()
    {
        $row = $this->row;
        $row['Json'] = '{';
        $insertResponse = self::$table->insertRow($row);
        $this->assertEquals(
            $insertResponse->info()['insertErrors'][0]['errors'][0]['reason'],
            "invalid"
        );
    }
}
