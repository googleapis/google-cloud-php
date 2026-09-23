<?php
/**
 * Copyright 2026 Google LLC
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

use Google\Cloud\Dev\BreakingChanges\SnapshotBuilder;
use Google\Cloud\Dev\Command\ComponentBreakingChangesCommand;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Real git snapshots with a mocked Symfony Process for the Roave call, so the
 * command's own behaviour (component selection, formatting, exit codes) is
 * what is under test.
 *
 * @group dev
 */
class ComponentBreakingChangesCommandTest extends TestCase
{
    private const BASELINE = 'baseline';

    private string $rootDir;
    private Filesystem $filesystem;

    public function setUp(): void
    {
        $this->filesystem = new Filesystem();
        $this->rootDir = sys_get_temp_dir() . '/bc-cmd-' . bin2hex(random_bytes(6));
        $this->filesystem->mkdir($this->rootDir);

        $this->git(['init', '--quiet', '--initial-branch=main']);
        $this->write('Alpha/composer.json', '{"name": "google/alpha"}');
        $this->write('Alpha/src/Foo.php', '<?php class Foo {}');
        $this->write('Beta/composer.json', '{"name": "google/beta"}');
        $this->write('Beta/src/Baz.php', '<?php class Baz {}');
        $this->commitAll('baseline');
        $this->git(['tag', self::BASELINE]);
    }

    public function tearDown(): void
    {
        $this->filesystem->remove($this->rootDir);
    }

    public function testFailsWhenBreakingChangesAreFound()
    {
        $this->changeComponent('Alpha');
        $tester = $this->tester(['Alpha']);

        $exitCode = $tester->execute(['-c' => ['Alpha'], '--base-ref' => self::BASELINE]);

        $this->assertSame(Command::FAILURE, $exitCode);
        $this->assertStringContainsString('BREAK in Alpha', $tester->getDisplay());
    }

    public function testSucceedsWhenNoBreakingChangesAreFound()
    {
        $this->changeComponent('Alpha');
        $tester = $this->tester([]);

        $exitCode = $tester->execute(['-c' => ['Alpha'], '--base-ref' => self::BASELINE]);

        $this->assertSame(Command::SUCCESS, $exitCode);
        $this->assertStringContainsString('No breaking changes detected', $tester->getDisplay());
    }

    public function testMarkdownFormatWrapsEachComponentInDetails()
    {
        $this->changeComponent('Alpha');
        $tester = $this->tester(['Alpha']);

        $tester->execute([
            '-c' => ['Alpha'],
            '--base-ref' => self::BASELINE,
            '--format' => 'markdown',
        ], ['capture_stderr_separately' => true]);

        $this->assertStringContainsString(
            "<details>\n<summary><b>Alpha</b></summary>",
            $tester->getDisplay()
        );
        $this->assertStringContainsString('</details>', $tester->getDisplay());
    }

    /**
     * The markdown report has to be pipeable, so progress must not be
     * interleaved into stdout.
     */
    public function testProgressGoesToStderrLeavingStdoutClean()
    {
        $this->changeComponent('Alpha');
        $tester = $this->tester(['Alpha']);

        $tester->execute([
            '-c' => ['Alpha'],
            '--base-ref' => self::BASELINE,
            '--format' => 'markdown',
        ], ['capture_stderr_separately' => true]);

        $this->assertStringStartsWith('<details>', trim($tester->getDisplay()));
        $this->assertStringNotContainsString('Checking Alpha', $tester->getDisplay());
        $this->assertStringContainsString('Checking Alpha', $tester->getErrorOutput());
    }

    public function testChecksOnlyTheRequestedComponents()
    {
        $this->changeComponent('Alpha');
        $this->changeComponent('Beta');
        $checked = [];
        $tester = $this->tester([], $checked);

        $tester->execute(['-c' => ['Beta'], '--base-ref' => self::BASELINE]);

        $this->assertSame(['Beta'], $checked);
    }

    public function testDetectsChangedComponentsWhenNoneAreRequested()
    {
        $this->changeComponent('Beta');
        $this->commitAll('change Beta');
        $checked = [];
        $tester = $this->tester([], $checked);

        $tester->execute(['--base-ref' => self::BASELINE]);

        $this->assertSame(['Beta'], $checked);
    }

    public function testSkipsComponentsWithNothingToCompare()
    {
        $checked = [];
        $tester = $this->tester([], $checked);

        $exitCode = $tester->execute(['-c' => ['Alpha'], '--base-ref' => self::BASELINE]);

        $this->assertSame(Command::SUCCESS, $exitCode);
        $this->assertSame([], $checked, 'Roave should not run for an unchanged component');
        $this->assertStringContainsString('nothing to compare', $tester->getDisplay());
    }

    public function testReportsNothingWhenNoComponentsChanged()
    {
        $tester = $this->tester([]);

        $exitCode = $tester->execute(['--base-ref' => self::BASELINE]);

        $this->assertSame(Command::SUCCESS, $exitCode);
        $this->assertStringContainsString('No components have changed', $tester->getDisplay());
    }

    public function testRejectsAnUnknownFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid format "xml"');

        $this->tester([])->execute([
            '-c' => ['Alpha'],
            '--base-ref' => self::BASELINE,
            '--format' => 'xml',
        ]);
    }

    /**
     * @param string[] $breaking Components the mocked Roave process reports breaks for
     * @param string[] $checked Populated with the components Roave ran against
     */
    private function tester(array $breaking, array &$checked = []): CommandTester
    {
        $processFactory = function (string $workTree) use ($breaking, &$checked): Process {
            preg_match('/^bc-check-(.+)-[0-9a-f]+$/', basename($workTree), $matches);
            $name = $matches[1];
            $checked[] = $name;
            $hasBreaks = in_array($name, $breaking, true);

            $process = $this->createMock(Process::class);
            $process->method('isSuccessful')->willReturn(!$hasBreaks);
            $process->method('getOutput')->willReturn($hasBreaks ? 'BREAK in ' . $name : '');
            $process->method('getErrorOutput')->willReturn('');

            return $process;
        };

        return new CommandTester(new ComponentBreakingChangesCommand(
            $this->rootDir,
            new SnapshotBuilder($this->rootDir, $this->filesystem),
            $processFactory,
            $this->filesystem
        ));
    }

    private function changeComponent(string $name): void
    {
        $this->write($name . '/src/Added.php', '<?php class Added {}');
    }

    private function write(string $path, string $contents): void
    {
        $this->filesystem->dumpFile($this->rootDir . '/' . $path, $contents);
    }

    private function commitAll(string $message): void
    {
        $this->git(['add', '--all']);
        $this->git([
            '-c', 'user.name=Test',
            '-c', 'user.email=test@example.com',
            'commit', '--quiet', '--message', $message,
        ]);
    }

    private function git(array $args): void
    {
        (new Process(array_merge(['git'], $args), $this->rootDir))->mustRun();
    }
}
