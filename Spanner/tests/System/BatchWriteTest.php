<?php
/**
 * Copyright 2024 Google Inc.
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

use Google\Rpc\Code;

/**
 * @group spanner
 */
class BatchWriteTest extends SpannerTestCase
{
    const TABLE_NAME = 'BatchWrites';
    public static function setUpBeforeClass(): void
    {
        self::skipEmulatorTests();
        parent::setUpBeforeClass();

        self::$database->updateDdlBatch([
            'CREATE TABLE Singers (
                SingerId   INT64 NOT NULL,
                FirstName  STRING(1024),
                LastName   STRING(1024),
            ) PRIMARY KEY (SingerId)',
            'CREATE TABLE Albums (
                SingerId     INT64 NOT NULL,
                AlbumId      INT64 NOT NULL,
                AlbumTitle   STRING(1024),
            ) PRIMARY KEY (SingerId, AlbumId),
            INTERLEAVE IN PARENT Singers ON DELETE CASCADE'
        ])->pollUntilComplete();
    }

    public function testBatchWrite()
    {
        $mutationGroups = [];
        $mutationGroups[] = self::$database->mutationGroup()
            ->insertOrUpdate(
                "Singers",
                ['SingerId' => 16, 'FirstName' => 'Scarlet', 'LastName' => 'Terry']
            );

        $mutationGroups[] = self::$database->mutationGroup()
            ->insertOrUpdate(
                "Singers",
                ['SingerId' => 17, 'FirstName' => 'Marc', 'LastName' => 'Kristen']
            )->insertOrUpdate(
                "Albums",
                ['AlbumId' => 1, 'SingerId' => 17, 'AlbumTitle' => 'Total Junk']
            );

        $result = self::$database->batchWrite($mutationGroups)->current();
        $this->assertEquals($result['indexes'], [0 => 0, 1 => 1]);
        $this->assertEquals($result['status']['code'], Code::OK);
        $this->assertStringEndsWith('Z', $result['commitTimestamp']);
    }
}
