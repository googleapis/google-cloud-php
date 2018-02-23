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

namespace Google\Cloud\Tests\Unit\Debugger;

use Google\Cloud\Debugger\CliDaemon;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class CliDaemonTest extends TestCase
{
    public function testClientConfig()
    {
        new CliDaemon([
            'config' => implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), 'data', 'daemon_config.php'])
        ]);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testClientConfigMissing()
    {
        new CliDaemon([
            'config' => 'non-existent-file'
        ]);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testClientConfigWrongReturn()
    {
        new CliDaemon([
            'config' => implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), 'data', 'daemon_config_wrong_return.php'])
        ]);
    }

    public function testSourceRoot()
    {
        new CliDaemon([
            'sourceRoot' => '.'
        ]);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testSourceRootMissing()
    {
        new CliDaemon([
            'sourceRoot' => 'non-existent-directory'
        ]);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testSourceRootInvalid()
    {
        new CliDaemon([
            'sourceRoot' => __FILE__
        ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testDefaults()
    {
        new CliDaemon();
    }
}
