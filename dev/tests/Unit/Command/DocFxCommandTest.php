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

namespace Google\Cloud\Dev\Tests\Unit\Command;

use Google\Cloud\Dev\Command\DocFxCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group dev
 */
class DocFxCommandTest extends TestCase
{
    private static string $fixturesDir = __DIR__ . '/../../fixtures/docfx';
    private static string $tmpDir;
    private static CommandTester $commandTester;

    public function testGenerateVisionStructureXml()
    {
        if ('1' !== getenv('TEST_PHPDOC_STRUCTURE_XML')) {
            $this->markTestSkipped('Set TEST_PHPDOC_STRUCTURE_XML=1 to run this test');
        }
        $componentDir = __DIR__ . '/../../../../Vision';
        $process = DocFxCommand::getPhpDocCommand($componentDir, self::$tmpDir);
        $process->mustRun();
        $left = __DIR__ . '/../../fixtures/phpdoc/structure.xml';
        $right = self::$tmpDir . '/structure.xml';

        $this->assertFileEqualsWithDiff($left, $right, '1' === getenv('UPDATE_FIXTURES'));
    }

    public function testGenerateDocFxFiles()
    {
        $fixturesFiles = array_diff(scandir(self::$fixturesDir . '/Vision'), ['..', '.']);
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
            file_exists(self::$fixturesDir . '/Vision/' . $file),
            sprintf('%s does not exist in fixtures (%s)', $file, self::$tmpDir . '/' . $file)
        );

        $left  = self::$fixturesDir . '/Vision/' . $file;
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

        $left  = self::$fixturesDir . '/Vision/docs.metadata';
        $right = self::$tmpDir . '/docs.metadata';
        $rightContents = preg_replace('/seconds: \d+/', 'seconds: *', file_get_contents($right));
        $rightContents = preg_replace('/nanos: \d+/', 'nanos: *', $rightContents);
        file_put_contents($right, $rightContents);

        $this->assertFileEqualsWithDiff($left, $right);
    }

    public function provideDocFxFiles()
    {
        $output = self::getCommandTester()->execute([
            '--component' => 'Vision',
            '--xml' => __DIR__ . '/../../fixtures/phpdoc/structure.xml',
            '--out' => self::$tmpDir = sys_get_temp_dir() . '/' . rand(),
            '--metadata-version' => '1.0.0',
            '--component-path' => __DIR__ . '/../../fixtures/component/Vision',
        ]);

        $filesAsArguments = [];
        $generatedFiles = array_diff(scandir(self::$tmpDir), ['..', '.']);
        foreach ($generatedFiles as $file) {
            if ($file === 'docs.metadata') {
                continue;
            }
            $filesAsArguments[] = [$file];
        }

        return $filesAsArguments;
    }

    public function testNewClient()
    {
        self::getCommandTester()->execute([
            '--component' => 'Vision',
            '--xml' => __DIR__ . '/../../fixtures/phpdoc/newclient.xml',
            '--out' => $tmpDir = sys_get_temp_dir() . '/' . rand(),
            '--metadata-version' => '1.0.0',
            '--component-path' => __DIR__ . '/../../fixtures/component/Vision',
        ]);

        foreach (['V1.Client.ImageAnnotatorClient.yml', 'toc.yml'] as $file) {
            $left = self::$fixturesDir . '/NewClient/' . $file;
            $right = $tmpDir . '/' . $file;
            $this->assertFileEqualsWithDiff($left, $right, '1' === getenv('UPDATE_FIXTURES'));
        }
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

    private static function getCommandTester(): CommandTester
    {
        if (!isset(self::$commandTester)) {
            $application = new Application();
            $application->add(new DocFxCommand());
            self::$commandTester = new CommandTester($application->get('docfx'));
        }
        return self::$commandTester;
    }
}
