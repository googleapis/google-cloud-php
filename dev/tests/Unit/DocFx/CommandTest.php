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

use Google\Cloud\Dev\DocFx\Command\DocFx;
use Google\Cloud\Dev\DocFx\Page\OverviewPage;
use PHPUnit\Framework\TestCase;

/**
 * @group dev
 */
class CommandTest extends TestCase
{
    private static $fixturesDir;
    private static $tmpDir;

    public function testGenerateVisionStructureXml()
    {
        if ('1' !== getenv('TEST_PHPDOC_STRUCTURE_XML')) {
            $this->markTestSkipped('Set TEST_PHPDOC_STRUCTURE_XML=1 to run this test');
        }
        $componentDir = __DIR__ . '/../../../../Vision';
        $process = DocFx::getPhpDocCommand($componentDir, self::$tmpDir);
        $process->mustRun();
        $left = __DIR__ . '/../../fixtures/phpdoc/structure.xml';
        $right = self::$tmpDir . '/structure.xml';

        $this->assertFileEqualsWithDiff($left, $right, '1' === getenv('UPDATE_FIXTURES'));
    }

    public function testGenerateDocFxFiles()
    {
        $fixturesFiles = array_diff(scandir(self::$fixturesDir), ['..', '.']);
        $generatedFiles = array_diff(scandir(self::$tmpDir), ['..', '.']);

        $this->assertEquals([], array_diff($fixturesFiles, $generatedFiles));
    }

    /**
     * @depends testGenerateDocFxFiles
     * @dataProvider provideDocFxFiles
     */
    public function testDocFxFiles(string $file)
    {
        $this->assertTrue(
            file_exists(self::$fixturesDir . '/' . $file),
            sprintf('%s does not exist in fixtures (%s)', $file, self::$tmpDir . '/' . $file)
        );

        $left  = self::$fixturesDir . '/' . $file;
        $right = self::$tmpDir . '/' . $file;
        $this->assertFileEqualsWithDiff($left, $right, '1' === getenv('UPDATE_FIXTURES'));
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
        file_put_contents($right, $rightContents);

        $this->assertFileEqualsWithDiff($left, $right);
    }

    public function testOverviewPage()
    {
        $overview1 = new OverviewPage("# Not beta\n\n", $beta = false);
        $this->assertEquals("# Not beta\n\n", $overview1->getContents());

        $overview2 = new OverviewPage("No header\n\n", $beta = true);
        $this->assertEquals("No header\n\n", $overview2->getContents());

        $overview3 = new OverviewPage("# No newline", $beta = true);
        $this->assertEquals('# No newline', $overview3->getContents());

        $overview4 = new OverviewPage("# Yes beta\nend.", $beta = true);
        $this->assertStringContainsString('pre-GA', $overview4->getContents());
        $this->assertStringStartsWith("# Yes beta\n", $overview4->getContents());
        $this->assertStringEndsWith("\nend.", $overview4->getContents());
    }

    public function provideDocFxFiles()
    {
        $structureXml = __DIR__ . '/../../fixtures/phpdoc/structure.xml';
        $componentDir = __DIR__ . '/../../fixtures/component/Vision';
        $tmpDir = sys_get_temp_dir() . '/' . rand();
        $cmd = sprintf(
            '%s/google-cloud docfx --component Vision --xml %s --out=%s --metadata-version=1.0.0 --component-path=%s',
            __DIR__ . '/../../../',
            $structureXml,
            $tmpDir,
            $componentDir
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

    private function assertFileEqualsWithDiff(string $left, string $right, bool $updateFixtures = false)
    {
        if (file_get_contents($left) !== file_get_contents($right)) {
            if ($updateFixtures) {
                file_put_contents($left, file_get_contents($right));
                $this->markTestIncomplete('Updated fixture ' . basename($left));
            }
            $output = shell_exec(sprintf('git diff --no-index %s %s --color=always', $left, $right));
            $this->assertTrue(false, $output);
        }

        $this->assertTrue(true, 'file contents match');
    }
}
