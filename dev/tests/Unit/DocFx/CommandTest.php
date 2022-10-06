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
use Google\Cloud\Dev\DocFx\Page\OverviewPage;
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
            if ('1' === getenv('UPDATE_FIXTURES')) {
                file_put_contents(self::$fixturesDir . '/' . $file, file_get_contents($right));
                $this->markTestIncomplete('Updated fixture ' . $file);
            }
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

    public function testOverviewPage()
    {
        $overview1 = new OverviewPage("# Not beta\n\n", $beta = false);
        $this->assertEquals("# Not beta\n\n", $overview1->getContents());
        $tocItem1 = $overview1->getTocItem();
        $this->assertArrayNotHasKey('status', $tocItem1);

        $overview2 = new OverviewPage("No header\n\n", $beta = true);
        $this->assertEquals("No header\n\n", $overview2->getContents());
        $tocItem2 = $overview2->getTocItem();
        $this->assertArrayHasKey('status', $tocItem2);
        $this->assertEquals('beta', $tocItem2['status']);

        $overview3 = new OverviewPage("# No newline", $beta = true);
        $this->assertEquals('# No newline', $overview3->getContents());
        $tocItem3 = $overview3->getTocItem();
        $this->assertArrayHasKey('status', $tocItem3);
        $this->assertEquals('beta', $tocItem3['status']);

        $overview4 = new OverviewPage("# Yes beta\nend.", $beta = true);
        $this->assertStringContainsString('pre-GA', $overview4->getContents());
        $this->assertStringStartsWith("# Yes beta\n", $overview4->getContents());
        $this->assertStringEndsWith("\nend.", $overview4->getContents());

        $tocItem4 = $overview4->getTocItem();
        $this->assertArrayHasKey('status', $tocItem4);
        $this->assertEquals('beta', $tocItem4['status']);
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
