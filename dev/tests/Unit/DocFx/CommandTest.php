<?php
/**
 * Copyright 2022 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit\DocFx;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Dev\ComponentManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * @group dev
 */
class CommandTest extends TestCase
{
    private static $fixturesDir;
    private static $tmpDir;

    public function testGenerateDocFxFiles()
    {
        $fixturesFiles = array_diff(scandir(self::$fixturesDir), ['..', '.']);
        $generatedFiles = array_diff(scandir(self::$tmpDir), ['..', '.']);

        $this->assertEquals([], array_diff($fixturesFiles, $generatedFiles));

    }

    /**
     * @depends testGenerateDocFxFiles
     * @dataProvider provideDoxFxFiles
     */
    public function testDocFxFiles(string $file)
    {
        $this->assertTrue(
            file_exists(self::$fixturesDir . '/' . $file),
            sprintf('%s does not exist in fixtures (%s)', $file, self::$tmpDir . '/' . $file)
        );

        $left  = self::$fixturesDir . '/' . $file;
        $right = self::$tmpDir . '/' . $file;
        if (file_get_contents($left) !== file_get_contents($right)) {
            $output = shell_exec(sprintf('git diff --no-index %s %s --color=always', $left, $right));
            $this->assertTrue(false, $output);
        }

        $this->assertTrue(true, 'file contents match');
    }

    /**
     * @depends testDocFxFiles
     */
    public function testDocsMetadataFile()
    {
        $this->assertTrue(
            file_exists(self::$tmpDir . '/docs.metadata'),
            'docs.metadata was not generated in ' . self::$tmpDir
        );

        $left  = self::$fixturesDir . '/docs.metadata';
        $right = self::$tmpDir . '/docs.metadata';
        $rightContents = preg_replace('/seconds: \d+/', 'seconds: *', file_get_contents($right));
        $rightContents = preg_replace('/nanos: \d+/', 'nanos: *', $rightContents);
        if (file_get_contents($left) !== $rightContents) {
            file_put_contents($right, $rightContents);
            $output = shell_exec(sprintf('git diff --no-index %s %s --color=always', $left, $right));
            $this->assertTrue(false, $output);
        }

        $this->assertTrue(true, 'file contents match');
    }

    public function provideDoxFxFiles()
    {
        $structureXml = __DIR__ . '/../../fixtures/phpdoc/structure.xml';
        $tmpDir = sys_get_temp_dir() . '/' . rand();
        $cmd = sprintf(
            '%s/google-cloud docfx --component Vision --xml %s --out=%s --metadata-version=1.0.0',
            __DIR__ . '/../../../',
            $structureXml,
            $tmpDir
        );
        passthru($cmd);

        $filesAsArguments = [];
        $generatedFiles = array_diff(scandir($tmpDir), ['..', '.']);
        foreach ($generatedFiles as $file) {
            if ($file === 'docs.metadata') {
                continue;
            }
            $filesAsArguments[] = [$file];
        }

        self::$tmpDir = $tmpDir;
        self::$fixturesDir = realpath(__DIR__ . '/../../fixtures/docfx');

        return $filesAsArguments;
    }
}
