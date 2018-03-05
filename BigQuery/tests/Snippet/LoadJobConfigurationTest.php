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
use Google\Cloud\BigQuery\LoadJobConfiguration;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigquery
 */
class LoadJobConfigurationTest extends SnippetTestCase
{
    const PROJECT_ID = 'my_project';
    const DATASET_ID = 'my_dataset';
    const TABLE_ID = 'my_table';
    const JOB_ID = '123';

    private $config;

    public function setUp()
    {
        $this->config = new LoadJobConfiguration(
            self::PROJECT_ID,
            ['jobReference' => ['jobId' => self::JOB_ID]]
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(LoadJobConfiguration::class);
        $snippet->replace('fopen(\'/path/to/my/data.csv\', \'r\')', '123');
        $res = $snippet->invoke('loadJobConfig');

        $this->assertInstanceOf(LoadJobConfiguration::class, $res->returnVal());
    }

    public function testData()
    {
        $snippet = $this->snippetFromMethod(LoadJobConfiguration::class, 'data');
        $snippet->addLocal('loadJobConfig', $this->config);
        $snippet->replace('fopen(\'/path/to/my/data.csv\', \'r\')', '123');
        $res = $snippet->invoke('loadJobConfig');

        $this->assertEquals('123', $res->returnVal()->toArray()['data']);
    }

    /**
     * @dataProvider setterDataProvider
     */
    public function testSetters($method, $expected, $bq = null)
    {
        $snippet = $this->snippetFromMethod(LoadJobConfiguration::class, $method);
        $snippet->addLocal('loadJobConfig', $this->config);

        if ($bq) {
            $snippet->addLocal('bigQuery', $bq);
        }

        $actual = $snippet->invoke('loadJobConfig')
            ->returnVal()
            ->toArray()['configuration']['load'][$method];

        $this->assertEquals($expected, $actual);
    }

    public function setterDataProvider()
    {
        $bq = \Google\Cloud\Core\Testing\TestHelpers::stub(BigQueryClient::class, [
            ['projectId' => self::PROJECT_ID]
        ]);

        return [
            [
                'allowJaggedRows',
                true
            ],
            [
                'allowQuotedNewlines',
                true
            ],
            [
                'autodetect',
                true
            ],
            [
                'createDisposition',
                'CREATE_NEVER'
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
                'encoding',
                'UTF-8'
            ],
            [
                'fieldDelimiter',
                '\t'
            ],
            [
                'ignoreUnknownValues',
                true
            ],
            [
                'maxBadRecords',
                10
            ],
            [
                'nullMarker',
                '\N',
            ],
            [
                'projectionFields',
                ['field_name']
            ],
            [
                'quote',
                '"'
            ],
            [
                'schema',
                [
                    'fields' => [
                        [
                            'name' => 'col1',
                            'type' => 'STRING'
                        ],
                        [
                            'name' => 'col2',
                            'type' => 'BOOL'
                        ]
                    ]
                ]
            ],
            [
                'schemaUpdateOptions',
                ['ALLOW_FIELD_ADDITION']
            ],
            [
                'skipLeadingRows',
                10
            ],
            [
                'sourceFormat',
                'NEWLINE_DELIMITED_JSON'
            ],
            [
                'sourceUris',
                ['gs://my_bucket/source.csv']
            ],
            [
                'timePartitioning',
                ['type' => 'DAY']
            ],
            [
                'writeDisposition',
                'WRITE_TRUNCATE'
            ]
        ];
    }
}
