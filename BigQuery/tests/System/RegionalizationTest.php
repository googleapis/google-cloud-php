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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;

/**
 * @group bigquery
 * @group bigquery-regionalization
 */
class RegionalizationTest extends BigQueryTestCase
{
    const REGION_ASIA = 'asia-northeast1';
    const REGION_US = 'US';
    const QUERY_TEMPLATE = 'SELECT 1 FROM `%s.%s`';

    private static $datasetAsia;
    private static $tableAsia;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$datasetAsia = self::createDataset(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            ['location' => self::REGION_ASIA]
        );
        self::$tableAsia = self::createTable(
            self::$datasetAsia,
            uniqid(self::TESTING_PREFIX)
        );
    }

    /**
     * @dataProvider locationDataProvider
     */
    public function testRunQuery($location)
    {
        $caught = false;
        $query = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location($location);

        try {
            self::$client->runQuery($query);
        } catch (NotFoundException $e) {
            $caught = true;
        }

        $this->assertExceptionShouldBeThrown($location, $caught);
    }

    /**
     * @dataProvider locationDataProvider
     */
    public function testRunCopyJob($location)
    {
        $caught = false;
        $copyTable = self::$dataset->table(self::TESTING_PREFIX);
        $copy = self::$tableAsia->copy($copyTable)
            ->location($location);

        try {
            self::$tableAsia->startJob($copy);
            self::$deletionQueue->add($copyTable);
        } catch (NotFoundException $e) {
            $caught = true;
        } catch (ServiceException $e) {
            // Swallow this, as the important bit is whether or not
            // we get a 404.
        }

        $this->assertExceptionShouldBeThrown($location, $caught);
    }

    /**
     * @dataProvider locationDataProvider
     */
    public function testRunExtractJob($location)
    {
        $caught = false;
        $extract = self::$tableAsia->extract(
            self::$bucket->object(self::TESTING_PREFIX)
        )->location($location);

        try {
            self::$tableAsia->startJob($extract);
        } catch (NotFoundException $e) {
            $caught = true;
        }

        $this->assertExceptionShouldBeThrown($location, $caught);
    }

    /**
     * @dataProvider locationDataProvider
     */
    public function testRunLoadJob($location)
    {
        $caught = false;
        $load = self::$tableAsia->load(
            file_get_contents(__DIR__ . '/data/table-data.json')
        )
            ->sourceFormat('NEWLINE_DELIMITED_JSON')
            ->location($location);

        try {
            self::$tableAsia->startJob($load);
        }catch (ServiceException $e) {
            $code = $e->getCode();
            if ($code === 403 || $code === 404) {
                $caught = true;
            }
        }

        $this->assertExceptionShouldBeThrown($location, $caught);
    }

    /**
     * @dataProvider locationDataProvider
     */
    public function testGetsJob($location)
    {
        $caught = false;
        $query = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location(self::REGION_ASIA);
        $job = self::$client->startQuery($query);

        try {
            self::$client->job($job->id(), [
                'location' => $location
            ])->reload();
        }catch (NotFoundException $e) {
            $caught = true;
        }

        $this->assertExceptionShouldBeThrown($location, $caught);
    }

    /**
     * @dataProvider locationDataProvider
     */
    public function testCancelsJob($location)
    {
        $caught = false;
        $query = self::$client->query(
            sprintf(
                self::QUERY_TEMPLATE,
                self::$datasetAsia->id(),
                self::$tableAsia->id()
            )
        )->location(self::REGION_ASIA);
        $job = self::$client->startQuery($query);

        try {
            self::$client->job($job->id(), [
                'location' => $location
            ])->cancel();
        }catch (NotFoundException $e) {
            $caught = true;
        }

        $this->assertExceptionShouldBeThrown($location, $caught);
    }

    public function locationDataProvider()
    {
        return [
            [self::REGION_ASIA],
            [self::REGION_US]
        ];
    }

    private function assertExceptionShouldBeThrown($location, $caught)
    {
        if ($location === self::REGION_ASIA) {
            $this->assertFalse($caught);
        } else {
            $this->assertTrue($caught);
        }
    }
}
