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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\ValidateTrait;

/**
 * @group core
 */
class ValidateTraitTest extends \PHPUnit_Framework_TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new ValidateTraitStub;
    }

    public function testValidateBatch()
    {
        $input = [
            (object)[],
            (object)[],
            (object)[],
        ];

        $this->stub->v($input, \stdClass::class);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidateBatchInvalidInput()
    {
        $input = [
            (object)[],
            (object)[],
            (object)[],
            $this->stub
        ];

        $this->stub->v($input, \stdClass::class);
    }

    public function testAdditionalCheckCalled()
    {
        $called = 0;
        $input = [
            (object)[],
            (object)[],
            (object)[],
        ];

        $this->stub->v($input, \stdClass::class, function ($input) use (&$called) {
            $called++;
        });

        $this->assertEquals(count($input), $called);
    }
}

class ValidateTraitStub
{
    use ValidateTrait;

    public function v(array $input, $type, callable $check = null)
    {
        return $this->validateBatch($input, $type, $check);
    }
}
