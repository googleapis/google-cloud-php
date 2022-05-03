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

namespace Google\Cloud\Debugger\Tests\Unit;

use Google\Cloud\Debugger\CliDaemon;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group debugger
 */
class CliDaemonTest extends TestCase
{
    use ExpectException;

    public function testClientConfig()
    {
        new CliDaemon([
            'config' => implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), 'data', 'daemon_config.php'])
        ]);
    }

    public function testClientConfigMissing()
    {
        $this->expectException('UnexpectedValueException');

        new CliDaemon([
            'config' => 'non-existent-file'
        ]);
    }

    public function testClientConfigWrongReturn()
    {
        $this->expectException('UnexpectedValueException');

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

    public function testSourceRootMissing()
    {
        $this->expectException('UnexpectedValueException');

        new CliDaemon([
            'sourceRoot' => 'non-existent-directory'
        ]);
    }

    public function testSourceRootInvalid()
    {
        $this->expectException('UnexpectedValueException');

        new CliDaemon([
            'sourceRoot' => __FILE__
        ]);
    }

    public function testDefaults()
    {
        $this->expectException('InvalidArgumentException');

        new CliDaemon();
    }
}
