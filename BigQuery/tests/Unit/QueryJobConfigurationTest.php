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

namespace Google\Cloud\BigQuery\Tests\Unit;

use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\QueryJobConfiguration;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\ValueMapper;
use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class QueryJobConfigurationTest extends TestCase
{
    use ProphecyTrait;

    const PROJECT_ID = 'my_project';
    const DATASET_ID = 'my_dataset';
    const TABLE_ID = 'my_table';
    const JOB_ID = '1234';

    private $config;
    private $datasetIdentity = [
        'projectId' => self::PROJECT_ID,
        'datasetId' => self::DATASET_ID
    ];
    private $tableIdentity = [
        'projectId' => self::PROJECT_ID,
        'datasetId' => self::DATASET_ID,
        'tableId' => self::TABLE_ID
    ];
    private $expectedConfig;

    public function setUp(): void
    {
        $this->expectedConfig = [
            'projectId' => self::PROJECT_ID,
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ],
            'configuration' => [
                'query' => [
                    'useLegacySql' => false
                ]
            ]
        ];
        $this->config = new QueryJobConfiguration(
            new ValueMapper(false),
            self::PROJECT_ID,
            ['jobReference' => ['jobId' => self::JOB_ID]],
            null
        );
    }

    public function testFluentSetters()
    {
        $defaultDataset = $this->prophesize(Dataset::class);
        $defaultDataset->identity()
            ->willReturn($this->datasetIdentity);
        $destinationTable = $this->prophesize(Table::class);
        $destinationTable->identity()
            ->willReturn($this->tableIdentity);
        $query = [
            'allowLargeResults' => true,
            'clustering' => [
                'fields' => ['a', 'b', 'c']
            ],
            'createDisposition' => 'CREATE_NEVER',
            'defaultDataset' => $this->datasetIdentity,
            'destinationEncryptionConfiguration' => [
                'kmsKeyName' => 'my_key'
            ],
            'destinationTable' => $this->tableIdentity,
            'flattenResults' => true,
            'maximumBillingTier' => 1,
            'maximumBytesBilled' => 100,
            'priority' => 'BATCH',
            'query' => 'SELECT * FROM test',
            'schemaUpdateOptions' => ['ALLOW_FIELD_ADDITION'],
            'tableDefinitions' => [
                'autodetect' => true,
                'sourceUris' => [
                    'gs://my_bucket/table.json'
                ]
            ],
            'timePartitioning' => [
                'type' => 'DAY'
            ],
            'rangePartitioning' => [
                'field' => 'foo',
                'range' => [
                    'start' => '1',
                    'interval' => '1',
                    'end' => '2'
                ]
            ],
            'useLegacySql' => true,
            'useQueryCache' => true,
            'userDefinedFunctionResources' => [
                ['resourceUri' => 'gs://my_bucket/code_path']
            ],
            'writeDisposition' => 'WRITE_TRUNCATE'
        ];
        $this->expectedConfig['configuration']['query'] = $query
            + $this->expectedConfig['configuration']['query'];

        $config = $this->config
            ->allowLargeResults($query['allowLargeResults'])
            ->clustering($query['clustering'])
            ->createDisposition($query['createDisposition'])
            ->defaultDataset($defaultDataset->reveal())
            ->destinationEncryptionConfiguration($query['destinationEncryptionConfiguration'])
            ->destinationTable($destinationTable->reveal())
            ->flattenResults($query['flattenResults'])
            ->maximumBillingTier($query['maximumBillingTier'])
            ->maximumBytesBilled($query['maximumBytesBilled'])
            ->priority($query['priority'])
            ->query($query['query'])
            ->schemaUpdateOptions($query['schemaUpdateOptions'])
            ->tableDefinitions($query['tableDefinitions'])
            ->timePartitioning($query['timePartitioning'])
            ->rangePartitioning($query['rangePartitioning'])
            ->useLegacySql($query['useLegacySql'])
            ->useQueryCache($query['useQueryCache'])
            ->userDefinedFunctionResources($query['userDefinedFunctionResources'])
            ->writeDisposition($query['writeDisposition']);

        $this->assertInstanceOf(QueryJobConfiguration::class, $config);
        $this->assertEquals($this->expectedConfig, $this->config->toArray());
    }

    /**
     * @dataProvider parameterDataProvider
     */
    public function testParameters($args, $expectedQuery)
    {
        $this->expectedConfig['configuration']['query'] = $expectedQuery
            + $this->expectedConfig['configuration']['query'];
        $this->config
            ->parameters($args);

        $this->assertEquals($this->expectedConfig, $this->config->toArray());
    }

    public function parameterDataProvider()
    {
        return [
            [
                ['test' => 'parameter'],
                [
                    'parameterMode' => 'named',
                    'queryParameters' => [
                        [
                            'name' => 'test',
                            'parameterType' => [
                                'type' => 'STRING'
                            ],
                            'parameterValue' => [
                                'value' => 'parameter'
                            ]
                        ]
                    ]
                ]
            ],
            [
                [1, 2],
                [
                    'parameterMode' => 'positional',
                    'queryParameters' => [
                        [
                            'parameterType' => [
                                'type' => 'INT64'
                            ],
                            'parameterValue' => [
                                'value' => 1
                            ]
                        ],
                        [
                            'parameterType' => [
                                'type' => 'INT64'
                            ],
                            'parameterValue' => [
                                'value' => 2
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider setParamTypesDataProvider
     */
    public function testSetParamTypes(array $values, array $types, array $expectedQuery)
    {
        $this->expectedConfig['configuration']['query'] = $expectedQuery
        + $this->expectedConfig['configuration']['query'];

        $this->config
            ->parameters($values)
            ->setParamTypes($types);

        $this->assertEquals($this->expectedConfig, $this->config->toArray());
    }

    public function setParamTypesDataProvider()
    {
        return [
            [
                // test for empty array as a named param
                ['test' => []],
                ['test' => 'STRING'],
                [
                    'parameterMode' => 'named',
                    'queryParameters' => [
                        [
                            'name' => 'test',
                            'parameterType' => [
                                'type' => 'ARRAY',
                                'arrayType' => [
                                    'type' => 'STRING'
                                ]
                            ],
                            'parameterValue' => [
                                'arrayValues' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                // test for empty positional array
                [[]],
                ['INT64'],
                [
                    'parameterMode' => 'positional',
                    'queryParameters' => [
                        [
                            'parameterType' => [
                                'type' => 'ARRAY',
                                'arrayType' => [
                                    'type' => 'INT64'
                                ]
                            ],
                            'parameterValue' => [
                                'arrayValues' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                // test for when the types are explicitly converted
                // here we expect the values specified by the user, even though we can guess the type
                ['param2'],
                ['INT64'],
                [
                    'parameterMode' => 'positional',
                    'queryParameters' => [
                        [
                            'parameterType' => [
                                'type' => 'INT64'
                            ],
                            'parameterValue' => [
                                'value' => 'param2'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Test for setparamTypes call before parameters call
     */
    public function testSetParamTypesThrowsLogicException()
    {
        $this->expectException(LogicException::class);
        $this->config
            ->setParamTypes(['STRING'])
            ->parameters(['test']);
    }

    public function testExtraParamInSetParamTypesThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->config
            ->parameters(['test'])
            ->setParamTypes(['STRING', 'INT64']);
    }

    public function testIncorrectNameInSetParamTypesThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->config
            ->parameters(['key1' => 'test'])
            ->setParamTypes(['key2' => 'INT64']);
    }

    public function testIncorrectIndexInSetParamTypesThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->config
            ->parameters(['test'])
            ->setParamTypes([1 => 'INT64']);
    }
}
