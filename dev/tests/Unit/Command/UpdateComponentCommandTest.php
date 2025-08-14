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

use Google\Cloud\Dev\Command\UpdateComponentCommand;
use Google\Cloud\Dev\RunProcess;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Yaml\Yaml;

/**
 * @group dev
 */
class UpdateComponentCommandTest extends TestCase
{
    use ProphecyTrait;

    private static string $tmpDir;
    private static CommandTester $commandTester;

    private const COMPONENT_NAME = 'Storage';
    private const OWLBOT_PHP_IMAGE = 'gcr.io/fake-owlbot-image/owlbot-php';
    private const OWLBOT_PHP_DIGEST = 'sha256:12345';
    private const OWLBOT_CLI_IMAGE = 'gcr.io/cloud-devrel-public-resources/owlbot-cli:latest';
    private const DEFAULT_TIMEOUT = 120;

    public static function setUpBeforeClass(): void
    {
        $tmpDir = sys_get_temp_dir() . '/update-command-test-' . time();
        mkdir($tmpDir . '/' . self::COMPONENT_NAME, 0777, true);
        mkdir($tmpDir . '/.github', 0777, true);
        self::$tmpDir = realpath($tmpDir);

        file_put_contents(self::$tmpDir . '/.github/.OwlBot.lock.yaml', Yaml::dump([
            'docker' => [
                'image' => self::OWLBOT_PHP_IMAGE,
                'digest' => self::OWLBOT_PHP_DIGEST,
            ],
        ]));
        $application = new Application();
        $application->add(new UpdateComponentCommand(self::$tmpDir));
        self::$commandTester = new CommandTester($application->get('update-component'));
    }

    public static function tearDownAfterClass(): void
    {
        if (is_dir(self::$tmpDir)) {
            system('rm -rf ' . escapeshellarg(self::$tmpDir));
        }
    }

    public function testUpdateFailsWithInvalidGoogleapisDir()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'Error: googleapis-gen directory not found at /path/to/googleapis-gen.'
            . ' Please provide a valid path using the --googleapis-gen-path option.'
        );

        $googleapisGenPath = '/path/to/googleapis-gen';
        $application = new Application();
        $application->add(new UpdateComponentCommand(self::$tmpDir));
        $commandTester = new CommandTester($application->get('update-component'));

        $commandTester->execute([
            'component' => self::COMPONENT_NAME,
            '--googleapis-gen-path' => $googleapisGenPath,
        ]);
    }

    public function testUpdateFailsWithNoDocker()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error: Docker is not available.');

        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'docker'], null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('');

        $application = new Application();
        $application->add(new UpdateComponentCommand(self::$tmpDir, $runProcess->reveal()));
        $commandTester = new CommandTester($application->get('update-component'));

        $commandTester->execute([
            'component' => self::COMPONENT_NAME,
            '--googleapis-gen-path' => self::$tmpDir,
        ]);
    }

    public function testUpdateFailsWithInvalidComponentName()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid component name provided: NonExistantComponent');

        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'docker'], null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('/path/to/docker');

        $application = new Application();
        $application->add(new UpdateComponentCommand(self::$tmpDir, $runProcess->reveal()));
        $commandTester = new CommandTester($application->get('update-component'));

        $commandTester->execute([
            'component' => 'NonExistantComponent',
            '--googleapis-gen-path' => self::$tmpDir,
        ]);
    }

    public function testUpdateComponentSucceeds()
    {
        $googleapisGenPath = self::$tmpDir;

        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'docker'], null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('/path/to/docker');

        list($userId, $groupId) = [posix_getuid(), posix_getgid()];
        $owlbotPhpImage = self::OWLBOT_PHP_IMAGE . '@' . self::OWLBOT_PHP_DIGEST;

        $copyCodeCommand = [
            'docker', 'run', '--rm',
            '--user', sprintf('%s:%s', $userId, $groupId),
            '-v', sprintf('%s:/repo', self::$tmpDir),
            '-v', sprintf('%s:/googleapis-gen', $googleapisGenPath),
            '-w', '/repo',
            '--env', 'HOME=/tmp',
            self::OWLBOT_CLI_IMAGE,
            'copy-code',
            '--source-repo=/googleapis-gen',
            sprintf('--config-file=%s/.OwlBot.yaml', self::COMPONENT_NAME)
        ];

        $runProcess->execute($copyCodeCommand, null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('');

        $copyBazelBinCommand = [
            'docker', 'run', '--rm',
            '--user', sprintf('%s:%s', $userId, $groupId),
            '-v', sprintf('%s:/repo', self::$tmpDir),
            '-v', sprintf('%s/bazel-bin:/bazel-bin', $googleapisGenPath),
            self::OWLBOT_CLI_IMAGE,
            'copy-bazel-bin',
            sprintf('--config-file=%s/.OwlBot.yaml', self::COMPONENT_NAME),
            '--source-dir', '/bazel-bin',
            '--dest', '/repo'
        ];
        $runProcess->execute($copyBazelBinCommand, null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('');

        $runProcess->execute(['docker', 'pull', $owlbotPhpImage], null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('');

        $postProcessCommand = [
            'docker', 'run', '--rm',
            '--user', sprintf('%s:%s', $userId, $groupId),
            '-v', sprintf('%s:/repo', self::$tmpDir),
            '-w', '/repo',
            $owlbotPhpImage
        ];
        $runProcess->execute($postProcessCommand, null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('');

        $application = new Application();
        $application->add(new UpdateComponentCommand(self::$tmpDir, $runProcess->reveal()));

        $commandTester = new CommandTester($application->get('update-component'));

        $commandTester->execute([
            'component' => self::COMPONENT_NAME,
            '--googleapis-gen-path' => $googleapisGenPath,
        ]);

        $this->assertStringContainsString(
            'Component update completed successfully!',
            $commandTester->getDisplay()
        );
    }

    public function testUpdateComponentErrorsWithNonNumericTimeout()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error: The timeout option must be a positive integer');

        $application = new Application();
        $application->add(new UpdateComponentCommand(self::$tmpDir));

        $commandTester = new CommandTester($application->get('update-component'));
        $commandTester->setInputs([
            'Y' // Does this information look correct? [Y/n]
        ]);
        $commandTester->execute([
            'component' => self::COMPONENT_NAME,
            '--timeout' => 'not-a-number',
        ]);
    }
}
