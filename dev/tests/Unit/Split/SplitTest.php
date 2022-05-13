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
use Google\Cloud\Dev\Split\Split;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;

/**
 * @group dev
 * @group dev-split
 */
class SplitTest extends TestCase
{
    private $shell;
    private $split;

    public function set_up()
    {
        $this->shell = $this->prophesize(RunShell::class);
        $this->split = TestHelpers::stub(Split::class, [
            $this->shell->reveal()
        ], [
            'shell'
        ]);
    }

    public function testExecute()
    {
        $binaryPath = '/foo/bar/bin/splitsh-lite';
        $folderToSplit = '/foo/bar/src';

        // method uses `realpath()`, so we need to give it a real directory.
        $rootPath = __DIR__;

        $cmd = sprintf(
            'SPLIT_SHA=`%s --prefix=%s --path=%s`; echo $SPLIT_SHA;',
            $binaryPath,
            $folderToSplit,
            $rootPath
        );

        $this->shell->execute($cmd)->shouldBeCalled()->willReturn([
            true, [
                'foobar'
            ]
        ]);

        $this->split->___setProperty('shell', $this->shell->reveal());

        $this->assertEquals('foobar', $this->split->execute($binaryPath, $rootPath, $folderToSplit));
    }

    public function testExecuteFails()
    {
        $this->shell->execute(Argument::any())->shouldBeCalled()->willReturn([
            false
        ]);

        $this->split->___setProperty('shell', $this->shell->reveal());
        $this->assertNull($this->split->execute('', '', ''));
    }
}
