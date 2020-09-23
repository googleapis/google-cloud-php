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
use Google\Cloud\BigQuery\ExtractJobConfiguration;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;

/**
 * @group bigquery
 */
class ExtractJobConfigurationTest extends SnippetTestCase
{
    const PROJECT_ID = 'my_project';
    const DATASET_ID = 'my_dataset';
    const TABLE_ID = 'my_table';
    const MODEL_ID = 'my_model';
    const JOB_ID = '123';

    private $config;

    public function setUp()
    {
        $this->config = new ExtractJobConfiguration(
            self::PROJECT_ID,
            ['jobReference' => ['jobId' => self::JOB_ID]],
            null
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(ExtractJobConfiguration::class);
        $res = $snippet->invoke('extractJobConfig');

        $this->assertInstanceOf(ExtractJobConfiguration::class, $res->returnVal());
    }

    /**
     * @dataProvider setterDataProvider
     */
    public function testSetters($method, $expected, $bq = null)
    {
        $snippet = $this->snippetFromMethod(ExtractJobConfiguration::class, $method);
        $snippet->addLocal('extractJobConfig', $this->config);

        if ($bq) {
            $snippet->addLocal('bigQuery', $bq);
        }

        $actual = $snippet->invoke('extractJobConfig')
            ->returnVal()
            ->toArray()['configuration']['extract'][$method];

        $this->assertEquals($expected, $actual);
    }

    public function setterDataProvider()
    {
        $bq = TestHelpers::stub(BigQueryClient::class, [
            ['projectId' => self::PROJECT_ID]
        ]);

        return [
            [
                'compression',
                'GZIP'
            ],
            [
                'destinationFormat',
                'NEWLINE_DELIMITED_JSON'
            ],
            [
                'destinationUris',
                ['gs://my_bucket/destination.csv']
            ],
            [
                'fieldDelimiter',
                ','
            ],
            [
                'printHeader',
                false
            ],
            [
                'sourceTable',
                [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => self::DATASET_ID,
                    'tableId' => self::TABLE_ID
                ],
                $bq
            ],
            [
                'sourceModel',
                [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => self::DATASET_ID,
                    'modelId' => self::MODEL_ID
                ],
                $bq
            ],
            [
                'useAvroLogicalTypes',
                true
            ]
        ];
    }
}
