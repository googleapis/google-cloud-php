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

use Google\Cloud\Dev\Command\ComponentBreakingChangesCommand;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * @group dev
 */
class ComponentBreakingChangesCommandTest extends TestCase
{
    private string $rootDir;
    private Filesystem $fs;

    protected function setUp(): void
    {
        $this->fs = new Filesystem();
        $this->rootDir = sys_get_temp_dir() . '/bc-cmd-test-' . bin2hex(random_bytes(6));
        $this->fs->mkdir($this->rootDir);

        $this->git(['init', '--quiet', '--initial-branch=main']);
        $this->fs->dumpFile($this->rootDir . '/Alpha/composer.json', '{"name":"google/alpha"}');
        $this->fs->dumpFile($this->rootDir . '/Alpha/src/Foo.php', '<?php class Foo {}');
        $this->fs->dumpFile($this->rootDir . '/Alpha/src/Bar.php', '<?php class Bar {}');
        $this->fs->dumpFile($this->rootDir . '/Alpha/tests/FooTest.php', '<?php class FooTest {}');
        $this->fs->dumpFile($this->rootDir . '/Alpha/.gitattributes', "/tests export-ignore\n");
        $this->fs->dumpFile($this->rootDir . '/Beta/composer.json', '{"name":"google/beta"}');
        $this->fs->dumpFile($this->rootDir . '/Beta/src/Baz.php', '<?php class Baz {}');
        $this->fs->dumpFile($this->rootDir . '/dev/composer.json', '{"name":"google/dev"}');
        $this->fs->dumpFile($this->rootDir . '/dev/tool.php', '<?php // internal');

        $this->commitAll('baseline');
        $this->git(['tag', 'baseline']);
    }

    protected function tearDown(): void
    {
        $this->fs->remove($this->rootDir);
    }

    public function testDetectsDeletedFileAndRetainsExportIgnoredTestsInSnapshot(): void
    {
        $this->fs->remove($this->rootDir . '/Alpha/src/Bar.php');

        $cmd = new ComponentBreakingChangesCommand($this->rootDir);
        $workTree = $cmd->prepareSnapshot('Alpha', 'baseline');

        $this->assertNotNull($workTree);
        try {
            $this->assertDirectoryExists($workTree . '/.git');
            $this->assertFileDoesNotExist($workTree . '/src/Bar.php');
            $this->assertFileExists($workTree . '/tests/FooTest.php');

            $diff = new Process(['git', 'diff', '--name-status', 'HEAD~1', 'HEAD'], $workTree);
            $diff->mustRun();
            $this->assertSame("D\tsrc/Bar.php", trim($diff->getOutput()));
        } finally {
            $this->fs->remove(dirname($workTree));
        }
    }

    public function testIgnoresLowercaseDevPackageAndUnchangedComponents(): void
    {
        $this->fs->dumpFile($this->rootDir . '/dev/tool.php', '<?php // modified');
        $this->commitAll('modify dev only');

        $ran = false;
        $tester = new CommandTester(new ComponentBreakingChangesCommand(
            $this->rootDir,
            function () use (&$ran) {
                $ran = true;
                return [false, ''];
            }
        ));

        $code = $tester->execute(['--base-ref' => 'baseline'], ['capture_stderr_separately' => true]);
        $this->assertSame(Command::SUCCESS, $code);
        $this->assertFalse($ran);
        $this->assertStringContainsString('No components have changed.', $tester->getErrorOutput());
    }

    public function testChecksAllChangedComponentsAcrossRepoWhenNoComponentOptionSupplied(): void
    {
        $this->fs->dumpFile($this->rootDir . '/Alpha/src/Foo.php', '<?php class Foo { public function x(int $a) {} }');
        $this->fs->dumpFile($this->rootDir . '/Beta/src/Baz.php', '<?php class Baz { public function y(int $b) {} }');
        $this->commitAll('break Alpha and Beta');

        $checked = [];
        $runner = function (string $wt) use (&$checked) {
            $composer = json_decode((string) file_get_contents($wt . '/composer.json'), true);
            $checked[] = $composer['name'];
            return [true, "BC break in {$composer['name']}"];
        };
        $tester = new CommandTester(new ComponentBreakingChangesCommand($this->rootDir, $runner));

        $this->assertSame(
            Command::FAILURE,
            $tester->execute(['--base-ref' => 'baseline'], ['capture_stderr_separately' => true])
        );
        $this->assertSame(['google/alpha', 'google/beta'], $checked);
        $this->assertStringContainsString('BC break in google/alpha', $tester->getDisplay());
        $this->assertStringContainsString('BC break in google/beta', $tester->getDisplay());
    }

    public function testComparesTwoReleaseTagsWithoutTouchingWorkingCopy(): void
    {
        $this->git(['tag', 'v0.56.0']);

        $this->fs->dumpFile($this->rootDir . '/Alpha/src/Foo.php', '<?php class Foo { public function inV57() {} }');
        $this->commitAll('release v0.57.0');
        $this->git(['tag', 'v0.57.0']);

        // Modify Beta after v0.57.0 in the working tree; comparing v0.56.0..v0.57.0 should only check Alpha at v0.57.0
        $this->fs->dumpFile($this->rootDir . '/Beta/src/Baz.php', '<?php class Baz { public function postV57() {} }');
        $this->commitAll('post v0.57.0');

        $checked = [];
        $fooContents = null;
        $runner = function (string $wt) use (&$checked, &$fooContents) {
            $composer = json_decode((string) file_get_contents($wt . '/composer.json'), true);
            $checked[] = $composer['name'];
            $fooContents = file_get_contents($wt . '/src/Foo.php');
            return [false, ''];
        };
        $tester = new CommandTester(new ComponentBreakingChangesCommand($this->rootDir, $runner));

        $code = $tester->execute(
            ['--base-ref' => 'v0.56.0', '--target-ref' => 'v0.57.0'],
            ['capture_stderr_separately' => true]
        );
        $this->assertSame(Command::SUCCESS, $code);
        $this->assertSame(['google/alpha'], $checked);
        $this->assertStringContainsString('inV57()', (string) $fooContents);
    }

    public function testRejectsLowercaseComponentName(): void
    {
        $cmd = new ComponentBreakingChangesCommand($this->rootDir);
        $this->expectException(RuntimeException::class);
        $cmd->prepareSnapshot('dev', 'baseline');
    }

    private function commitAll(string $msg): void
    {
        $this->git(['add', '--all']);
        $this->git(['-c', 'user.name=Test', '-c', 'user.email=test@example.com', 'commit', '--quiet', '-m', $msg]);
    }

    private function git(array $args): void
    {
        (new Process(array_merge(['git'], $args), $this->rootDir))->mustRun();
    }
}
