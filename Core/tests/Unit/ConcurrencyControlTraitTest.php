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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\ConcurrencyControlTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 */
class ConcurrencyControlTraitTest extends TestCase
{
    const ETAG = 'foobar';

    private $trait;

    public function set_up()
    {
        $this->trait = TestHelpers::impl(ConcurrencyControlTrait::class);
    }

    public function testApplyEtagHeader()
    {
        $input = ['etag' => self::ETAG];

        $res = $this->trait->call('applyEtagHeader', [$input]);

        $this->assertEquals(self::ETAG, $res['restOptions']['headers']['If-Match']);
    }

    public function testApplyEtagHeaderCustomName()
    {
        $input = ['test' => self::ETAG];

        $res = $this->trait->call('applyEtagHeader', [$input, 'test']);

        $this->assertEquals(self::ETAG, $res['restOptions']['headers']['If-Match']);
    }
}
