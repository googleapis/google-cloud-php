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

namespace Google\Cloud\Dev\Command;

use Closure;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Single-file command to detect backwards compatibility breaks per component.
 *
 * @internal
 */
class ComponentBreakingChangesCommand extends Command
{
    private const EXCLUDED = ['vendor', 'composer-local.json'];

    private string $rootDir;
    private Filesystem $fs;
    private ?Closure $roaveRunner;

    public function __construct(string $rootDir, ?Closure $roaveRunner = null)
    {
        $this->rootDir = rtrim($rootDir, '/');
        $this->fs = new Filesystem();
        $this->roaveRunner = $roaveRunner;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('component:breaking-changes')
            ->setDescription('Detect backwards compatibility breaks in modified components')
            ->setHelp(<<<EOF
Check all components modified relative to the base ref:

    ./dev/google-cloud component:breaking-changes

Check breaking changes between two release tags:

    ./dev/google-cloud component:breaking-changes --base-ref=v0.56.0 --target-ref=v0.57.0

Check specific components:

    ./dev/google-cloud component:breaking-changes -c Storage -c BigQuery
EOF)
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Component name(s) to check (defaults to components changed vs --base-ref)',
                []
            )
            ->addOption('base-ref', null, InputOption::VALUE_REQUIRED, 'Git ref to compare from', 'origin/main')
            ->addOption(
                'target-ref',
                null,
                InputOption::VALUE_REQUIRED,
                'Git ref to compare to (defaults to working copy)'
            )
            ->addOption('ga-only', null, InputOption::VALUE_NONE, 'Only check GA (>= 1.0.0) components');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $baseRef = $input->getOption('base-ref');
        $targetRef = $input->getOption('target-ref');
        $err = $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output;

        $components = $input->getOption('component') ?: $this->getChangedComponents($baseRef, $targetRef);
        if ($input->getOption('ga-only')) {
            $components = array_values(array_filter(
                $components,
                fn(string $name) => $this->isGaComponent($name, $targetRef)
            ));
        }
        if (!$components) {
            $err->writeln('No components have changed.');
            return Command::SUCCESS;
        }

        $breaks = [];
        foreach ($components as $name) {
            $err->writeln(sprintf('Checking %s (%s...%s)', $name, $baseRef, $targetRef ?: 'working copy'));
            $workTree = $this->prepareSnapshot($name, $baseRef, $targetRef);
            if (null === $workTree) {
                $err->writeln(sprintf('  <info>skipped</info> %s', $name));
                continue;
            }

            try {
                [$hasBreaks, $roaveOutput] = $this->runRoave($workTree);
            } finally {
                $this->fs->remove(dirname($workTree));
            }

            if ($hasBreaks) {
                $breaks[$name] = $roaveOutput;
                $err->writeln(sprintf('  <error>breaking changes</error> %s', $name));
            } else {
                $err->writeln(sprintf('  <info>ok</info> %s', $name));
            }
        }

        if (!$breaks) {
            $err->writeln('No breaking changes detected.');
            return Command::SUCCESS;
        }

        $output->write(implode("\n", $breaks) . "\n");

