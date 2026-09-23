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
     * A directory counts as a component when it holds a composer.json, so a
     * new top-level directory can never be mistaken for one, and no naming
     * convention has to be assumed.
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

    private function isComponent(string $name): bool
    {
        return is_file($this->rootDir . '/' . $name . '/composer.json');
    }

    /**
     * Build a scratch repository for $componentName with the baseline as the
     * first commit and the working copy as the second.
     *
     * @return Snapshot|null Null when there is nothing to compare: either the
     *     component is absent from the baseline (entirely new, so every symbol
     *     in it is an addition), or it is byte-identical to the baseline.
     */
    public function build(string $componentName, string $baseRef): ?Snapshot
    {
        $componentPath = $this->rootDir . '/' . $componentName;
        if (!is_file($componentPath . '/composer.json')) {
            throw new RuntimeException(sprintf(
                'Cannot check "%s": no composer.json found at %s.',
                $componentName,
                $componentPath
            ));
        }

        if (!$this->existsInBaseline($componentName, $baseRef)) {
            return null;
        }

        $scratchDir = $this->createScratchDir();
        $gitDir = $scratchDir . '/git';
        $workTree = $scratchDir . '/tree';
        $this->filesystem->mkdir([$gitDir, $workTree]);

        // The git directory is deliberately kept outside of the work tree, so
        // the work tree holds nothing but component files. Mirroring over it
        // with "delete" enabled therefore cannot corrupt git metadata.
        $this->gitScratch($gitDir, $workTree, ['init', '--quiet', '--initial-branch=main']);

        $this->extractBaseline($componentName, $baseRef, $workTree, $scratchDir . '/index');
        $this->gitScratch($gitDir, $workTree, ['add', '--all']);
        $this->commit($gitDir, $workTree, 'Baseline from ' . $baseRef);

        $this->mirrorWorkingCopy($componentPath, $workTree);
        $this->gitScratch($gitDir, $workTree, ['add', '--all']);

        if ($this->isIdenticalToBaseline($gitDir, $workTree)) {
            $this->filesystem->remove($scratchDir);
            return null;
        }

        $this->commit($gitDir, $workTree, 'Working copy');

        return new Snapshot($componentName, $workTree, $gitDir, $scratchDir, $this->filesystem);
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
     * Copy the working copy of the component over the baseline.
     *
     * "delete" is essential: without it, a file deleted by the change under
     * test would survive from the baseline, and removing a public class (the
     * most clear-cut breaking change there is) would go undetected.
     */
    private function mirrorWorkingCopy(string $componentPath, string $workTree): void
    {
        $finder = Finder::create()
            ->in($componentPath)
            ->exclude(self::EXCLUDED_FROM_WORKING_COPY)
            ->notName(self::EXCLUDED_FROM_WORKING_COPY)
            ->ignoreDotFiles(false)
            ->ignoreVCS(false);

        $this->filesystem->mirror($componentPath, $workTree, $finder, [
            'override' => true,
            'delete' => true,
        ]);
    }

    private function isIdenticalToBaseline(string $gitDir, string $workTree): bool
    {
        $process = new Process(
            ['git', 'diff', '--cached', '--quiet'],
            $workTree,
            $this->scratchEnv($gitDir, $workTree)
        );
        $process->run();

        return $process->isSuccessful();
    }

    private function commit(string $gitDir, string $workTree, string $message): void
    {
        // Identity is supplied per-invocation so the command does not depend on
        // the machine having git user config, and never mutates it.
        $this->gitScratch($gitDir, $workTree, [
            '-c', 'user.name=Breaking Change Detector',
            '-c', 'user.email=noreply@google.com',
            'commit', '--quiet', '--allow-empty', '--message', $message,
        ]);
    }

    private function gitScratch(string $gitDir, string $workTree, array $args): string
    {
        return $this->git($args, $workTree, $this->scratchEnv($gitDir, $workTree));
    }

    /**
     * @return array<string, string>
     */
    private function scratchEnv(string $gitDir, string $workTree): array
    {
        return ['GIT_DIR' => $gitDir, 'GIT_WORK_TREE' => $workTree];
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

    private function createScratchDir(): string
    {
        $dir = sys_get_temp_dir() . '/bc-check-' . bin2hex(random_bytes(6));
        $this->filesystem->mkdir($dir);

        return $dir;
    }
}
