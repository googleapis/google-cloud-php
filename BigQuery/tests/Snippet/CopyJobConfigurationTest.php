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
use Google\Cloud\BigQuery\CopyJobConfiguration;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;

/**
 * @group bigquery
 */
class CopyJobConfigurationTest extends SnippetTestCase
{
    const PROJECT_ID = 'my_project';
    const DATASET_ID = 'my_dataset';
    const TABLE_ID = 'my_table';
    const JOB_ID = '123';

    private $config;

    public function set_up()
    {
        $this->config = new CopyJobConfiguration(
            self::PROJECT_ID,
            ['jobReference' => ['jobId' => self::JOB_ID]],
            null
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(CopyJobConfiguration::class);
        $res = $snippet->invoke('copyJobConfig');

        $this->assertInstanceOf(CopyJobConfiguration::class, $res->returnVal());
    }

    /**
     * @dataProvider setterDataProvider
     */
    public function testSetters($method, $expected, $bq = null)
    {
        $snippet = $this->snippetFromMethod(CopyJobConfiguration::class, $method);
        $snippet->addLocal('copyJobConfig', $this->config);

        if ($bq) {
            $snippet->addLocal('bigQuery', $bq);
        }

        $actual = $snippet->invoke('copyJobConfig')
            ->returnVal()
            ->toArray()['configuration']['copy'][$method];

        $this->assertEquals($expected, $actual);
    }

    public function setterDataProvider()
    {
        $bq = TestHelpers::stub(BigQueryClient::class, [
            ['projectId' => self::PROJECT_ID]
        ]);

        return [
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
                'sourceTable',
                [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => self::DATASET_ID,
                    'tableId' => 'source_table'
                ],
                $bq
            ],
            [
                'writeDisposition',
                'WRITE_TRUNCATE'
            ]
        ];
    }
}
