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

namespace Google\Cloud\Dev\BreakingChanges;

use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

/**
 * Git operations backing the backwards compatibility check.
 *
 * The check compares two revisions of a repository whose root is the package
 * root, but components live in subdirectories of this monorepo. Each component
 * is therefore extracted to the root of a scratch repository, and the working
 * copy is layered on top as a second commit.
 *
 * @internal
 */
class SnapshotBuilder
{
    /**
     * Not part of the published package, and expensive to copy.
     */
    private const EXCLUDED_FROM_WORKING_COPY = ['vendor', 'composer-local.json'];

    private Filesystem $filesystem;

    public function __construct(
        private string $rootDir,
        ?Filesystem $filesystem = null
    ) {
        $this->rootDir = rtrim($rootDir, '/');
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    /**
     * Components with files modified relative to $baseRef.
     *
     * @return string[]
     */
    public function getChangedComponents(string $baseRef): array
    {
        $output = $this->git(['diff', '--name-only', $baseRef], $this->rootDir);

        $changed = [];
        foreach (explode("\n", trim($output)) as $path) {
            $name = strtok(trim($path), '/');
            if ($name && !isset($changed[$name]) && $this->isComponent($name)) {
                $changed[$name] = true;
            }
        }

        $names = array_keys($changed);
        sort($names);

        return $names;
    }

    /**
     * Components are the capitalized top-level directories holding a
     * composer.json. The capitalization requirement is what separates a
     * component from repository tooling: "dev" is a composer package too, but
     * it is not published, and checking it is meaningless.
     */
    private function isComponent(string $name): bool
    {
        return (bool) preg_match('/^[A-Z]/', $name)
            && is_file($this->rootDir . '/' . $name . '/composer.json');
    }

    /**
     * Build a scratch repository for $componentName with the baseline as the
     * first commit and the working copy as the second.
     *
     * @return string|null Path to the scratch repository work tree, or null
     *     when there is nothing to compare (either the component is absent
     *     from the baseline or byte-identical to it).
     */
    public function build(string $componentName, string $baseRef): ?string
    {
        if (!$this->isComponent($componentName)) {
            throw new RuntimeException(sprintf(
                'Cannot check "%s": not a component. Components are capitalized '
                    . 'top-level directories containing a composer.json.',
                $componentName
            ));
        }

        if (!$this->existsInBaseline($componentName, $baseRef)) {
            return null;
        }

        $workTree = $this->createScratchDir($componentName);

        // Roave locates the repository by looking for a ".git" directory at the
        // root of the directory it runs in, so git metadata cannot be moved out
        // of the work tree. See mirrorWorkingCopy() for why that matters.
        $this->git(['init', '--quiet', '--initial-branch=main'], $workTree);

        $this->extractBaseline($componentName, $baseRef, $workTree, $workTree . '/.git/bc-index');
        $this->git(['add', '--all'], $workTree);
        $this->commit($workTree, 'Baseline from ' . $baseRef);

        $this->mirrorWorkingCopy($this->rootDir . '/' . $componentName, $workTree);
        $this->git(['add', '--all'], $workTree);

        if ($this->isIdenticalToBaseline($workTree)) {
            $this->filesystem->remove($workTree);
            return null;
        }

        $this->commit($workTree, 'Working copy');

        return $workTree;
    }

    private function existsInBaseline(string $componentName, string $baseRef): bool
    {
        $process = new Process(
            ['git', 'rev-parse', '--verify', '--quiet', sprintf('%s:%s', $baseRef, $componentName)],
            $this->rootDir
        );
        $process->run();

        return $process->isSuccessful();
    }

    /**
     * Read the component's subtree into a scratch index and check it out at the
     * root of the work tree.
     *
     * A temporary index is used rather than "git archive" because archives
     * honor "export-ignore", which would omit tests and config from the
     * baseline while the working copy still contains them. That asymmetry would
     * show every excluded file as a spurious addition.
     */
    private function extractBaseline(
        string $componentName,
        string $baseRef,
        string $workTree,
        string $indexFile
    ): void {
        $env = ['GIT_INDEX_FILE' => $indexFile];

        $this->git(['read-tree', sprintf('%s:%s', $baseRef, $componentName)], $this->rootDir, $env);
        $this->git(['checkout-index', '--all', '--prefix=' . $workTree . '/'], $this->rootDir, $env);

        $this->filesystem->remove($indexFile);
    }

    /**
     * Replace the baseline in the work tree with the working copy.
     *
     * The baseline is cleared rather than copied over: without that, a file
     * deleted by the change under test would survive, and removing a public
     * class (the most clear-cut breaking change there is) would go undetected.
     * Git metadata is the one thing that has to outlive the clear.
     */
    private function mirrorWorkingCopy(string $componentPath, string $workTree): void
    {
        $this->filesystem->remove(
            Finder::create()
                ->in($workTree)
                ->depth(0)
                ->exclude('.git')
                ->ignoreDotFiles(false)
                ->ignoreVCS(false)
        );

        $finder = Finder::create()
            ->in($componentPath)
            ->exclude(self::EXCLUDED_FROM_WORKING_COPY)
            ->notName(self::EXCLUDED_FROM_WORKING_COPY)
            ->ignoreDotFiles(false)
            ->ignoreVCS(false);

        $this->filesystem->mirror($componentPath, $workTree, $finder);
    }

    private function isIdenticalToBaseline(string $workTree): bool
    {
        $process = new Process(['git', 'diff', '--cached', '--quiet'], $workTree);
        $process->run();

        return $process->isSuccessful();
    }

    private function commit(string $workTree, string $message): void
    {
        // Identity is supplied per-invocation so the command does not depend on
        // the machine having git user config, and never mutates it.
        $this->git([
            '-c', 'user.name=Breaking Change Detector',
            '-c', 'user.email=noreply@google.com',
            'commit', '--quiet', '--allow-empty', '--message', $message,
        ], $workTree);
    }

    /**
     * @param string[] $args
     * @param array<string, string> $env
     */
    private function git(array $args, string $cwd, array $env = []): string
    {
        $process = new Process(array_merge(['git'], $args), $cwd, $env);
        $process->setTimeout(300);
        $process->mustRun();

        return $process->getOutput();
    }

    private function createScratchDir(string $componentName): string
    {
        $dir = sprintf('%s/bc-check-%s-%s', sys_get_temp_dir(), $componentName, bin2hex(random_bytes(6)));
        $this->filesystem->mkdir($dir);

        return $dir;
    }
}
