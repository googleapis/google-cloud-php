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

use Google\Cloud\Bigtable\DataUtil;
use Google\Cloud\Bigtable\ReadModifyWriteRowRules;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ReadModifyWriteRowTest extends BigtableTestCase
{
    public static function set_up_before_class()
    {
        parent::set_up_before_class();
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
                        'value' => DataUtil::intToByteString(2),
                        'timeStamp' => 5000
                    ]
                ]
            ],
        ];
        self::$table->upsert($insertRows);
    }

    public function testAppend()
    {
        $rules = (new ReadModifyWriteRowRules)
            ->append('cf1', 'cq1', 'value12');
        $row = self::$table->readModifyWriteRow(
            'rk1',
            $rules
        );
        $this->assertEquals('value1value12', $row['cf1']['cq1'][0]['value']);
    }

    /**
     * @requires PHP 5.6.0
     */
    public function testIncrement()
    {
        $rules = (new ReadModifyWriteRowRules)
            ->increment('cf1', 'cq2', 3);
        $row = self::$table->readModifyWriteRow(
            'rk2',
            $rules
        );
        $intval = DataUtil::byteStringToInt($row['cf1']['cq2'][0]['value']);
        $this->assertEquals(5, $intval);
    }
}
