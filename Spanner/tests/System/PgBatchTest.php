<?php
/**
 * Copyright 2023 Google Inc.
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

use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Google\Cloud\Core\Exception\ServiceException;

/**
 * @group spanner
 * @group spanner-batch
 * @group spanner-postgres
 */
class PgBatchTest extends SpannerPgTestCase
{
    use DatabaseRoleTrait;

    private static $tableName;
    private static $isSetup = false;

    public static function setUpBeforeClass(): void
    {
        if (self::$isSetup) {
            return;
        }
        parent::setUpBeforeClass();

        self::$tableName = uniqid(self::TESTING_PREFIX);

        self::$database->updateDdl(sprintf(
            'CREATE TABLE %s (
                    id INTEGER PRIMARY KEY,
                    decade INTEGER NOT NULL
                )',
            self::$tableName
        ))->pollUntilComplete();

        if (self::$database->info()['databaseDialect'] == DatabaseDialect::POSTGRESQL) {
            self::$database->updateDdlBatch([
                sprintf(
                    'CREATE ROLE %s',
                    self::$dbRole
                ),
                sprintf(
                    'CREATE ROLE %s',
                    self::$restrictiveDbRole
                ),
                sprintf(
                    'GRANT SELECT(id) ON TABLE %s TO %s',
                    self::$tableName,
                    self::$restrictiveDbRole
                ),
                sprintf(
                    'GRANT SELECT ON TABLE %s TO %s',
                    self::$tableName,
                    self::$dbRole
                )
            ])->pollUntilComplete();
        }

        self::seedTable();
        self::$isSetup = true;
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
                FROM ' . self::$tableName . '
                WHERE
                    decade > $1
                AND
                    decade < $2';

        $parameters = [
            'p1' => 1960,
            'p2' => 1980
        ];

        $resultSet = iterator_to_array(self::$database->execute($query, ['parameters' => $parameters]));

        $batch = self::$client->batch(self::INSTANCE_NAME, self::$dbName, ['databaseRole' => $dbRole]);
        $serializedSnapshot = $batch->snapshot()->serialize();

        $snapshot = $batch->snapshotFromString($serializedSnapshot);

        try {
            $partitions = $snapshot->partitionQuery($query, ['parameters' => $parameters]);
        } catch (ServiceException $e) {
            $error = $e;
        }

        if ($expected === null) {
            $this->assertEquals(count($resultSet), $this->executePartitions($batch, $snapshot, $partitions));
        } else {
            $this->assertEquals($error->getServiceException()->getStatus(), $expected);
        }
        $snapshot->close();
    }

    private function executePartitions(BatchClient $client, BatchSnapshot $snapshot, array $partitions)
    {
        $partitionResultSet = [];
        foreach ($partitions as $partition) {
            $serializedPartition = $partition->serialize();

            $partitionObject = $client->partitionFromString($serializedPartition);
            $partitionResultSet += iterator_to_array($snapshot->executePartition($partitionObject));
        }

        return count($partitionResultSet);
    }

    private static function seedTable()
    {
        $decades = [1950,1960,1970,1980,1990,2000];
        for ($i = 0; $i < 250; $i++) {
            self::$database->insert(self::$tableName, [
                'id' => self::randId(),
                'decade' => array_rand($decades)
            ], [
                'timeoutMillis' => 50000
            ]);
        }
    }
}
