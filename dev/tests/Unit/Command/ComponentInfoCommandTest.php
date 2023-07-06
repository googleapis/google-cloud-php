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

use Google\Cloud\Dev\Command\ComponentInfoCommand;
use Google\Cloud\Dev\Composer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;


/**
 * @group dev
 */
class ComponentInfoCommandTest extends TestCase
{
    private static $expectedFiles = [
        '.OwlBot.yaml',
        '.gitattributes',
        '.github/pull_request_template.md',
        '.repo-metadata.json',
        'CONTRIBUTING.md',
        'LICENSE',
        'README.md',
        'VERSION',
        'owlbot.py',
        'phpunit.xml.dist',
    ];

    private static CommandTester $commandTester;

    public static function setUpBeforeClass(): void
    {
        self::$commandTester = new CommandTester(new ComponentInfoCommand());
    }

    public function testListAll()
    {
        self::$commandTester->execute([]);

        // confirm a few components we expect to see in the output
        $display = self::$commandTester->getDisplay();
        $components = [
            'AccessContextManager',
            'BinaryAuthorization',
            'GkeConnectGateway',
            'OrgPolicy',
            'Workflows'
        ];
        foreach ($components as $component) {
            $this->assertStringContainsString($component, $display);
        }
    }

    public function testComponentDetails()
    {
        self::$commandTester->execute(['-c' => 'AccessContextManager']);

        // confirm a few fields we expect to see in the output
        $display = self::$commandTester->getDisplay();

        $this->assertStringContainsString('Component Name: AccessContextManager', $display);
        $this->assertStringContainsString('Package Name: google/access-context-manager', $display);
        $this->assertStringContainsString('Release Level: ', $display);   // these values might change
        $this->assertStringContainsString('Package Version: ', $display); // these values might change
    }

    public function testFieldsOption()
    {
        self::$commandTester->execute([
            '-c' => 'AccessContextManager',
            '--fields' => 'name,package_name,doesnt_exist',
        ]);
        $this->assertEquals(<<<EOL
+-----------------------------------------------+
| Component Name: AccessContextManager          |
|   Package Name: google/access-context-manager |
+-----------------------------------------------+

EOL, self::$commandTester->getDisplay());
    }

    public function testFieldsOptionOrder()
    {
        self::$commandTester->execute([
            '-c' => 'AccessContextManager',
            '--fields' => 'package_name,name',
        ]);
        $this->assertEquals(<<<EOL
+-----------------------------------------------+
|   Package Name: google/access-context-manager |
| Component Name: AccessContextManager          |
+-----------------------------------------------+

EOL, self::$commandTester->getDisplay());
    }

    public function testCsv()
    {
        mkdir($tmpDir = sys_get_temp_dir() . '/component-info-test-' . time());
        $csv = $tmpDir . '/test.csv';
        self::$commandTester->execute([
            '-c' => 'AccessContextManager',
            '--fields' => 'package_name,name,github_repo',
            '--csv' => $csv,
        ]);
        $this->assertFileExists($csv);
        $this->assertEquals(<<<EOL
"Package Name","Component Name","Github Repo"
google/access-context-manager,AccessContextManager,googleapis/php-access-context-manager

EOL, file_get_contents($csv));
    }
}
