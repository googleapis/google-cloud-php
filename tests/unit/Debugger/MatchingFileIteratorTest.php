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

use Google\Cloud\Debugger\MatchingFileIterator;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class MatchingFileIteratorTest extends TestCase
{
    public function testFindsMany()
    {
        // There are many files that end in Connection/RestTest.php in the test/unit folder
        $iterator = new MatchingFileIterator(
            realpath($this->sourcePath([__DIR__, '../../..'])),
            $this->sourcePath(['Connection', 'RestTest.php'])
        );
        $matches = iterator_to_array($iterator);
        $this->assertGreaterThan(2, count($matches));
    }

    public function testNoMatches()
    {
        $iterator = new MatchingFileIterator(
            realpath($this->sourcePath([__DIR__, '..'])),
            $this->sourcePath(['Connection', 'file-not-exists.php'])
        );
        $matches = iterator_to_array($iterator);
        $this->assertEmpty($matches);
    }

    private function sourcePath($parts)
    {
        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}
