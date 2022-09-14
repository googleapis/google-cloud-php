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

use Google\Cloud\Debugger\SourceLocation;
use Google\Cloud\Debugger\SourceLocationResolver;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group debugger
 */
class SourceLocationResolverTest extends TestCase
{
    private static $cwd;

    public static function set_up_before_class()
    {
        self::$cwd = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '../../']));
    }

    public function testExactMatch()
    {
        $location = new SourceLocation('src/DebuggerClient.php', 1);
        $resolver = new SourceLocationResolver([self::$cwd]);
        $resolvedLocation = $resolver->resolve($location);
        $this->assertInstanceOf(SourceLocation::class, $resolvedLocation);
        $expectedFile = $this->sourcePath(['src', 'DebuggerClient.php']);
        $this->assertEquals($expectedFile, $resolvedLocation->path());
        $this->assertEquals(1, $resolvedLocation->line());
    }

    public function testExtraDirectories()
    {
        $location = new SourceLocation('extra/src/DebuggerClient.php', 1);
        $resolver = new SourceLocationResolver([self::$cwd]);
        $resolvedLocation = $resolver->resolve($location);
        $this->assertInstanceOf(SourceLocation::class, $resolvedLocation);
        $expectedFile = $this->sourcePath(['src', 'DebuggerClient.php']);
        $this->assertEquals($expectedFile, $resolvedLocation->path());
        $this->assertEquals(1, $resolvedLocation->line());
    }

    public function testMissingDirectories()
    {
        $location = new SourceLocation('DebuggerClient.php', 1);
        $resolver = new SourceLocationResolver([self::$cwd]);
        $resolvedLocation = $resolver->resolve($location);
        $this->assertInstanceOf(SourceLocation::class, $resolvedLocation);
        $expectedFile = $this->sourcePath(['src', 'DebuggerClient.php']);
        $this->assertEquals($expectedFile, $resolvedLocation->path());
        $this->assertEquals(1, $resolvedLocation->line());
    }

    private function sourcePath($parts)
    {
        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}
