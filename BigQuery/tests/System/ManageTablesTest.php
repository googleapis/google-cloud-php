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

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\Core\ExponentialBackoff;

/**
 * @group bigquery
 * @group bigquery-table
 */
class ManageTablesTest extends BigQueryTestCase
{
    public function testListTables()
    {
        $foundTables = [];
        $tablesToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($tablesToCreate as $tableToCreate) {
            self::$dataset->createTable($tableToCreate);
        }

        $tables = self::$dataset->tables();

        foreach ($tables as $table) {
            foreach ($tablesToCreate as $key => $tableToCreate) {
                if ($table->id() === $tableToCreate) {
                    $foundTables[$key] = $table->id();
                }
            }
        }

        $this->assertEquals($tablesToCreate, $foundTables);
    }

    public function testCreatesTable()
    {
        $id = uniqid(self::TESTING_PREFIX);
        $options = [
            'friendlyName' => 'Test',
            'description' => 'Test'
        ];
        $this->assertFalse(self::$dataset->table($id)->exists());

        $table = self::$dataset->createTable($id, $options);

        $this->assertTrue(self::$dataset->table($id)->exists());
        $this->assertEquals($id, $table->id());
        $this->assertEquals($options['friendlyName'], $table->info()['friendlyName']);
        $this->assertEquals($options['description'], $table->info()['description']);

        return $table;
    }

    /**
     * @depends testCreatesTable
     */
    public function testCopiesTable($table)
    {
        $copyJobConfig = self::$table->copy($table);
        $this->runJob($copyJobConfig);
    }

    public function testCreatesTableWithRangePartitioning()
    {
        $id = uniqid(self::TESTING_PREFIX);
        $options = [
            'friendlyName' => 'Test',
            'description' => 'Test',
            'rangePartitioning' => [
                'field' => 'myInt',
                'range' => [
                    'start' => '0',
                    'end' => '1000',
                    'interval' => '100'
                ]
            ],
            'schema' => [
                'fields' => [
                    [
                        'name' => 'myInt',
                        'type' => 'INT64'
                    ]
                ]
            ]
        ];
        $table = self::$dataset->createTable($id, $options);

        $this->assertTrue(self::$dataset->table($id)->exists());
        $this->assertEquals($id, $table->id());
        $this->assertEquals($table->info()['rangePartitioning'], $options['rangePartitioning']);
    }

    public function testExtractsTable()
    {
        $object = self::$bucket->object(
            uniqid(self::TESTING_PREFIX)
        );
        self::$deletionQueue->add($object);

        $extractJobConfig = self::$table->extract($object)
            ->destinationFormat('NEWLINE_DELIMITED_JSON');
        $this->runJob($extractJobConfig);
    }

    public function testUpdateTable()
    {
        $metadata = [
            'friendlyName' => 'Test'
        ];
        $info = self::$table->update($metadata);

        $this->assertEquals($metadata['friendlyName'], $info['friendlyName']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\FailedPreconditionException
     */
    public function testUpdateTableConcurrentUpdateFails()
    {
        $data = [
            'friendlyName' => 'foo',
            'etag' => 'blah'
        ];

        self::$table->update($data);
    }

    public function testReloadsTable()
    {
        $this->assertEquals('bigquery#table', self::$table->reload()['kind']);
    }

    public function testCreatesExternalTable()
    {
        $externalKeyFilePath = getenv('GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH');
        $authenticatedKeyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $externalKey = json_decode(file_get_contents($externalKeyFilePath), true);
        $authenticatedKey = json_decode(file_get_contents($authenticatedKeyFilePath), true);
        $externalProjectId = $externalKey['project_id'];
        $externalUser = $externalKey['client_email'];
        $authenticatedUser = $authenticatedKey['client_email'];
        if ($externalProjectId == self::$dataset->identity()['projectId']) {
            $this->markTestSkipped('Need two different projects to run this test.');
        }

        $externalClient = new BigQueryClient([
            'keyFile' => $externalKey,
        ]);
        $externalDataset = self::createDataset($externalClient, uniqid(self::TESTING_PREFIX), [
            'access' => [
                [
                    'role' => 'roles/bigquery.dataOwner',
                    'userByEmail' => $authenticatedUser
                ], [
                    'role' => 'roles/bigquery.dataOwner',
                    'userByEmail' => $externalUser
                ]
            ]
        ]);
        $externalTable = self::createTable($externalDataset, uniqid(self::TESTING_PREFIX));

        $jobConfig = $externalClient->load()
            ->destinationTable($externalTable)
            ->data(file_get_contents(__DIR__ . '/data/table-data.json'))
            ->sourceFormat('NEWLINE_DELIMITED_JSON');
        $this->runJob($jobConfig, $externalClient);

        return $externalTable;
    }

    /**
     * @depends testCreatesExternalTable
     * @param Table $externalTable
     */
    public function testLoadsExternalTable(Table $externalTable)
    {
        $loadJobConfig = self::$client->load()
            ->destinationTable($externalTable)
            ->data(file_get_contents(__DIR__ . '/data/table-data.json'))
            ->sourceFormat('NEWLINE_DELIMITED_JSON');
        $this->runJob($loadJobConfig);
    }

    /**
     * @depends testCreatesExternalTable
     * @param Table $externalTable
     */
    public function testExtractsExternalTable(Table $externalTable)
    {
        $this->markTestSkipped("does not work with schema");
        $object = self::$bucket->object(uniqid(self::TESTING_PREFIX));
        $extractJobConfig = self::$client->extract()
            ->sourceTable($externalTable)
            ->destinationUris([$object->gcsUri()]);
        $this->runJob($extractJobConfig);
    }

    /**
     * @depends testCreatesExternalTable
     * @param Table $externalTable
     */
    public function testCopiesExternalTable(Table $externalTable)
    {
        $table = self::createTable(self::$dataset, uniqid(self::TESTING_PREFIX));
        $copyJobConfig = self::$client->copy()
            ->sourceTable($externalTable)
            ->destinationTable($table);
        $this->runJob($copyJobConfig);
    }

    public function testIam()
    {
        $table = self::createTable(self::$dataset, uniqid(self::TESTING_PREFIX));
        $iam = $table->iam();

        $policy = [
            'bindings' => [
                [
                    'role' => 'roles/bigquery.admin',
                    'members' => [
                        'user:gcloud.php.tests@gmail.com'
                    ]
                ]
            ]
        ];
        $iam->setPolicy($policy);
        $actualPolicy = $iam->reload();

        $this->assertEquals($actualPolicy, $iam->policy());
        $this->assertEquals($policy['bindings'][0], $actualPolicy['bindings'][0]);

        $perm = 'bigquery.tables.get';
        $this->assertEquals([$perm], $iam->testPermissions([$perm]));
    }

    private function runJob($jobConfig, $client = null)
    {
        if (!isset($client)) {
            $client = self::$client;
        }
        $job = $client->startJob($jobConfig);
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

        $this->assertArrayNotHasKey('errorResult', $job->info()['status']);
    }
}
