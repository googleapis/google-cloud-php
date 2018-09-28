<?php
/**
 * Copyright 2018 Google LLC.
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

/**
 * @group bigtable
 * @group bigtabledata
 */
class FilterTest extends DataClientTest
{
    protected static $insertRows;
    protected static $expectedRows = [];
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$insertRows = [
            'rk0' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk1' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk2' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk3' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk4' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk5' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk6' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk7' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk8' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
            'rk9' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf1' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf2' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf3' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf4' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf5' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf6' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf7' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf8' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
                'cf9' => [
                    'cq0' => [
                        'value' => 'value0',
                        'timeStamp' => 1000
                    ],
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 2000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 3000
                    ],
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 4000
                    ],
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ],
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 6000
                    ],
                    'cq6' => [
                        'value' => 'value6',
                        'timeStamp' => 7000
                    ],
                    'cq7' => [
                        'value' => 'value7',
                        'timeStamp' => 8000
                    ],
                    'cq8' => [
                        'value' => 'value8',
                        'timeStamp' => 9000
                    ],
                    'cq9' => [
                        'value' => 'value9',
                        'timeStamp' => 10000
                    ],
                ],
            ],
        ];
        self::createExpectedRows();
        self::$dataClient->upsert(self::$insertRows);
    }

    private static function createExpectedRows()
    {
        self::$expectedRows = self::$insertRows;
        foreach (self::$expectedRows as &$row) {
            foreach ($row as &$family) {
                foreach ($family as &$qualifier) {
                    $qualifier['labels'] = '';
                    $qualifier = [$qualifier];
                }
            }
        }
    }
}
