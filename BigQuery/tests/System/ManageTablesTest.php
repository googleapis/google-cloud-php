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
        $job = self::$table->startJob($copyJobConfig);
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

    public function testExtractsTable()
    {
        $object = self::$bucket->object(
            uniqid(self::TESTING_PREFIX)
        );

        $extractJobConfig = self::$table->extract($object)
            ->destinationFormat('NEWLINE_DELIMITED_JSON');
        $job = self::$table->startJob($extractJobConfig);

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
}
