<?php

namespace Google\Cloud\Dev\Tests\Unit\Command;

use Google\Cloud\Dev\Command\NewVersionCommand;
use Google\Cloud\Dev\Component;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

class NewVersionCommandTest extends TestCase
{
    private static $rootPath;
    private static $componentPath;
    private static $owlbotFile;

    public static function setUpBeforeClass(): void
    {
        self::$rootPath = sys_get_temp_dir() . '/google-cloud-php-tests';
        self::$componentPath = self::$rootPath . '/component';
        self::$owlbotFile = self::$componentPath . '/.OwlBot.yaml';
        $filesystem = new Filesystem();
        $filesystem->mirror(__DIR__ . '/../../fixtures/component', self::$componentPath);
    }

    public static function tearDownAfterClass(): void
    {
        $filesystem = new Filesystem();
        $filesystem->remove(self::$rootPath);
    }

    public function testAddNewVersion()
    {
        $command = new NewVersionCommand(self::$rootPath);
        $command->setApplication($this->mockApplication());
        $tester = new CommandTester($command);

        $tester->execute([
            'component' => 'component',
            'version' => 'v2',
        ]);

        $this->assertStringContainsString('Adding new version \'v2\' to .OwlBot.yaml', $tester->getDisplay());
        $this->assertStringContainsString('(v1|v1beta1|v2)', file_get_contents(self::$owlbotFile));
    }

    public function testAddNewVersionNoUpdate()
    {
        $command = new NewVersionCommand(self::$rootPath);
        $command->setApplication($this->mockApplication(false));
        $tester = new CommandTester($command);

        $tester->execute([
            'component' => 'component',
            'version' => 'v3',
            '--no-update-component' => true,
        ]);

        $this->assertStringContainsString('Adding new version \'v3\' to .OwlBot.yaml', $tester->getDisplay());
        $this->assertStringContainsString('(v1|v1beta1|v2|v3)', file_get_contents(self::$owlbotFile));
        $this->assertStringContainsString('Skipping component update', $tester->getDisplay());
    }

    public function testDoesNotUpdateOwlBotIfVersionExists()
    {
        $command = new NewVersionCommand(self::$rootPath);
        $command->setApplication($this->mockApplication());
        $tester = new CommandTester($command);

        $tester->execute([
            'component' => 'component',
            'version' => 'v1beta1',
        ]);

        $this->assertStringContainsString('Adding new version \'v1beta1\' to .OwlBot.yaml', $tester->getDisplay());
        $this->assertStringContainsString('Version \'v1beta1\' already exists in deep-copy-regex', $tester->getDisplay());
        $this->assertStringContainsString('(v1|v1beta1|v2|v3)', file_get_contents(self::$owlbotFile));
    }

    private function mockApplication(bool $shouldCallUpdate = true): Application
    {
        $updateCommand = $this->createMock(Command::class);
        $updateCommand->expects($shouldCallUpdate ? $this->exactly(2) : $this->once())
            ->method('run')
            ->willReturn(0);

        $application = $this->createMock(Application::class);
        $application->method('has')->willReturn(true);
        $application->method('find')->willReturn($updateCommand);

        return $application;
    }
}