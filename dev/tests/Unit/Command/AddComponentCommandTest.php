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

use Google\Cloud\Dev\Command\AddComponentCommand;
use Google\Cloud\Dev\Composer;
use Google\Cloud\Dev\RunProcess;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;


/**
 * @group dev
 */
class AddComponentCommandTest extends TestCase
{
    use ProphecyTrait;

    private static $expectedFiles = [
        '.OwlBot.yaml' => '.OwlBot.yaml.test', // so OwlBot doesn't read the test file
        '.gitattributes' => null,
        '.github/pull_request_template.md' => null,
        '.repo-metadata.json' => null,
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
        self::$tmpDir = realpath($tmpDir);
        $application = new Application();
        $application->add(new AddComponentCommand($tmpDir));
        self::$commandTester = new CommandTester($application->get('add-component'));
    }

    public function testAddComponent()
    {
        self::$commandTester->setInputs([
            'Y',                                                            // Does this information look correct? [Y/n]
            'https://cloud.google.com/secret-manager/docs/reference/rest/', // What is the product documentation URL?
            'https://cloud.google.com/secret-manager',                     // What is the product homepage?
        ]);

        self::$commandTester->execute([
            'proto' => 'google/cloud/secretmanager/v1/service.proto',
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

        $this->assertComposerJson('SecretManager');
    }

    public function testAddComponentWithCustomOptions()
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

    public function testGoogleapisGenPath()
    {
        $expectedOwlbotCopyCodeCmd = sprintf(
            'docker run --rm --user %s::%s -v %s:/repo -v :/googleapis-gen -w /repo '
            . '--env HOME=/tmp gcr.io/cloud-devrel-public-resources/owlbot-cli:latest copy-code '
            . '--config-file=SecretManager/.OwlBot.yaml --source-repo=/googleapis-gen',
            posix_getuid(),
            posix_getgid(),
            self::$tmpDir
        );
        $expectedOwlbotPostProcessCmd = sprintf(
            'docker run --rm --user %s::%s -v %s:/repo -w /repo '
            . 'gcr.io/cloud-devrel-public-resources/owlbot-php:latest',
            posix_getuid(),
            posix_getgid(),
            self::$tmpDir
        );
        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'docker'])
            ->shouldBeCalledOnce()
            ->willReturn('/path/to/docker');
        $runProcess->execute(explode(' ', $expectedOwlbotCopyCodeCmd))
            ->shouldBeCalledOnce()
            ->willReturn('');
        $runProcess->execute(explode(' ', $expectedOwlbotPostProcessCmd))
            ->shouldBeCalledOnce()
            ->willReturn('');

        $application = new Application();
        $application->add(new AddComponentCommand(self::$tmpDir, null, $runProcess->reveal()));

        $commandTester = new CommandTester($application->get('add-component'));
        $commandTester->setInputs([
            'Y',                                                            // Does this information look correct? [Y/n]
            'https://cloud.google.com/secret-manager/docs/reference/rest/', // What is the product documentation URL?
            'https://cloud.google.com/secret-manager',                     // What is the product homepage?
        ]);

        $commandTester->execute([
            'proto' => 'google/cloud/secretmanager/v1/service.proto',
            '--googleapis-gen-path' => 'path/to/bazel',
        ]);
    }

    public function testBazelPathAndFetchDocUri()
    {
        $client = new Client();
        $productHomePage = 'https://cloud.google.com/infrastructure-manager';
        $rawContentUri = 'https://raw.githubusercontent.com/googleapis/googleapis/master/';
        $proto = 'google/cloud/config/v1/config.proto';
        $yaml = 'google/cloud/config/v1/config_v1.yaml';
        $expectedOwlbotCopyBazelBinCmd = sprintf(
            'docker run --rm --user %s::%s -v %s:/repo -v /bazel-bin:/bazel-bin '
            . 'gcr.io/cloud-devrel-public-resources/owlbot-cli:latest copy-bazel-bin '
            . '--config-file=Config/.OwlBot.yaml --source-dir /bazel-bin --dest /repo',
            posix_getuid(),
            posix_getgid(),
            self::$tmpDir
        );
        $expectedOwlbotPostProcessCmd = sprintf(
            'docker run --rm --user %s::%s -v %s:/repo -w /repo '
            . 'gcr.io/cloud-devrel-public-resources/owlbot-php:latest',
            posix_getuid(),
            posix_getgid(),
            self::$tmpDir
        );
        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'docker'])
            ->shouldBeCalledOnce()
            ->willReturn('/path/to/docker');
        $runProcess->execute(['bazel', '--version'])
            ->shouldBeCalledOnce()
            ->willReturn('bazel 6.0.0');
        $runProcess->execute(
            ['bazel', 'query', 'filter("-(php)$", kind("rule", //google/cloud/config/v1/...:*))'],
            ''
        )
            ->shouldBeCalledOnce()
            ->willReturn('//google/cloud/config/v1');
        $runProcess->execute(['bazel', 'build', '//' . dirname($proto)], '')
            ->shouldBeCalledOnce()
            ->willReturn('');
        $runProcess->execute(explode(' ', $expectedOwlbotCopyBazelBinCmd))
            ->shouldBeCalledOnce()
            ->willReturn('');
        $runProcess->execute(explode(' ', $expectedOwlbotPostProcessCmd))
            ->shouldBeCalledOnce()
            ->willReturn('');

        $httpClient = $this->prophesize(Client::class);
        $httpClient->get($rawContentUri . $proto)
            ->shouldBeCalledOnce()
            ->willReturn($client->get($rawContentUri . $proto));
        $httpClient->get($rawContentUri . $yaml)
            ->shouldBeCalledOnce()
            ->willReturn($client->get($rawContentUri . $yaml));
        $httpClient->get($productHomePage, ['http_errors' => false])
            ->shouldBeCalledOnce()
            ->willReturn($client->get($productHomePage));

        $application = new Application();
        $application->add(new AddComponentCommand(self::$tmpDir, $httpClient->reveal(), $runProcess->reveal()));

        $commandTester = new CommandTester($application->get('add-component'));
        // No documentationPage/homePage input is required as it is fetched automatically from the yaml file.
        $commandTester->setInputs([
            'Y'              // Does this information look correct? [Y/n]
        ]);

        $commandTester->execute([
            'proto' => $proto,
            '--bazel-path' => '/path/to/bazel',
        ]);
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
