<?php
/**
 * Copyright 2016 Google Inc.
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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\WhitelistTrait;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 */
class WhitelistTraitTest extends TestCase
{
    private $trait;

    public function set_up()
    {
        $this->trait = TestHelpers::impl(WhitelistTrait::class);
    }

    public function testModifyWhitelistedError()
    {
        $ex = new NotFoundException('hello world');

        $res = $this->trait->call('modifyWhitelistedError', [$ex]);

        $this->assertInstanceOf(NotFoundException::class, $res);
        $this->assertEquals(
            $res->getMessage(),
            'NOTE: Error may be due to Whitelist Restriction. hello world'
        );
    }
}
