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

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\ValidateTrait;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 */
class ValidateTraitTest extends TestCase
{
    use ExpectException;

    private $stub;

    public function set_up()
    {
        $this->stub = TestHelpers::impl(ValidateTrait::class);
    }

    public function testValidateBatch()
    {
        $input = [
            (object)[],
            (object)[],
            (object)[],
        ];

        $this->stub->call('validateBatch', [$input, \stdClass::class]);
    }

    public function testValidateBatchInvalidInput()
    {
        $this->expectException('InvalidArgumentException');

        $input = [
            (object)[],
            (object)[],
            (object)[],
            $this->stub
        ];

        $this->stub->call('validateBatch', [$input, \stdClass::class]);
    }

    public function testAdditionalCheckCalled()
    {
        $called = 0;
        $input = [
            (object)[],
            (object)[],
            (object)[],
        ];

        $this->stub->call('validateBatch', [
            $input,
            \stdClass::class,
            function ($input) use (&$called) {
                $called++;
            }
        ]);

        $this->assertCount($called, $input);
    }
}
