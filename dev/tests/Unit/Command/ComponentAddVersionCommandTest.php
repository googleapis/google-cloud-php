<?php

namespace Google\Cloud\Dev\Tests\Unit\Command;

use Google\Cloud\Dev\Command\ComponentAddVersionCommand;
use Google\Cloud\Dev\RunProcess;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class ComponentAddVersionCommandTest extends TestCase
{
    use ProphecyTrait;

    private static string $rootPath;
    private static string $librarianFile;

    private const DEFAULT_TIMEOUT = 120;

    public static function setUpBeforeClass(): void
    {
        $rootPath = sys_get_temp_dir() . '/google-cloud-php-tests-' . time();
        $filesystem = new Filesystem();
        $filesystem->mkdir($rootPath);
        self::$rootPath = realpath($rootPath);
        self::$librarianFile = self::$rootPath . '/librarian.yaml';

        file_put_contents(self::$librarianFile, Yaml::dump([
            'libraries' => [
                [
                    'name' => 'example',
                    'output' => 'Example',
                    'apis' => [
                        ['path' => 'google/cloud/example/v1'],
                        ['path' => 'google/cloud/example/v1beta1'],
                    ],
                ],
            ],
        ]));
    }

    public static function tearDownAfterClass(): void
    {
        $filesystem = new Filesystem();
        $filesystem->remove(self::$rootPath);
    }

    public function testAddVersion()
    {
        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(
            ['librarian', 'add', 'google/cloud/example/v2'],
            self::$rootPath,
            self::DEFAULT_TIMEOUT
        )
            ->shouldBeCalledOnce()
            ->willReturn('');

        $command = new ComponentAddVersionCommand(self::$rootPath, $runProcess->reveal());
        $command->setApplication($this->mockApplication());
        $tester = new CommandTester($command);

        $tester->execute([
            'component' => 'Example',
            'version' => 'v2',
        ]);

        $this->assertStringContainsString('Adding new version \'v2\' to librarian.yaml', $tester->getDisplay());
    }

    public function testAddVersionNoUpdate()
    {
        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute(
            ['librarian', 'add', 'google/cloud/example/v3'],
            self::$rootPath,
            self::DEFAULT_TIMEOUT
        )
            ->shouldBeCalledOnce()
            ->willReturn('');

        $command = new ComponentAddVersionCommand(self::$rootPath, $runProcess->reveal());
        $command->setApplication($this->mockApplication(false));
        $tester = new CommandTester($command);

        $tester->execute([
            'component' => 'Example',
            'version' => 'v3',
            '--no-update' => true,
        ]);

        $this->assertStringContainsString('Adding new version \'v3\' to librarian.yaml', $tester->getDisplay());
        $this->assertStringContainsString('Skipping component update', $tester->getDisplay());
    }

    public function testDoesNotAddIfVersionExists()
    {
        $runProcess = $this->prophesize(RunProcess::class);
        $runProcess->execute()->shouldNotBeCalled();

        $command = new ComponentAddVersionCommand(self::$rootPath, $runProcess->reveal());
        $command->setApplication($this->mockApplication());
        $tester = new CommandTester($command);

        $tester->execute([
            'component' => 'Example',
            'version' => 'v1beta1',
        ]);

        $this->assertStringContainsString('Version \'v1beta1\' already exists in librarian.yaml', $tester->getDisplay());
    }

    private function mockApplication(bool $shouldCallUpdate = true): Application
    {
        $updateCommand = $this->createMock(Command::class);
        $updateCommand->expects($shouldCallUpdate ? $this->exactly(2) : $this->never())
            ->method('run')
            ->willReturn(0);

        $application = $this->createMock(Application::class);
        $application->method('has')->willReturn(true);
        $application->method('find')->willReturn($updateCommand);

        return $application;
    }
}
