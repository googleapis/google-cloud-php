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

use Google\Cloud\Dev\Split\RunShell;
use PHPUnit\Framework\TestCase;

/**
 * @group dev
 * @group dev-split
 */
class RunShellTest extends TestCase
{
    /**
     * @dataProvider cmds
     */
    public function testExecute($cmd, $code, $output)
    {
        if (defined(PHP_OS) && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->markTestSkipped('Cannot execute test in Windows.');
        }

        $shell = new RunShell;
        $res = $shell->execute($cmd);

        $this->assertEquals($code == 0, $res[0]);
        // trim quotes for windows.
        $this->assertEquals($output, array_map(function ($line) {
            return trim($line, '"');
        }, $res[1]));
    }

    public function cmds()
    {
        return [
            ['echo "hello"', 0, ['hello']],
            ['exit 2', 2, []],
            ['echo "hello"; exit 2', 2, ['hello']]
        ];
    }
}
