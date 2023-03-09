<?php
/**
 * Copyright 2022 Google Inc.
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

use Google\Cloud\Spanner\Tests\System\SpannerPgTestCase;

/**
 * @group spanner
 * @group spanner-pdml
 * @group spanner-postgres
 */
class PgPartitionedDmlTest extends SpannerPgTestCase
{
    const PDML_TABLE = 'partitionedDml';

    public function testPdml()
    {
        $db = self::$database;

        $db->updateDdl('CREATE TABLE ' . self::PDML_TABLE . '(
            id bigint NOT NULL,
            stringField varchar(1024),
            boolField BOOL,
            PRIMARY KEY(id)
        )')->pollUntilComplete();

        $this->seedTable();

        $opts = [
            'parameters' => [
                'p1' => 'b',
            ]
        ];

        $db->executePartitionedUpdate('UPDATE ' . self::PDML_TABLE . '
            SET stringField = $1
            WHERE boolField IS NULL', $opts);

        $res = $db->execute('SELECT id FROM ' . self::PDML_TABLE . ' WHERE stringField != $1', $opts);

        $this->assertCount(0, iterator_to_array($res));
    }

    private function seedTable()
    {
        $rows = [];
        for ($i = 0; $i <= 1000; $i++) {
            $rows[] = [
                'id' => $i,
                'stringField' => 'a'
            ];

            // split the operation into several RPCs.
            if ($i > 0 && $i % 100 === 0) {
                $this->executeInsert($rows);
                $rows = [];
            }
        }

        if ($rows) {
            $this->executeInsert($rows);
        }
    }

    private function executeInsert(array $rows)
    {
        self::$database->runTransaction(function ($t) use ($rows) {
            $t->insertBatch(self::PDML_TABLE, $rows);

            $t->commit();
        });
    }
}
