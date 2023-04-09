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

use Google\Cloud\BigQuery\CopyJobConfiguration;
use Google\Cloud\BigQuery\Table;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class CopyJobConfigurationTest extends TestCase
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
                'copy' => []
            ]
        ];
        $this->config = new CopyJobConfiguration(
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
        $sourceTable = $this->prophesize(Table::class);
        $sourceTable->identity()
            ->willReturn($this->tableIdentity);
        $copy = [
            'createDisposition' => 'CREATE_NEVER',
            'destinationEncryptionConfiguration' => [
                'kmsKeyName' => 'my_key'
            ],
            'destinationTable' => $this->tableIdentity,
            'sourceTable' => $this->tableIdentity,
            'writeDisposition' => 'WRITE_TRUNCATE'
        ];
        $this->expectedConfig['configuration']['copy'] = $copy
            + $this->expectedConfig['configuration']['copy'];

        $config = $this->config
            ->createDisposition($copy['createDisposition'])
            ->destinationEncryptionConfiguration($copy['destinationEncryptionConfiguration'])
            ->destinationTable($destinationTable->reveal())
            ->sourceTable($sourceTable->reveal())
            ->writeDisposition($copy['writeDisposition']);

        $this->assertInstanceOf(CopyJobConfiguration::class, $config);
        $this->assertEquals(
            $this->expectedConfig,
            $this->config->toArray()
        );
    }
}
