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

use Google\Cloud\Core\RequestTrait;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class RequestTraitTest extends TestCase
{
    private const LINE_NAME = 'alpha';
    private const VALUE = 'eta/test_value2';
    private const VALUE_KEY = 'eta';
    /**
     * @dataProvider getAppendOrModifyHeadersCases
     */
    public function testAppendOrModifyHeaders(
        Request $request,
        array $changes,
        string $finalHeaderLine
    ) {
        $trait = new Class {
            use RequestTrait {
                appendOrModifyHeaders as public;
            }
        };
        $request = $trait->appendOrModifyHeaders(
            $request,
            self::LINE_NAME,
            $changes
        );
        $this->assertEquals($finalHeaderLine, $request->getHeaderLine(self::LINE_NAME));
    }

    /**
     * Returns cases in the format
     * [
     *     Request $request,
     *     array $changes,
     *     string $finalHeaderLine
     * ]
     */
    public function getAppendOrModifyHeadersCases()
    {
        return [
            [
                new Request('GET', 'foo', [
                    self::LINE_NAME => sprintf('%s/test_value1', self::VALUE_KEY)
                ]),
                [self::VALUE],
                self::VALUE
            ],
            [
                new Request('GET', 'foo', []),
                [self::VALUE],
                self::VALUE
            ],
            [
                new Request('GET', 'foo', [
                    self::LINE_NAME => 'test_key/test_value1'
                ]),
                [self::VALUE],
                sprintf('test_key/test_value1 %s', self::VALUE)
            ],
        ];
    }
}
