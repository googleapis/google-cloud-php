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

namespace Google\Cloud\Dev\Tests\Unit\BreakingChanges;

use Google\Cloud\Dev\BreakingChanges\Snapshot;
use Google\Cloud\Dev\BreakingChanges\SnapshotBuilder;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Exercises the real git plumbing against a fixture repository.
 *
 * These deliberately avoid test doubles. The failure modes worth guarding here
 * (a deleted file surviving from the baseline, git metadata landing inside the
 * work tree, the baseline omitting export-ignored paths) are all properties of
 * how git and the filesystem actually behave, and a mock would happily assert
 * the buggy version was correct.
 *
 * @group dev
 */
class SnapshotBuilderTest extends TestCase
{
    private const BASELINE = 'baseline';

    private string $rootDir;
    private Filesystem $filesystem;
    private SnapshotBuilder $builder;
    private array $snapshots = [];

    public function setUp(): void
    {
        $this->filesystem = new Filesystem();
        $this->rootDir = sys_get_temp_dir() . '/bc-fixture-' . bin2hex(random_bytes(6));
        $this->filesystem->mkdir($this->rootDir);

        $this->git(['init', '--quiet', '--initial-branch=main']);

        $this->writeComponent('Alpha', [
            'composer.json' => '{"name": "google/alpha"}',
            'src/Foo.php' => '<?php class Foo {}',
            'src/Bar.php' => '<?php class Bar {}',
            'tests/Unit/FooTest.php' => '<?php class FooTest {}',
            // Components export-ignore their tests, which is exactly the case
            // that must not skew the baseline.
            '.gitattributes' => "/tests export-ignore\n",
        ]);
        $this->writeComponent('Beta', [
            'composer.json' => '{"name": "google/beta"}',
            'src/Baz.php' => '<?php class Baz {}',
        ]);
        // A top-level directory that is not a component.
        $this->write('docs/readme.md', 'not a component');

        $this->commitAll('baseline');
        $this->git(['tag', self::BASELINE]);

        $this->builder = new SnapshotBuilder($this->rootDir, $this->filesystem);
    }

    public function tearDown(): void
    {
        foreach ($this->snapshots as $snapshot) {
            $snapshot->remove();
        }
        $this->filesystem->remove($this->rootDir);
    }

    public function testDetectsDeletedFile()
    {
        $this->filesystem->remove($this->rootDir . '/Alpha/src/Bar.php');

        $snapshot = $this->build('Alpha');

        $this->assertSame(['D' => ['src/Bar.php']], $this->changes($snapshot));
        $this->assertFileDoesNotExist($snapshot->getWorkTree() . '/src/Bar.php');
    }

    public function testDetectsModifiedFile()
    {
        $this->write('Alpha/src/Foo.php', '<?php class Foo { public function added() {} }');

        $snapshot = $this->build('Alpha');

        $this->assertSame(['M' => ['src/Foo.php']], $this->changes($snapshot));
    }

    public function testDetectsAddedFile()
    {
        $this->write('Alpha/src/Qux.php', '<?php class Qux {}');

        $snapshot = $this->build('Alpha');

        $this->assertSame(['A' => ['src/Qux.php']], $this->changes($snapshot));
    }

    public function testReturnsNullWhenComponentIsUnchanged()
    {
        $this->assertNull($this->builder->build('Alpha', self::BASELINE));
    }

    public function testReturnsNullWhenComponentIsAbsentFromBaseline()
    {
        $this->writeComponent('Gamma', [
            'composer.json' => '{"name": "google/gamma"}',
            'src/New.php' => '<?php class NewThing {}',
        ]);

        $this->assertNull($this->builder->build('Gamma', self::BASELINE));
    }

    /**
     * The work tree must hold component files and nothing else, so that
     * mirroring the working copy over it with "delete" enabled cannot remove
     * git's own metadata.
     */
    public function testWorkTreeContainsNoGitMetadata()
    {
        $this->write('Alpha/src/Foo.php', '<?php class Foo { public function added() {} }');

        $snapshot = $this->build('Alpha');

        $this->assertFileDoesNotExist($snapshot->getWorkTree() . '/.git');
        $this->assertDirectoryExists($snapshot->getGitDir());
        $this->assertStringStartsNotWith($snapshot->getWorkTree(), $snapshot->getGitDir());
    }

    /**
     * "git archive" honors export-ignore and would drop tests/ from the
     * baseline while the working copy still has it, making every excluded file
     * look like an addition.
     */
    public function testBaselineIncludesExportIgnoredPaths()
    {
        $this->write('Alpha/src/Foo.php', '<?php class Foo { public function added() {} }');

        $snapshot = $this->build('Alpha');

        $this->assertFileExists($snapshot->getWorkTree() . '/tests/Unit/FooTest.php');
        $this->assertArrayNotHasKey('A', $this->changes($snapshot));
    }

    public function testExcludesVendorAndComposerLocal()
    {
        $this->write('Alpha/vendor/autoload.php', '<?php // huge');
        $this->write('Alpha/composer-local.json', '{}');
        $this->write('Alpha/src/Foo.php', '<?php class Foo { public function added() {} }');

        $snapshot = $this->build('Alpha');

        $this->assertFileDoesNotExist($snapshot->getWorkTree() . '/vendor/autoload.php');
        $this->assertFileDoesNotExist($snapshot->getWorkTree() . '/composer-local.json');
    }

    public function testThrowsWhenDirectoryIsNotAComponent()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('no composer.json found');

        $this->builder->build('docs', self::BASELINE);
    }

    public function testGetChangedComponents()
    {
        $this->write('Alpha/src/Foo.php', '<?php class Foo { public function added() {} }');
        $this->write('Beta/src/Baz.php', '<?php class Baz { public function added() {} }');
        $this->commitAll('change two components');

        $this->assertSame(['Alpha', 'Beta'], $this->builder->getChangedComponents(self::BASELINE));
    }

    public function testGetChangedComponentsIgnoresNonComponentDirectories()
    {
        $this->write('docs/readme.md', 'updated');
        $this->write('Alpha/src/Foo.php', '<?php class Foo { public function added() {} }');
        $this->commitAll('change docs and one component');

        $this->assertSame(['Alpha'], $this->builder->getChangedComponents(self::BASELINE));
    }

    public function testGetChangedComponentsReturnsEmptyWhenNothingChanged()
    {
        $this->assertSame([], $this->builder->getChangedComponents(self::BASELINE));
    }

    private function build(string $componentName): Snapshot
    {
        $snapshot = $this->builder->build($componentName, self::BASELINE);
        $this->assertNotNull($snapshot, 'Expected a snapshot to be built');
        $this->snapshots[] = $snapshot;

        return $snapshot;
    }

    /**
     * Name-status of the working copy commit against the baseline commit,
     * grouped by change type.
     *
     * @return array<string, string[]>
     */
    private function changes(Snapshot $snapshot): array
    {
        $process = new Process(
            ['git', 'diff', '--name-status', 'HEAD~1', 'HEAD'],
            $snapshot->getWorkTree(),
            ['GIT_DIR' => $snapshot->getGitDir(), 'GIT_WORK_TREE' => $snapshot->getWorkTree()]
        );
        $process->mustRun();

        $changes = [];
        foreach (array_filter(explode("\n", trim($process->getOutput()))) as $line) {
            [$status, $path] = preg_split('/\s+/', trim($line), 2);
            $changes[$status][] = $path;
        }

        return $changes;
    }

    private function writeComponent(string $name, array $files): void
    {
        foreach ($files as $path => $contents) {
            $this->write($name . '/' . $path, $contents);
        }
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
