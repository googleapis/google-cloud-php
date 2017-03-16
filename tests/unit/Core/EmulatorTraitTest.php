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

use Google\Cloud\Core\EmulatorTrait;
use Prophecy\Argument;

/**
 * @group core
 */
class EmulatorTraitTest extends \PHPUnit_Framework_TestCase
{
    private $implementation;

    public function setUp()
    {
        $this->implementation = $this->getObjectForTrait(EmulatorTrait::class);
    }

    public function testGetEmulatorBaseUriNoEmulator()
    {
        $res = $this->implementation->getEmulatorBaseUri('http://google.com', null);

        $this->assertEquals('http://google.com', $res);
    }

    public function testGetEmulatorBaseUriEmulator()
    {
        $res = $this->implementation->getEmulatorBaseUri('http://google.com', 'http://localhost:8080');

        $this->assertEquals('http://localhost:8080/', $res);
    }
}
