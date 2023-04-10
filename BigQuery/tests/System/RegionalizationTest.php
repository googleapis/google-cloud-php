<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

/**
 * @group bigquery
 * @group bigquery-regionalization
 */
class RegionalizationTest extends BigQueryTestCase
{
    const LOCATION_ASIA = 'asia-northeast1';
    const LOCATION_US = 'US';
    const QUERY_TEMPLATE = 'SELECT 1 FROM `%s.%s`';

    private static $datasetAsia;
    private static $tableAsia;
    private static $bucketAsia;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$datasetAsia = self::createDataset(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            ['location' => self::LOCATION_ASIA]
        );
        self::$tableAsia = self::createTable(
            self::$datasetAsia,
            uniqid(self::TESTING_PREFIX)
        );
        self::$bucketAsia = self::createBucket(
            self::$storageClient,
            uniqid(self::TESTING_PREFIX),
            ['location' => self::LOCATION_ASIA]
        );
    }

    public function testCopyJobSucceedsInAsia()
    {
        $targetTable = self::$datasetAsia
            ->table(uniqid(self::TESTING_PREFIX));
        $copyConfig = self::$tableAsia->copy($targetTable)
            ->location(self::LOCATION_ASIA);
        $results = self::$client->runJob($copyConfig);

        $this->assertArrayNotHasKey(
            'errorResult',
            $results->info()['status']
        );
        $this->assertEquals(
            self::$tableAsia->info()['location'],
            $targetTable->reload()['location']
        );
    }

    public function testCopyJobThrowsNotFoundExceptionInUS()
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $targetTable = self::$datasetAsia
            ->table(uniqid(self::TESTING_PREFIX));
        $copyConfig = self::$tableAsia->copy($targetTable)
            ->location(self::LOCATION_US);
        self::$client->runJob($copyConfig);
    }

    public function testExtractJobSucceedsInAsia()
    {
        $object = self::$bucketAsia->object(uniqid(self::TESTING_PREFIX));
        $extractConfig = self::$tableAsia->extract($object)
            ->destinationFormat('NEWLINE_DELIMITED_JSON')
            ->location(self::LOCATION_ASIA);
        $results = self::$client->runJob($extractConfig);

        $this->assertArrayNotHasKey(
            'errorResult',
            $results->info()['status']
        );
        $this->assertTrue($object->exists());
    }

    public function testExtractJobThrowsNotFoundExceptionInUS()
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $object = self::$bucketAsia->object(uniqid(self::TESTING_PREFIX));
        $extractConfig = self::$tableAsia->extract($object)
            ->destinationFormat('NEWLINE_DELIMITED_JSON')
            ->location(self::LOCATION_US);
        self::$client->runJob($extractConfig);
    }

    public function testLoadJobSucceedsInAsia()
    {
        $loadConfig = self::$tableAsia->load(
            file_get_contents(__DIR__ . '/data/table-data.json')
        )
            ->sourceFormat('NEWLINE_DELIMITED_JSON')
            ->location(self::LOCATION_ASIA);
        $results = self::$client->runJob($loadConfig);

        $this->assertArrayNotHasKey(
            'errorResult',
            $results->info()['status']
        );
        $this->assertEquals(3, (int) self::$tableAsia->reload()['numRows']);
    }

    public function testLoadJobThrowsNotFoundExceptionInUS()
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $loadConfig = self::$tableAsia->load(
            file_get_contents(__DIR__ . '/data/table-data.json')
        )
            ->sourceFormat('NEWLINE_DELIMITED_JSON')
            ->createDisposition('CREATE_NEVER')
            ->location(self::LOCATION_US);
        self::$client->runJob($loadConfig);
    }

    public function testRunQuerySucceedsInAsia()
    {
        $queryConfig = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location(self::LOCATION_ASIA);
        $results = self::$client->runQuery($queryConfig);

        $this->assertArrayNotHasKey(
            'errors',
            $results->info()
        );
        $this->assertEquals(3, (int) $results->info()['totalRows']);
    }

    public function testRunQueryThrowsNotFoundExceptionInUS()
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $queryConfig = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location(self::LOCATION_US);
        self::$client->runQuery($queryConfig);
    }

    public function testGetJobSucceedsInAsia()
    {
        $queryConfig = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location(self::LOCATION_ASIA);
        $job = self::$client->startQuery($queryConfig);

        $this->assertEquals(
            self::LOCATION_ASIA,
            self::$client->job($job->id(), [
                'location' => self::LOCATION_ASIA
            ])->reload()['jobReference']['location']
        );
    }

    public function testGetJobThrowsNotFoundExceptionInUS()
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $queryConfig = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location(self::LOCATION_ASIA);
        $job = self::$client->startQuery($queryConfig);

        self::$client->job($job->id(), [
            'location' => self::LOCATION_US
        ])->reload();
    }

    public function testCancelJobSucceedsInAsia()
    {
        $queryConfig = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location(self::LOCATION_ASIA);
        $job = self::$client->startQuery($queryConfig);

        $this->assertNull(
            self::$client->job($job->id(), [
                'location' => self::LOCATION_ASIA
            ])->cancel()
        );
    }

    public function testCancelJobThrowsNotFoundExceptionInUS()
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $queryConfig = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location(self::LOCATION_ASIA);
        $job = self::$client->startQuery($queryConfig);

        self::$client->job($job->id(), [
            'location' => self::LOCATION_US
        ])->cancel();
    }
}
