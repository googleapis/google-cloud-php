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

use Google\Cloud\BigQuery\ExtractJobConfiguration;
use Google\Cloud\BigQuery\Table;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 */
class ExtractJobConfigurationTest extends TestCase
{
    const PROJECT_ID = 'my_project';
    const DATASET_ID = 'my_dataset';
    const TABLE_ID = 'my_table';
    const JOB_ID = '1234';

    private $config;
    private $tableIdentity = [
        'projectId' => self::PROJECT_ID,
        'datasetId' => self::DATASET_ID,
        'tableId' => self::TABLE_ID
    ];
    private $expectedConfig;

    public function setUp()
    {
        $this->expectedConfig = [
            'projectId' => self::PROJECT_ID,
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ],
            'configuration' => [
                'extract' => []
            ]
        ];
        $this->config = new ExtractJobConfiguration(
            self::PROJECT_ID,
            ['jobReference' => ['jobId' => self::JOB_ID]],
            null
        );
    }

    public function testFluentSetters()
    {
        $sourceTable = $this->prophesize(Table::class);
        $sourceTable->identity()
            ->willReturn($this->tableIdentity);
        $extract = [
            'compression' => 'GZIP',
            'destinationFormat' => 'CSV',
            'destinationUris' => ['gs://my_bucket/destination.csv'],
            'fieldDelimiter' => ',',
            'printHeader' => true,
            'sourceTable' => $this->tableIdentity,
            'useAvroLogicalTypes' => true
        ];
        $this->expectedConfig['configuration']['extract'] = $extract
            + $this->expectedConfig['configuration']['extract'];
        $this->config
            ->compression($extract['compression'])
            ->destinationFormat($extract['destinationFormat'])
            ->destinationUris($extract['destinationUris'])
            ->fieldDelimiter($extract['fieldDelimiter'])
            ->printHeader($extract['printHeader'])
            ->sourceTable($sourceTable->reveal())
            ->useAvroLogicalTypes($extract['useAvroLogicalTypes']);

        $this->assertEquals(
            $this->expectedConfig,
            $this->config->toArray()
        );
    }
}
