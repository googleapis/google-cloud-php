<?php
/**
 * Copyright 2023 Google LLC
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

use Google\Cloud\Dev\Command\UpdateReadmeSampleCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @group dev
 */
class UpdateReadmeSampleCommandTest extends TestCase
{
    private static CommandTester $commandTester;
    private $componentDir;

    public function setUp(): void
    {
        $this->componentDir = sys_get_temp_dir() . '/google-cloud-php-tests-' . rand() . '/ClientSnippets';
        $filesystem = new Filesystem();
        $filesystem->mirror(__DIR__ . '/../../fixtures/component/ClientSnippets', $this->componentDir);

        // Write minimum composer.json
        file_put_contents($this->componentDir . '/composer.json', json_encode([
            'name' => 'ClientSnippets',
            'description' => 'Component for testing',
            'autoload' => ['psr-4' => ['TestComponent' => 'src']],
            'homepage' => 'https://github.com/googleapis/google-cloud-php-client-snippet',
        ]));
        // Write minimum repo-metadata.json
        file_put_contents($this->componentDir . '/.repo-metadata.json', json_encode([
            'release_level' => 'preview',
            'client_documentation' => 'https://github.com/googleapis/google-cloud-php',
            'library_type' => 'GAPIC_AUTO',
        ]));

        $application = new Application();
        $application->add(new UpdateReadmeSampleCommand($this->componentDir . '/..'));
        self::$commandTester = new CommandTester($application->get('update-readme-sample'));
    }

    public function testUpdateReadmeSample()
    {
        self::$commandTester->execute([
            '--component' => ['ClientSnippets'],
        ]);

        $this->assertStringContainsString(
            "use Google\Cloud\ClientSnippets\V1\Client\ClientSnippetsClient;",
            file_get_contents($this->componentDir . '/README.md')
        );
    }

    public function testUpdateSampleWithNewVersion()
    {
        $v1SamplePath = $this->componentDir . '/samples/v1/ClientSnippetsClient/an_rpc_method.php';
        $v2SampleDir = $this->componentDir . '/samples/v2/ClientSnippetsClient';
        $v2Sample = str_replace('V1', 'V2', file_get_contents($v1SamplePath));
        if (!is_dir($v2SampleDir)) {
            mkdir($v2SampleDir, 0777, true);
        }
        file_put_contents($v2SampleDir . '/a_v2_rpc_method.php', $v2Sample);

        // Create mock component so the version shows up
        $v2SrcDir = $this->componentDir . '/src/V2';
        if (!is_dir($v2SrcDir)) {
            mkdir($v2SrcDir, 0777, true);
        }
        file_put_contents($v2SrcDir . '/.keep', '');

        self::$commandTester->execute([
            '--component' => ['ClientSnippets'],
        ]);

        $readme = file_get_contents($this->componentDir . '/README.md');
        $this->assertStringContainsString(
            "use Google\Cloud\ClientSnippets\V2\Client\ClientSnippetsClient;",
            $readme
        );
    }
}
