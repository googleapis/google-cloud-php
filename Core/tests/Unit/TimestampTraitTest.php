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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimestampTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class TimestampTraitTest extends TestCase
{
    /**
     * @dataProvider provideFormatReadTimeOption
     */
    public function testFormatReadTimeOption(array $options, array $expected)
    {
        $trait = new TimestampTraitImpl();
        $formattedOptions = $trait->formatReadTimeOption($options);
        $this->assertEquals($expected, $formattedOptions);
    }

    public function provideFormatReadTimeOption()
    {
        return [
            // empty options
            [
                [],
                [],
            ],
            // timestamp option options
            [
                [
                    'readTime' => new Timestamp(new \DateTimeImmutable('2023-01-01 00:00:00')),
                ],
                [
                    'readTime' => [
                        'seconds' => 1672531200,
                        'nanos' => 0,
                    ],
                ],
            ]
        ];
    }

    public function testInvalidReadTimeOption()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('`$options.readTime` must be an instance of Google\Cloud\Core\Timestamp');

        $trait = new TimestampTraitImpl();
        $trait->formatReadTimeOption([
            'readTime' => 'invalid',
        ]);
    }
}

//@codingStandardsIgnoreStart
class TimestampTraitImpl
{
    use TimestampTrait {
        formatReadTimeOption as public;
    }
}
//@codingStandardsIgnoreEnd
