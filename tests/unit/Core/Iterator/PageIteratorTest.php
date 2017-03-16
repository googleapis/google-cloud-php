<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\Core\Iterator;

use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;

/**
 * @group core
 */
class PageIteratorTest extends \PHPUnit_Framework_TestCase
{
    private static $page1 = ['a', 'b', 'c'];
    private static $page2 = ['d', 'e', 'f'];

    public function testRewindsIterator()
    {
        $pages = new PageIterator(
            function ($result) {
                return $result;
            },
            [$this, 'theCall'],
            ['itemsKey' => 'items', 'multiPage' => true]
        );

        $page1BeforeRewind = iterator_to_array($pages)[0];
        $pages->rewind();
        $page1AfterRewind = iterator_to_array($pages)[0];

        $this->assertEquals($page1BeforeRewind, $page1AfterRewind);
    }

    /**
     * @dataProvider iteratorDataProvider
     */
    public function testIteratesData(array $options, array $iteratorOptions, $expected)
    {
        $pages = new PageIterator(
            function ($result) {
                return strtoupper($result);
            },
            [$this, 'theCall'],
            $options,
            $iteratorOptions
        );

        $pagesArray = iterator_to_array($pages);

        $this->assertEquals($expected, $pagesArray);
    }

    public function iteratorDataProvider()
    {
        return [
            [
                ['itemsKey' => 'items'],
                [],
                [array_map('strtoupper', self::$page1)]
            ],
            [
                ['itemsKey' => 'tests'],
                ['itemsKey' => 'tests'],
                [array_map('strtoupper', self::$page1)]
            ],
            [
                [
                    'itemsKey' => 'items',
                    'nextResultTokenKey' => 'nr',
                    'resultTokenKey' => 'r'
                ],
                [
                    'nextResultTokenKey' => 'nr',
                    'resultTokenKey' => 'r',
                    'firstPage' => [
                        'nr' => 'abc',
                        'items' => self::$page1
                    ]
                ],
                [
                    array_map('strtoupper', self::$page1),
                    array_map('strtoupper', self::$page2)
                ]
            ],
            [
                [
                    'itemsKey' => 'items',
                    'multiPage' => true
                ],
                [],
                [
                    array_map('strtoupper', self::$page1),
                    array_map('strtoupper', self::$page2)
                ]
            ],
            [
                [
                    'itemsKey' => 'items',
                    'multiPage' => true
                ],
                [
                    'setNextResultTokenCondition' => function () {
                        return false;
                    }
                ],
                [
                    array_map('strtoupper', self::$page1)
                ]
            ],
            [
                [
                    'itemsKey' => 'items',
                    'multiPage' => true
                ],
                ['resultLimit' => 4],
                [
                    array_map('strtoupper', self::$page1),
                    array_slice(array_map('strtoupper', self::$page2), 0, 1)
                ]
            ]
        ];
    }

    public function theCall(array $options)
    {
        $options += [
            'itemsKey' => 'items',
            'nextResultTokenKey' => 'nextPageToken',
            'resultTokenKey' => 'pageToken'
        ];

        if (isset($options[$options['resultTokenKey']])) {
            return [
                $options['itemsKey'] => self::$page2
            ];
        }

        if (isset($options['firstPage'])) {

        }

        if (isset($options['multiPage'])) {
            return [
                $options['itemsKey'] => self::$page1,
                $options['nextResultTokenKey'] => 'abc'
            ];
        }

        return [
            $options['itemsKey'] => self::$page1
        ];
    }
}
