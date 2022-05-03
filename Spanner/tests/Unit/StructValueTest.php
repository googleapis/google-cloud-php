<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\StructValue;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group spanner
 * @group spanner-structvalue
 */
class StructValueTest extends TestCase
{
    private $values;

    public function set_up()
    {
        $this->values = [
            [
                'name' => 'a',
                'value' => '1'
            ], [
                'name' => 'b',
                'value' => '2'
            ]
        ];
    }

    public function testConstructor()
    {
        $val = new StructValue($this->values);

        $this->assertEquals($this->values, $val->values());
    }

    public function testAdd()
    {
        $val = new StructValue;
        $val->add($this->values[0]['name'], $this->values[0]['value'])
            ->add($this->values[1]['name'], $this->values[1]['value']);

        $this->assertEquals($this->values, $val->values());
    }

    public function testAddUnnamed()
    {
        $val = new StructValue;
        $val->addUnnamed($this->values[0]['value'])
            ->addUnnamed($this->values[1]['value']);

        $this->assertEquals([
            [
                'name' => null,
                'value' => $this->values[0]['value']
            ], [
                'name' => null,
                'value' => $this->values[1]['value']
            ]
            ], $val->values());
    }
}
