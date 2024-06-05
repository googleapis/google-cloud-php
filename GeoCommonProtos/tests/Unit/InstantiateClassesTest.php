<?php
/*
 * Copyright 2023 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\GeoCommonProtos\Tests\Unit;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use RecursiveRegexIterator;

class InstantiateClassesTest extends TestCase
{
    /**
     * A simple test to instantiate all classes in the repository.
     * This is a minimal test to make sure we don't include generated
     * classes that contain syntax errors.
     *
     * @dataProvider classesProvider
     */
    public function testInstantiateClass($class)
    {
        $instance = new $class();
        $this->assertNotNull($instance);
    }

    public function classesProvider()
    {
        $directoryPrefix = __DIR__ . '/../../src';
        $directoryPrefixLength = strlen($directoryPrefix);
        $phpFileSuffix = '.php';
        $phpFileSuffixLength = strlen($phpFileSuffix);
        $phpFileSuffixRegex = '#.+\.php$#';

        $dir = new RecursiveDirectoryIterator($directoryPrefix);
        $it = new RecursiveIteratorIterator($dir);
        $reg = new RegexIterator($it, $phpFileSuffixRegex, RecursiveRegexIterator::GET_MATCH);
        foreach ($reg as $files) {
            $file = $files[0];
            // Remove prefix and suffix
            $trimmedFile = substr($file, $directoryPrefixLength, -$phpFileSuffixLength);
            // Prepend standard '\Google\Geo' portion of namespace, then replace '/' with '\'
            $fullyQualifiedName = "\\Google\\Geo" . str_replace("/", "\\", $trimmedFile);
            yield [$fullyQualifiedName];
        }
    }
}
