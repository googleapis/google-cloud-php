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

use Google\Cloud\BigQuery\LoadJobConfiguration;
use Google\Cloud\BigQuery\Table;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class LoadJobConfigurationTest extends TestCase
{
    use ProphecyTrait;

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

    public function setUp(): void
    {
        $this->expectedConfig = [
            'projectId' => self::PROJECT_ID,
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ],
            'configuration' => [
                'load' => []
            ]
        ];
        $this->config = new LoadJobConfiguration(
            self::PROJECT_ID,
            ['jobReference' => ['jobId' => self::JOB_ID]],
            null
        );
    }

    public function testFluentSetters()
    {
        $destinationTable = $this->prophesize(Table::class);
        $destinationTable->identity()
            ->willReturn($this->tableIdentity);
        $data = '1234';
        $load = [
            'allowJaggedRows' => true,
            'allowQuotedNewlines' => true,
            'autodetect' => true,
            'clustering' => [
                'fields' => ['a', 'b', 'c']
            ],
            'createDisposition' => 'CREATE_NEVER',
            'destinationEncryptionConfiguration' => [
                'kmsKeyName' => 'my_key'
            ],
            'destinationTable' => $this->tableIdentity,
            'encoding' => 'UTF-8',
            'fieldDelimiter' => '\t',
            'ignoreUnknownValues' => true,
            'maxBadRecords' => 10,
            'nullMarker' => '\N',
            'projectionFields' => ['field_name'],
            'quote' => '"',
            'schema' => ['fields' => [['name' => 'col1', 'type' => 'STRING']]],
            'schemaUpdateOptions' => ['ALLOW_FIELD_ADDITION'],
            'skipLeadingRows' => 10,
            'sourceFormat' => 'CSV',
            'sourceUris' => ['gs://my_bucket/source.csv'],
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
            'writeDisposition' => 'WRITE_TRUNCATE',
            'useAvroLogicalTypes' => true,
            'createSession' => true,
            'connectionProperties' => [
                'key' => 'session_id',
                'value' => 'sessionId'
            ],
            'referenceFileSchemaUri' => 'gs://bucket/source.parquet'
        ];
        $this->expectedConfig['configuration']['load'] = $load
            + $this->expectedConfig['configuration']['load'];

        $config = $this->config
            ->allowJaggedRows($load['allowJaggedRows'])
            ->allowQuotedNewlines($load['allowQuotedNewlines'])
            ->autodetect($load['autodetect'])
            ->clustering($load['clustering'])
            ->createDisposition($load['createDisposition'])
            ->destinationEncryptionConfiguration($load['destinationEncryptionConfiguration'])
            ->data($data)
            ->destinationTable($destinationTable->reveal())
            ->encoding($load['encoding'])
            ->fieldDelimiter($load['fieldDelimiter'])
            ->ignoreUnknownValues($load['ignoreUnknownValues'])
            ->maxBadRecords($load['maxBadRecords'])
            ->nullMarker($load['nullMarker'])
            ->projectionFields($load['projectionFields'])
            ->quote($load['quote'])
            ->schema($load['schema'])
            ->schemaUpdateOptions($load['schemaUpdateOptions'])
            ->skipLeadingRows($load['skipLeadingRows'])
            ->sourceFormat($load['sourceFormat'])
            ->sourceUris($load['sourceUris'])
            ->timePartitioning($load['timePartitioning'])
            ->rangePartitioning($load['rangePartitioning'])
            ->writeDisposition($load['writeDisposition'])
            ->useAvroLogicalTypes($load['useAvroLogicalTypes'])
            ->createSession(true)
            ->connectionProperties([
                'key' => 'session_id',
                'value' =>'sessionId'
            ])
            ->referenceFileSchemaUri('gs://bucket/source.parquet');

        $this->assertInstanceOf(LoadJobConfiguration::class, $config);
        $this->assertEquals(
            $this->expectedConfig + ['data' => $data],
            $this->config->toArray()
        );
    }
}