        return Command::FAILURE;
    }

    private function getChangedComponents(string $baseRef, ?string $targetRef = null): array
    {
        $diffArgs = $targetRef ? ['diff', '--name-only', $baseRef, $targetRef] : ['diff', '--name-only', $baseRef];
        $diff = $this->git($diffArgs, $this->rootDir);
        $names = [];
        foreach (array_filter(explode("\n", trim($diff))) as $path) {
            $top = strtok($path, '/');
            if ($top && $this->isComponent($top)) {
                $names[$top] = true;
            }
        }
        $result = array_keys($names);
        sort($result);

        return $result;
    }

    /**
     * Capitalized top-level directories with a composer.json are published
     * components; lowercase directories (like "dev") are internal tooling.
     */
    private function isComponent(string $name): bool
    {
        return (bool) preg_match('/^[A-Z]/', $name)
            && is_file($this->rootDir . '/' . $name . '/composer.json');
    }

    /**
     * Only check GA (>= 1.0.0) components; skip 0.x preview components.
     */
    private function isGaComponent(string $name, ?string $targetRef = null): bool
    {
        if (null !== $targetRef) {
            $show = new Process(['git', 'show', "$targetRef:$name/VERSION"], $this->rootDir);
            $show->run();
            if ($show->isSuccessful()) {
                return version_compare(trim($show->getOutput()), '1.0.0', '>=');
            }
        }

        $versionFile = $this->rootDir . '/' . $name . '/VERSION';
        if (!is_file($versionFile)) {
            return true;
        }

        return version_compare(trim((string) file_get_contents($versionFile)), '1.0.0', '>=');
    }

    public function prepareSnapshot(string $name, string $baseRef, ?string $targetRef = null): ?string
    {
        if (!$this->isComponent($name)) {
            throw new RuntimeException(sprintf('"%s" is not a valid component.', $name));
        }

        if (!$this->existsInRef($name, $baseRef)) {
            return null;
        }

        $scratch = sys_get_temp_dir() . '/bc-' . bin2hex(random_bytes(6));
        $workTree = $scratch . '/tree';
        $indexFile = $scratch . '/index';
        $this->fs->mkdir($workTree);

        // Roave requires a real ".git" directory at the root of $workTree.
        // Use a temporary index (read-tree + checkout-index) instead of "git archive"
        // so export-ignored paths in .gitattributes (e.g. tests/) are preserved in the baseline.
        $this->git(['init', '--quiet', '--initial-branch=main'], $workTree);
        $this->extractComponentAtRef($name, $baseRef, $workTree, $indexFile);

        $this->git(['add', '--all'], $workTree);
        $this->commit($workTree, 'Baseline');

        // Clear baseline files (except .git) before applying the target state so
        // deleted files and removed classes are detected by the diff.
        $this->fs->remove(
            Finder::create()->in($workTree)->depth(0)->exclude('.git')->ignoreDotFiles(false)->ignoreVCS(false)
        );
        if (null !== $targetRef) {
            if ($this->existsInRef($name, $targetRef)) {
                $this->extractComponentAtRef($name, $targetRef, $workTree, $indexFile);
            }
        } else {
            $this->fs->mirror(
                $this->rootDir . '/' . $name,
                $workTree,
                Finder::create()->in($this->rootDir . '/' . $name)
                    ->exclude(self::EXCLUDED)->notName(self::EXCLUDED)->ignoreDotFiles(false)->ignoreVCS(false)
            );
        }

        $this->git(['add', '--all'], $workTree);
        $diff = new Process(['git', 'diff', '--cached', '--quiet'], $workTree);
        $diff->run();
        if ($diff->isSuccessful()) {
            $this->fs->remove($scratch);
            return null;
        }

        $this->commit($workTree, 'Target');

        return $workTree;
    }

    private function existsInRef(string $name, string $ref): bool
    {
        $check = new Process(['git', 'rev-parse', '--verify', '--quiet', "$ref:$name"], $this->rootDir);
        $check->run();

        return $check->isSuccessful();
    }

    private function extractComponentAtRef(string $name, string $ref, string $workTree, string $indexFile): void
    {
        $env = ['GIT_INDEX_FILE' => $indexFile];
        $this->git(['read-tree', "$ref:$name"], $this->rootDir, $env);
        $this->git(['checkout-index', '--all', '--prefix=' . $workTree . '/'], $this->rootDir, $env);
        $this->fs->remove($indexFile);
    }

    /**
     * @return array{bool, string}
     */
    private function runRoave(string $workTree): array
    {
        if ($this->roaveRunner) {
            return ($this->roaveRunner)($workTree);
        }

        $default = getenv('HOME') . '/.composer/vendor/bin/roave-backward-compatibility-check';
        $bin = (new ExecutableFinder())->find('roave-backward-compatibility-check', $default);
        if (!is_executable((string) $bin)) {
            throw new RuntimeException('roave-backward-compatibility-check binary not found.');
        }

        $proc = new Process([$bin, '--from=HEAD~1', '--format=github-actions'], $workTree);
        $proc->setTimeout(600);
        $proc->run();

        return [0 !== $proc->getExitCode(), $proc->getOutput() . $proc->getErrorOutput()];
    }

    private function commit(string $cwd, string $msg): void
    {
        $this->git([
            '-c', 'user.name=BC Detector',
            '-c', 'user.email=noreply@google.com',
            'commit', '--quiet', '--allow-empty', '-m', $msg,
        ], $cwd);
    }

    private function git(array $args, string $cwd, array $env = []): string
    {
        $p = new Process(array_merge(['git'], $args), $cwd, $env);
        $p->setTimeout(300);
        $p->mustRun();

        return $p->getOutput();
    }
}
