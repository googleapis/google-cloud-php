<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Storage\Tests\Unit;

use Google\Cloud\Storage\Lifecycle;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group storage
 * @group storage-lifecycle
 */
class LifecycleTest extends TestCase
{
    use ExpectException;

    private $lifecycle;
    private static $condition = [
        'age' => 50
    ];

    public function set_up()
    {
        $this->lifecycle = new Lifecycle;
    }

    public function testAddDeleteRule()
    {
        $expected = [
            'rule' => [
                [
                    'action' => [
                        'type' => 'Delete'
                    ],
                    'condition' => self::$condition
                ]
            ]
        ];

        $this->assertInstanceOf(
            Lifecycle::class,
            $this->lifecycle->addDeleteRule(self::$condition)
        );
        $this->assertEquals($expected, $this->lifecycle->toArray());
    }

    public function testAddStorageClassRule()
    {
        $storageClass = 'NEARLINE';
        $expected = [
            'rule' => [
                [
                    'action' => [
                        'type' => 'SetStorageClass',
                        'storageClass' => $storageClass
                    ],
                    'condition' => self::$condition
                ]
            ]
        ];

        $this->assertInstanceOf(
            Lifecycle::class,
            $this->lifecycle->addSetStorageClassRule($storageClass, self::$condition)
        );
        $this->assertEquals($expected, $this->lifecycle->toArray());
    }

    public function testClearRules()
    {
        $this->lifecycle
            ->addDeleteRule(self::$condition)
            ->addDeleteRule(self::$condition);

        $this->assertCount(
            2,
            $this->lifecycle->toArray()['rule']
        );

        $this->assertInstanceOf(
            Lifecycle::class,
            $this->lifecycle->clearRules()
        );
        $this->assertEmpty(
            $this->lifecycle->toArray()
        );
    }

    public function testClearRulesWithString()
    {
        $this->lifecycle
            ->addDeleteRule(self::$condition)
            ->addSetStorageClassRule('NEARLINE', self::$condition);

        $this->assertInstanceOf(
            Lifecycle::class,
            $this->lifecycle->clearRules('Delete')
        );

        $result = $this->lifecycle
            ->toArray();

        $this->assertCount(1, $result['rule']);
        $this->assertEquals(
            'SetStorageClass',
            current($result['rule'])['action']['type']
        );
    }

    public function testClearRulesWithCallable()
    {
        $this->lifecycle
            ->addDeleteRule(self::$condition);

        $this->assertInstanceOf(
            Lifecycle::class,
            $this->lifecycle
                ->clearRules(function ($rule) {
                    return $rule['condition']['age'] > 70;
                })
        );
        $this->assertEmpty(
            $this->lifecycle->toArray()
        );
    }

    public function testClearRulesThrowsExceptionWithInvalidType()
    {
        $this->expectException('\InvalidArgumentException');

        $this->lifecycle
            ->clearRules(123);
    }

    /**
     * @dataProvider dateTimeRules
     */
    public function testAddSetStorageClassRuleDateTimeTransform($rule, \DateTimeInterface $dt, $dateString)
    {
        $this->lifecycle->addSetStorageClassRule('NEARLINE', [
            $rule => $dt
        ]);

        $this->lifecycle->addSetStorageClassRule('NEARLINE', [
            $rule => $dateString
        ]);

        $result = $this->lifecycle->toArray();

        $this->assertEquals(
            $dateString,
            $result['rule'][0]['condition'][$rule]
        );

        $this->assertEquals(
            $dateString,
            $result['rule'][1]['condition'][$rule]
        );
    }

    /**
     * @dataProvider dateTimeRules
     */
    public function testAddDeleteRuleDateTimeTransform($rule, \DateTimeInterface $dt, $dateString)
    {
        $this->lifecycle->addDeleteRule([
            $rule => $dt
        ]);

        $this->lifecycle->addDeleteRule([
            $rule => $dateString
        ]);

        $result = $this->lifecycle->toArray();

        $this->assertEquals(
            $dateString,
            $result['rule'][0]['condition'][$rule]
        );

        $this->assertEquals(
            $dateString,
            $result['rule'][1]['condition'][$rule]
        );
    }

    public function dateTimeRules()
    {
        $dt = new \DateTime;
        return [
            ['createdBefore', $dt, $dt->format('Y-m-d')],
            ['customTimeBefore', $dt, $dt->format('Y-m-d')],
            ['noncurrentTimeBefore', $dt, $dt->format('Y-m-d')],
        ];
    }
}
