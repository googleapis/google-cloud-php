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

use Google\Cloud\Core\HeaderTrait;
use GuzzleHttp\Psr7\Request;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class HeaderTraitTest extends TestCase
{
    private const TARGET_HEADER_LINE = 'alpha';
    private const TARGET_HEADER_VALUE = 'zeta';

    /**
     * This tests whether the $arguments passed to the callbacks for header
     * updation is properly done when those callbacks are invoked in the
     * ExponentialBackoff::execute() method.
     *
     * @dataProvider getUpdateHeadersCases
     */
    public function testUpdateHeaders(
        $requestHeaders,
        $optionsHeaders,
        $getHeaderFromRequest,
        $expected
    ) {
        $headerTraitImpl = new HeaderTraitImpl();
        $arguments = [
            new Request('GET', '/somewhere', $requestHeaders),
            ['headers' => $optionsHeaders]
        ];
        $headerTraitImpl->updateHeader(
            self::TARGET_HEADER_LINE,
            $arguments,
            self::TARGET_HEADER_VALUE,
            $getHeaderFromRequest
        );
        $expected = ['headers' => $expected];
        $this->assertEquals($expected, $arguments[1]);
    }

    private function getUpdateHeadersCases()
    {
        return [
            // No predefined headers, read from options
            [
                [],
                [],
                false,
                [self::TARGET_HEADER_LINE => self::TARGET_HEADER_VALUE]
            ],
            // Target updation header already has a value in request, read from
            // options
            [
                [self::TARGET_HEADER_LINE => 'one'],
                [],
                false,
                [self::TARGET_HEADER_LINE => self::TARGET_HEADER_VALUE]
            ],
            // Target updation header already has a value in options, read from
            // options
            [
                [],
                [self::TARGET_HEADER_LINE => 'one'],
                false,
                [self::TARGET_HEADER_LINE => 'one ' . self::TARGET_HEADER_VALUE]
            ],
            // Target updation header already has a value both in options
            // and request, read from options
            [
                [self::TARGET_HEADER_LINE => 'one'],
                [self::TARGET_HEADER_LINE => 'two'],
                false,
                [self::TARGET_HEADER_LINE => 'two ' . self::TARGET_HEADER_VALUE]
            ],
            // No predefined headers, read from request
            [
                [],
                [],
                true,
                [self::TARGET_HEADER_LINE => self::TARGET_HEADER_VALUE]
            ],
            // Target updation header already has a value in request, read from
            // request
            [
                [self::TARGET_HEADER_LINE => 'one'],
                [],
                true,
                [self::TARGET_HEADER_LINE => 'one ' . self::TARGET_HEADER_VALUE]
            ],
            // Target updation header already has a value in options, read from
            // request
            [
                [],
                [self::TARGET_HEADER_LINE => 'one'],
                true,
                [self::TARGET_HEADER_LINE => self::TARGET_HEADER_VALUE]
            ],
            // Target updation header already has a value both in options
            // and request, read from request
            [
                [self::TARGET_HEADER_LINE => 'one'],
                [self::TARGET_HEADER_LINE => 'two'],
                true,
                [self::TARGET_HEADER_LINE =>'one ' . self::TARGET_HEADER_VALUE]
            ]
        ];
    }
}

// @codingStandardsIgnoreStart
class HeaderTraitImpl
{
    use HeaderTrait {
        updateHeader as public;
    }
}
// @codingStandardsIgnoreEnd
