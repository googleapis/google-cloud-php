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
use Google\Cloud\Dev\DocFx\Node\ClassNode;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Yaml\Yaml;
use SimpleXMLElement;

/**
 * @group dev
 */
class DocFxCommandTest extends TestCase
{
    private static string $fixturesDir = __DIR__ . '/../../fixtures';
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
        $left = self::$fixturesDir . '/phpdoc/structure.xml';
        $right = self::$tmpDir . '/structure.xml';

        $this->assertFileEqualsWithDiff($left, $right, '1' === getenv('UPDATE_FIXTURES'));
    }

    public function testGenerateNewClientStructureXml()
    {
        if ('1' !== getenv('TEST_PHPDOC_STRUCTURE_XML')) {
            $this->markTestSkipped('Set TEST_PHPDOC_STRUCTURE_XML=1 to run this test');
        }
        $componentDir = __DIR__ . '/../../../../SecretManager';
        $process = DocFxCommand::getPhpDocCommand($componentDir, self::$tmpDir);
        $process->mustRun();

        $left = self::$fixturesDir . '/phpdoc/newclient.xml';
        $right = self::$tmpDir . '/structure.xml';

        // Create "newclient.xml" fixture by using ONLY service client classes.
        $xml = new SimpleXMLElement(file_get_contents($right));
        $newClientXml = '<?xml version="1.0"?><project name="Documentation">';
        foreach ($xml->file as $file) {
            if (isset($file->class[0])) {
                $classNode = new ClassNode($file->class[0]);
                if ($classNode->isServiceClass() || $classNode->isServiceBaseClass())  {
                    $newClientXml .= $file->asXML();
                }
            }
        }
        $newClientXml .= '</project>';
        file_put_contents($right, $newClientXml);

        $this->assertFileEqualsWithDiff($left, $right, '1' === getenv('UPDATE_FIXTURES'));
    }

    public function testGenerateDocFxFiles()
    {
        $fixturesFiles = array_diff(scandir(self::$fixturesDir . '/docfx/Vision'), ['..', '.']);
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
            file_exists(self::$fixturesDir . '/docfx/Vision/' . $file),
            sprintf('%s does not exist in fixtures (%s)', $file, self::$tmpDir . '/' . $file)
        );

        $left  = self::$fixturesDir . '/docfx/Vision/' . $file;
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

        $left  = self::$fixturesDir . '/docfx/Vision/docs.metadata';
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
            '--xml' => self::$fixturesDir . '/phpdoc/structure.xml',
            '--out' => self::$tmpDir = sys_get_temp_dir() . '/' . rand(),
            '--metadata-version' => '1.0.0',
            '--component-path' => self::$fixturesDir . '/component/Vision',
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

    public function provideNewClient()
    {
        self::getCommandTester()->execute([
            '--component' => 'SecretManager',
            '--xml' => self::$fixturesDir . '/phpdoc/newclient.xml',
            '--out' => $tmpDir = sys_get_temp_dir() . '/' . rand(),
            '--metadata-version' => '1.0.0',
        ]);

        return [
            [$tmpDir, 'V1.Client.SecretManagerServiceClient.yml'],
            [$tmpDir, 'toc.yml']
        ];
    }

    /**
     * @dataProvider provideNewClient
     */
    public function testNewClient(string $tmpDir, string $file)
    {
        $left = self::$fixturesDir . '/docfx/NewClient/' . $file;
        $right = $tmpDir . '/' . $file;
        $this->assertFileEqualsWithDiff($left, $right, '1' === getenv('UPDATE_FIXTURES'));
    }

    public function testNewClientMagicMethods()
    {
        $newClientDocFx = self::$fixturesDir . '/docfx/NewClient/V1.Client.SecretManagerServiceClient.yml';
        $yaml = Yaml::parse(file_get_contents($newClientDocFx));
        $asyncMethods = array_filter(
            $yaml['items'][0]['children'],
            fn ($child) => 'Async()' === substr($child, -7)
        );
        $this->assertGreaterThan(0, count($asyncMethods));
        $baseClientMethods = array_filter(
            $yaml['items'][0]['children'],
            fn ($child) => false !== strpos($child, 'BaseClient')
        );
        $this->assertCount(0, $baseClientMethods);
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
            self::$commandTester = new CommandTester(new DocFxCommand());
        }
        return self::$commandTester;
    }
}
