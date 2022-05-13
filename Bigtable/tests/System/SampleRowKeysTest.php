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

/**
 * @group bigtable
 * @group bigtabledata
 */
class SampleRowKeysTest extends BigtableTestCase
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
                        'value' => 'value2',
                        'timeStamp' => 5000
                    ]
                ]
            ],
            'rk3' => [
                'cf1' => [
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 5000
                    ]
                ]
            ],
            'rk4' => [
                'cf1' => [
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ]
                ]
            ],
            'rk5' => [
                'cf1' => [
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 5000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
    }

    public function testSampleRowKeys()
    {
        self::skipIfEmulatorUsed('Cannot rely on SampleRowKeys result returned by emulator.');

        $rowKeysStream = self::$table->sampleRowKeys();
        $rowKeys = iterator_to_array($rowKeysStream);
        $expectedRowKeys = [
            [
                'rowKey' => '',
                'offset' => 805306368
            ]
        ];
        $this->assertEquals($expectedRowKeys, $rowKeys);
    }
}
