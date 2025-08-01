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

use Google\Cloud\Dev\Command\NewComponentCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Google\Cloud\Dev\Composer;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;


/**
 * @group dev
 */
class NewComponentCommandTest extends TestCase
{
    use ProphecyTrait;

    private static $expectedFiles = [
        '.OwlBot.yaml' => '.OwlBot.yaml.test', // so OwlBot doesn't read the test file
        '.gitattributes' => null,
        '.github/pull_request_template.md' => null,
        'CONTRIBUTING.md' => null,
        'LICENSE' => null,
        'README.md' => null,
        'VERSION' => null,
        'owlbot.py' => null,
        'phpunit.xml.dist' => null,
    ];

    private static string $tmpDir;
    private static CommandTester $commandTester;

    public static function setUpBeforeClass(): void
    {
        mkdir($tmpDir = sys_get_temp_dir() . '/add-command-test-' . time());
        touch($tmpDir . '/composer.json');
        file_put_contents($tmpDir . '/.repo-metadata-full.json', '{}');
        self::$tmpDir = realpath($tmpDir);

        $application = new Application();
        $application->add(new NewComponentCommand(self::$tmpDir));
        self::$commandTester = new CommandTester($application->get('new-component'));
    }

    public function testNewComponent()
    {
        self::$commandTester->setInputs([
            'Y'    // Does this information look correct? [Y/n]
        ]);

        self::$commandTester->execute([
            'proto' => 'google/cloud/secretmanager/v1/service.proto',
            '--no-update-component' => true,
        ]);

        // confirm expected output
        $display = self::$commandTester->getDisplay();
        $expectedDisplay = sprintf(<<<EOF
        | protoPackage         | google.cloud.secretmanager
        | phpNamespace         | Google\Cloud\SecretManager
        | displayName          | Google Cloud Secret Manager
        | componentName        | SecretManager
        | componentPath        | %s
        | composerPackage      | google/cloud-secretmanager
        | githubRepo           | googleapis/google-cloud-php-secretmanager
        | gpbMetadataNamespace | GPBMetadata\Google\Cloud\Secretmanager
        | shortName            | secretmanager
        | protoPath            | google/cloud/secretmanager/(v1)
        | version              | v1
        EOF, self::$tmpDir);
        foreach (explode("\n", $expectedDisplay) as $expectedLine) {
            $this->assertStringContainsString($expectedLine, $display);
        }

        foreach (self::$expectedFiles as $file => $fixtureFile) {
            $this->assertFileExists(self::$tmpDir . '/SecretManager/' . $file);
            $this->assertFileEquals(
                __DIR__ . '/../../fixtures/component/SecretManager/' . ($fixtureFile ?: $file),
                self::$tmpDir . '/SecretManager/' . $file
            );
        }

        $repoMetadataFull = json_decode(file_get_contents(self::$tmpDir . '/.repo-metadata-full.json'), true);
        $this->assertArrayHasKey('SecretManager', $repoMetadataFull);
        $this->assertComposerJson('SecretManager');
    }

