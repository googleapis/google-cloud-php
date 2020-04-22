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

namespace Google\Cloud\BigQuery\Tests\Snippet;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\QueryJobConfiguration;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;

/**
 * @group bigquery
 */
class QueryJobConfigurationTest extends SnippetTestCase
{
    const PROJECT_ID = 'my_project';
    const DATASET_ID = 'my_dataset';
    const TABLE_ID = 'my_table';
    const JOB_ID = '123';

    private $config;

    public function setUp()
    {
        $this->config = new QueryJobConfiguration(
            new ValueMapper(false),
            self::PROJECT_ID,
            ['jobReference' => ['jobId' => self::JOB_ID]],
            null
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(QueryJobConfiguration::class);
        $res = $snippet->invoke('query');

        $this->assertInstanceOf(QueryJobConfiguration::class, $res->returnVal());
    }

    /**
     * @dataProvider setterDataProvider
     */
    public function testSetters($method, $expected, $bq = null)
    {
        $snippet = $this->snippetFromMethod(QueryJobConfiguration::class, $method);
        $snippet->addLocal('query', $this->config);

        if ($bq) {
            $snippet->addLocal('bigQuery', $bq);
        }

        $actual = $snippet->invoke('query')
            ->returnVal()
            ->toArray()['configuration']['query'][$method];

        $this->assertEquals($expected, $actual);
    }

    public function setterDataProvider()
    {
        $bq = TestHelpers::stub(BigQueryClient::class, [
            ['projectId' => self::PROJECT_ID]
        ]);

        return [
            [
                'allowLargeResults',
                true
            ],
            [
                'clustering',
                [
                    'fields' => [
                        'col1',
                        'col2'
                    ]
                ]
            ],
            [
                'createDisposition',
                'CREATE_NEVER'
            ],
            [
                'defaultDataset',
                [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => self::DATASET_ID
                ],
                $bq
            ],
            [
                'destinationEncryptionConfiguration',
                [
                    'kmsKeyName' => 'my_key'
                ]
            ],
            [
                'destinationTable',
                [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => self::DATASET_ID,
                    'tableId' => self::TABLE_ID
                ],
                $bq
            ],
            [
                'flattenResults',
                true
            ],
            [
                'maximumBillingTier',
                1
            ],
            [
                'maximumBytesBilled',
                3000
            ],
            [
                'priority',
                'BATCH'
            ],
            [
                'query',
                'SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100',
            ],
            [
                'schemaUpdateOptions',
                ['ALLOW_FIELD_ADDITION']
            ],
            [
                'tableDefinitions',
                [
                    'autodetect' => true,
                    'sourceUris' => [
                        'gs://my_bucket/table.json'
                    ]
                ]
            ],
            [
                'timePartitioning',
                ['type' => 'DAY']
            ],
            [
                'rangePartitioning',
                ['field' => 'myInt','range' => ['start' => '0','end' => '1000','interval' => '100']]
            ],
            [
                'useLegacySql',
                true
            ],
            [
                'useQueryCache',
                true
            ],
            [
                'userDefinedFunctionResources',
                [['resourceUri' => 'gs://my_bucket/code_path']]
            ],
            [
                'writeDisposition',
                'WRITE_TRUNCATE'
            ]
        ];
    }
}
