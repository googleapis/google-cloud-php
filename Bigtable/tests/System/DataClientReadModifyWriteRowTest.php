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

namespace Google\Cloud\Bigtable\Tests\System;

use Google\Cloud\Bigtable\Tests\System\DataClientTest;
use Google\Cloud\Bigtable\ReadModifyWriteRowRules;

/**
 * @group bigtable
 * @group bigtabledata
 */
class DataClientReadModifyWriteRowTest extends DataClientTest
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        $insertRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 5000
                    ]
                ]
            ],
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        'value' => implode(unpack("C*", pack("J", 2))),
                        'timeStamp' => 5000
                    ]
                ]
            ],
        ];
        self::$dataClient->upsert($insertRows);
    }

    public function testAppend()
    {
        $rules = (new ReadModifyWriteRowRules)
            ->append('cf1', 'cq1', 'value12');
        $row = self::$dataClient->readModifyWriteRow(
            'rk1',
            $rules
        );
        $this->assertEquals('value1value12', $row['cf1']['cq1'][0]['value']);
    }

    public function testIncrement()
    {
        $rules = (new ReadModifyWriteRowRules)
            ->increment('cf1', 'cq2', 3);
        $row = self::$dataClient->readModifyWriteRow(
            'rk2',
            $rules
        );
        $intval = intval($row['cf1']['cq2'][0]['value']);
        $this->assertEquals(5, $intval);
    }
}
