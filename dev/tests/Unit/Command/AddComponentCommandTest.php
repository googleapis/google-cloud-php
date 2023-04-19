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
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;


/**
 * @group dev
 */
class AddComponentCommandTest extends TestCase
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
        'composer.json',
        'owlbot.py',
        'phpunit.xml.dist',
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
            'https://cloud.google.com/secret-mananger',                     // What is the product homepage?
            'https://cloud.google.com/secret-manager/docs/reference/rest/', // What is the product documentation URL?
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
        | componentPath        | %s/SecretManager
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

        foreach (self::$expectedFiles as $file) {
            $this->assertFileExists(self::$tmpDir . '/SecretManager/' . $file);
            $this->assertFileEquals(
                __DIR__ . '/../../fixtures/component/SecretManager/' . $file,
                self::$tmpDir . '/SecretManager/' . $file
            );
        }
    }

    public function testAddComponentWithCustomOptions()
    {
        self::$commandTester->setInputs([
            'n',                                                            // Does this information look correct? [Y/n]
            'google.custom.proto.package',                                  // custom value for "protoPackage"
            'Google\Cloud\CustomNamespace',                                 // custom value for "phpNamespace"
            'Google Cloud Custom Display Name',                             // custom value for "displayName"
            'CustomInputs',                                                 // custom value for "componentName"
            self::$tmpDir . '/CustomInput',                                 // custom value for "componentPath"
            'google/custom-composer-package-name',                          // custom value for "composerPackage"
            'googleapis/google-cloud-php-custom-repo',                      // custom value for "githubRepo"
            'GPBMetadata\Google\Custommetadatanamespace',                   // custom value for "gpbMetadataNamespace"
            'customshortname',                                              // custom value for "shortName"
            'google/cloud/custompath/(.*)',                                 // custom value for "protoPath"
            'v2',                                                           // custom value for "version"
            'Y',                                                            // Does this information look correct? [Y/n]
            'https://cloud.google.com/coustom-product',                     // What is the product homepage?
            'https://cloud.google.com/coustom-product/docs/reference/rest/', // What is the product documentation URL?
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
        | componentName        | CustomInputs
        | componentPath        | %s/CustomInput
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

        foreach (self::$expectedFiles as $file) {
            $this->assertFileExists(self::$tmpDir . '/CustomInput/' . $file);
            $this->assertFileEquals(
                __DIR__ . '/../../fixtures/component/CustomInput/' . $file,
                self::$tmpDir . '/CustomInput/' . $file
            );
        }
    }
}
