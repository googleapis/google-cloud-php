<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit\Split;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Dev\Split\RunShell;
use Google\Cloud\Dev\Split\SplitInstall;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group dev
 * @group dev-split
 */
class SplitInstallTest extends TestCase
{
    use ExpectException;

    const ROOT_PATH = '/foo/www';
    const INSTALL_PATH = '/foo/bar/bin';

    private $shell;
    private $install;

    public function set_up()
    {
        $this->shell = $this->prophesize(RunShell::class);
        $this->install = TestHelpers::stub(SplitInstallStub::class, [
            $this->shell->reveal(),
            self::INSTALL_PATH
        ], [
            'shell'
        ]);
    }

    public function testInstallFromSource()
    {
        $cmd = self::ROOT_PATH . '/' . SplitInstall::COMPILE_SCRIPT . ' ' . self::INSTALL_PATH;
        $this->shell->execute($cmd)->shouldBeCalled()->willReturn([true]);

        $this->install->___setProperty('shell', $this->shell->reveal());

        $res = $this->install->installFromSource(self::ROOT_PATH);
        $this->assertEquals([
            'Success',
            self::INSTALL_PATH . '/splitsh-lite'
        ], $res);
    }

    public function testInstallFromSourceAlreadyInstalled()
    {
        $this->install->exists = true;
        $res = $this->install->installFromSource(self::ROOT_PATH);
        $this->assertEquals([
            'Already Installed',
            self::INSTALL_PATH . '/splitsh-lite'
        ], $res);
    }

    public function testInstallFromSourceFails()
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Splitsh compile failed with output: Uh oh');

        $cmd = self::ROOT_PATH . '/' . SplitInstall::COMPILE_SCRIPT . ' ' . self::INSTALL_PATH;
        $this->shell->execute($cmd)->shouldBeCalled()->willReturn([false, ['Uh oh']]);

        $this->install->___setProperty('shell', $this->shell->reveal());

        $res = $this->install->installFromSource(self::ROOT_PATH);
    }
}

//@codingStandardsIgnoreStart
class SplitInstallStub extends SplitInstall
{
    public $exists = false;

    protected function fileExists($file)
    {
        return $this->exists;
    }
}
//@codingStandardsIgnoreEnd