    public function testNewComponentWithCustomOptions()
    {
        self::$commandTester->setInputs([
            'n',                                                            // Does this information look correct? [Y/n]
            'google.custom.proto.package',                                  // custom value for "protoPackage"
            'Google\Cloud\CustomNamespace',                                 // custom value for "phpNamespace"
            'Google Cloud Custom Display Name',                             // custom value for "displayName"
            'CustomInput',                                                  // custom value for "componentName"
            self::$tmpDir,                                                  // custom value for "componentPath"
            'google/custom-composer-package-name',                          // custom value for "composerPackage"
            'googleapis/google-cloud-php-custom-repo',                      // custom value for "githubRepo"
            'GPBMetadata\Google\Custommetadatanamespace',                   // custom value for "gpbMetadataNamespace"
            'customshortname',                                              // custom value for "shortName"
            'google/cloud/custompath/(.*)',                                 // custom value for "protoPath"
            'v2',                                                           // custom value for "version"
            'Y',                                                            // Does this information look correct? [Y/n]
            'https://cloud.google.com/coustom-product/docs/reference/rest/', // What is the product documentation URL?
            'https://cloud.google.com/coustom-product',                     // What is the product homepage?
        ]);

        self::$commandTester->execute([
            'proto' => 'google/cloud/secretmanager/v1/service.proto',
            '--no-update-component' => true
        ]);

        // confirm expected output
        $display = self::$commandTester->getDisplay();
        $expectedDisplay = sprintf(<<<EOF
        | protoPackage         | google.custom.proto.package
        | phpNamespace         | Google\Cloud\CustomNamespace
        | displayName          | Google Cloud Custom Display Name
        | componentName        | CustomInput
        | componentPath        | %s
        | composerPackage      | google/custom-composer-package-name
        | githubRepo           | googleapis/google-cloud-php-custom-repo
        | gpbMetadataNamespace | GPBMetadata\Google\Custommetadatanamespace
        | shortName            | customshortname
        | protoPath            | google/cloud/custompath/(.*)
        | version              | v2
        EOF, self::$tmpDir);
        foreach (explode("\n", $expectedDisplay) as $expectedLine) {
            $this->assertStringContainsString($expectedLine, $display);
        }

        foreach (self::$expectedFiles as $file => $fixtureFile) {
            $this->assertFileExists(self::$tmpDir . '/CustomInput/' . $file);
            $this->assertFileEquals(
                __DIR__ . '/../../fixtures/component/CustomInput/' . ($fixtureFile ?: $file),
                self::$tmpDir . '/CustomInput/' . $file
            );
        }

        $this->assertComposerJson('CustomInput');
    }
    public function testNewComponentWithUpdateComponent()
    {
        $dummyCommand = $this->prophesize(Command::class);

        $dummyCommand->isEnabled()->willReturn(true);
        $dummyCommand->getDefinition()->willReturn($this->prophesize(InputDefinition::class));
        $dummyCommand->getAliases()->willReturn([]);
        $dummyCommand->setApplication(Argument::type(Application::class))->shouldBeCalled();

        $application = new Application();
        $application->add(new NewComponentCommand(self::$tmpDir));

        // Add dummy command for update-command and add-sample-to-readme to ensure they're called
        $dummyCommand->getName()->willReturn('update-component');
        $application->add($dummyCommand->reveal());
        $dummyCommand->getName()->willReturn('add-sample-to-readme');
        $application->add($dummyCommand->reveal());
        $dummyCommand->run(Argument::cetera())
            ->willReturn(0)
            ->shouldBeCalledTimes(2);

        $commandTester = new CommandTester($application->get('new-component'));

        $commandTester->setInputs([
            'Y'    // Does this information look correct? [Y/n]
        ]);

        $commandTester->execute([
            'proto' => 'google/cloud/secretmanager/v1/service.proto',
        ]);

        // confirm expected output
        $display = $commandTester->getDisplay();
        $expectedDisplay = sprintf(<<<EOF
        | protoPackage         | google.cloud.secretmanager
        | phpNamespace         | Google\Cloud\SecretManager
        | displayName          | Google Cloud Secret Manager
        | componentName        | SecretManager
        | componentPath        | %s
        | composerPackage      | google/cloud-secretmanager
        | githubRepo           | googleapis/google-cloud-php-secretmanager
        | gpbMetadataNamespace | GPBMetadata\Google\Cloud\Secretmanager
        | shortName            | secretmanager
        | protoPath            | google/cloud/secretmanager/(v1)
        | version              | v1
        EOF, self::$tmpDir);
        foreach (explode("\n", $expectedDisplay) as $expectedLine) {
            $this->assertStringContainsString($expectedLine, $display);
        }

        foreach (self::$expectedFiles as $file => $fixtureFile) {
            $this->assertFileExists(self::$tmpDir . '/SecretManager/' . $file);
            $this->assertFileEquals(
                __DIR__ . '/../../fixtures/component/SecretManager/' . ($fixtureFile ?: $file),
                self::$tmpDir . '/SecretManager/' . $file
            );
        }

        $repoMetadataFull = json_decode(file_get_contents(self::$tmpDir . '/.repo-metadata-full.json'), true);
        $this->assertArrayHasKey('SecretManager', $repoMetadataFull);
        $this->assertComposerJson('SecretManager');
    }

    private function assertComposerJson(string $componentName)
    {
        $composerPath = sprintf('%s/../../fixtures/component/%s/composer.json', __DIR__, $componentName);
        $this->assertFileExists($composerPath);
        $this->assertEquals(
            file_get_contents(sprintf('%s/%s/composer.json', self::$tmpDir, $componentName)),
            str_replace(
                'GAX_VERSION',
                Composer::getLatestVersion('google/gax'),
                file_get_contents($composerPath)
            )
        );
    }
}
