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

use Google\Cloud\Dev\Command\ComponentUpdateCommand;
use Google\Cloud\Dev\RunProcess;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Yaml\Yaml;

/**
 * @group dev
 */
class ComponentUpdateCommandTest extends TestCase
{
    use ProphecyTrait;

    private static string $tmpDir;
    private static CommandTester $commandTester;

    private const COMPONENT_NAME = 'SecretManager';
    private const LIBRARY_NAME = 'secretmanager';
    private const DEFAULT_TIMEOUT = 120;

    public static function setUpBeforeClass(): void
    {
        $tmpDir = sys_get_temp_dir() . '/update-command-test-' . time();
        mkdir($tmpDir . '/' . self::COMPONENT_NAME, 0777, true);
        self::$tmpDir = realpath($tmpDir);

        file_put_contents(self::$tmpDir . '/librarian.yaml', Yaml::dump([
            'libraries' => [
                [
                    'name' => self::LIBRARY_NAME,
                    'output' => self::COMPONENT_NAME,
                ],
            ],
        ]));

        $application = new Application();
        $application->add(new ComponentUpdateCommand(self::$tmpDir));
        self::$commandTester = new CommandTester($application->get('component:update'));
    }

    public static function tearDownAfterClass(): void
    {
        if (is_dir(self::$tmpDir)) {
            system('rm -rf ' . escapeshellarg(self::$tmpDir));
        }
    }

    public function testUpdateFailsWithNoLibrarian()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error: librarian is not available.');

        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'librarian'], null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('');

        $application = new Application();
        $application->add(new ComponentUpdateCommand(self::$tmpDir, $runProcess->reveal()));
        $commandTester = new CommandTester($application->get('component:update'));

        $commandTester->execute([
            '--component' => [self::COMPONENT_NAME],
        ]);
    }

    public function testUpdateFailsWithInvalidComponentName()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid component name provided: NonExistantComponent');

        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'librarian'], null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('/path/to/librarian');

        $application = new Application();
        $application->add(new ComponentUpdateCommand(self::$tmpDir, $runProcess->reveal()));
        $commandTester = new CommandTester($application->get('component:update'));

        $commandTester->execute([
            '--component' => ['NonExistantComponent'],
        ]);
    }

    public function testUpdateComponentSucceeds()
    {
        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'librarian'], null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('/path/to/librarian');

        $runProcess->execute(
            ['librarian', 'generate', self::LIBRARY_NAME],
            self::$tmpDir,
            self::DEFAULT_TIMEOUT
        )
            ->shouldBeCalledOnce()
            ->willReturn('');

        $application = new Application();
        $application->add(new ComponentUpdateCommand(self::$tmpDir, $runProcess->reveal()));

        $commandTester = new CommandTester($application->get('component:update'));

        $commandTester->execute([
            '--component' => [self::COMPONENT_NAME],
        ]);

        $this->assertStringContainsString(
            'Component update completed successfully!',
            $commandTester->getDisplay()
        );
    }

    public function testUpdateAllComponentsSucceeds()
    {
        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(['which', 'librarian'], null, self::DEFAULT_TIMEOUT)
            ->shouldBeCalledOnce()
            ->willReturn('/path/to/librarian');

        $runProcess->execute(
            ['librarian', 'generate', '--all'],
            self::$tmpDir,
            self::DEFAULT_TIMEOUT
        )
            ->shouldBeCalledOnce()
            ->willReturn('');

        $application = new Application();
        $application->add(new ComponentUpdateCommand(self::$tmpDir, $runProcess->reveal()));

        $commandTester = new CommandTester($application->get('component:update'));

        $commandTester->execute([]);

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
        $application->add(new ComponentUpdateCommand(self::$tmpDir));

        $commandTester = new CommandTester($application->get('component:update'));
        $commandTester->execute([
            '--component' => [self::COMPONENT_NAME],
            '--timeout' => 'not-a-number',
        ]);
    }
}
