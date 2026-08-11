<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\System;

use Google\ApiCore\ApiException;

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\KeySet;
use Google\Rpc\Code;

/**
 * @group spanner
 * @group spanner-batch
 */
class BatchTest extends SystemTestCase
{
    const TABLE_NAME = 'BatchTest';
    use SystemTestCaseTrait;
    use DatabaseRoleTrait;

    
    private static $isSetup = false;

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        self::setUpTestDatabase();
        if (self::$isSetup) {
            return;
        }
        self::$database->delete(self::TABLE_NAME, new KeySet(['all' => true]));
        self::seedTable();
        self::$isSetup = true;
    }

    private static function seedTable()
    {
        $decades = [1950, 1960, 1970, 1980, 1990, 2000];
        $mutations = [];

        for ($i = 0; $i < 250; $i++) {
            $mutations[] = [
                'id' => self::randId(),
                'decade' => $decades[array_rand($decades)]
            ];
        }

        self::$database->insertOrUpdateBatch(
            self::TABLE_NAME,
            $mutations,
            ['timeoutMillis' => 50000]
        );
    }

    public function testBatch()
    {
        $query = 'SELECT
                id,
                decade
            FROM ' . self::TABLE_NAME . '
            WHERE
                decade > @earlyBound
            AND
                decade < @lateBound';

        $parameters = [
            'earlyBound' => 1960,
            'lateBound' => 1980
        ];

        $resultSet = iterator_to_array(self::$database->execute($query, ['parameters' => $parameters]));

        $batch = self::$client->batch(self::INSTANCE_NAME, self::$dbName);
        $string = $batch->snapshot()->serialize();

        $snapshot = $batch->snapshotFromString($string);

        $partitions = null;
        for ($i = 0; $i < 3; $i++) {
            try {
                $partitions = $snapshot->partitionQuery($query, ['parameters' => $parameters]);
                break;
            } catch (ServiceException | ApiException $ex) {
                $allowed = [Code::UNAVAILABLE, Code::DEADLINE_EXCEEDED];
                if ($i === 2 || !in_array($ex->getCode(), $allowed)) {
                    throw $ex;
                }
                sleep(2);
            }
        }
        $this->assertEquals(count($resultSet), $this->executePartitions($batch, $snapshot, $partitions));

        $keySet = new KeySet(['all' => true]);

        $partitions = $snapshot->partitionRead(self::TABLE_NAME, $keySet, ['id', 'decade']);
        $this->assertEquals(250, $this->executePartitions($batch, $snapshot, $partitions));
    }

    /**
     * @dataProvider dbProvider
     */
    public function testBatchWithDbRole($dbRole, $expected)
    {
        // Emulator does not support FGAC
        $this->skipEmulatorTests();
        $error = null;
        $query = 'SELECT
                    id,
                    decade
                FROM ' . self::TABLE_NAME . '
                WHERE
                    decade > @earlyBound
                AND
                    decade < @lateBound';

        $parameters = [
            'earlyBound' => 1960,
            'lateBound' => 1980
        ];

        $resultSet = iterator_to_array(self::$database->execute($query, ['parameters' => $parameters]));

        $batch = self::$client->batch(self::INSTANCE_NAME, self::$dbName, ['databaseRole' => $dbRole]);
        $string = $batch->snapshot()->serialize();

        $snapshot = $batch->snapshotFromString($string);

        try {
            $partitions = $snapshot->partitionQuery($query, ['parameters' => $parameters]);
        } catch (ServiceException $e) {
            if (is_null($expected)) {
                throw $e;
            }
            $error = $e;
        }

        if ($expected === null) {
            $this->assertEquals(count($resultSet), $this->executePartitions($batch, $snapshot, $partitions));
        } else {
            $this->assertEquals($error->getServiceException()->getStatus(), $expected);
        }
    }

    private function executePartitions(BatchClient $client, BatchSnapshot $snapshot, array $partitions)
    {
        $partitionResultSet = [];
        foreach ($partitions as $partition) {
            $string = $partition->serialize();

            $hydrated = $client->partitionFromString($string);
            $partitionResultSet += iterator_to_array($snapshot->executePartition($hydrated));
        }

        return count($partitionResultSet);
    }
}
