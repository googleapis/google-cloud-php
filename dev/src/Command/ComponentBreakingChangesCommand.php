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
use InvalidArgumentException;
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
 * Detect backwards compatibility breaks across components with a bounded parallel Process pool.
 *
 * @internal
 */
class ComponentBreakingChangesCommand extends Command
{
    private const FORMATS = ['github-actions', 'markdown'];
    private const EXCLUDED = ['vendor', 'composer-local.json'];

    private string $rootDir;
    private Filesystem $fs;
    private ?Closure $processFactory;

    public function __construct(string $rootDir, ?Closure $processFactory = null)
    {
        $this->rootDir = rtrim($rootDir, '/');
        $this->fs = new Filesystem();
        $this->processFactory = $processFactory;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('component:breaking-changes')
            ->setDescription('Detect backwards compatibility breaks in modified components (parallel)')
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Component name(s) to check (defaults to components changed vs --base-ref)',
                []
            )
            ->addOption('base-ref', null, InputOption::VALUE_REQUIRED, 'Git ref to compare against', 'origin/main')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'Output format (github-actions, markdown)', 'github-actions')
            ->addOption('jobs', 'j', InputOption::VALUE_REQUIRED, 'Maximum parallel Roave workers', '4')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Report breaking changes without exiting non-zero')
            ->addOption('report-only', null, InputOption::VALUE_NONE, 'Alias for --dry-run');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $format = $input->getOption('format');
        if (!in_array($format, self::FORMATS, true)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid format "%s". Expected one of: %s.',
                $format,
                implode(', ', self::FORMATS)
            ));
        }

        $jobs = max(1, (int) $input->getOption('jobs'));
        $baseRef = $input->getOption('base-ref');
        $dryRun = $input->getOption('dry-run') || $input->getOption('report-only');
        $err = $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output;

        $components = $input->getOption('component') ?: $this->getChangedComponents($baseRef);
        if (!$components) {
            $err->writeln('No components have changed.');
            return Command::SUCCESS;
        }

        $queue = [];
        foreach ($components as $name) {
            $workTree = $this->prepareSnapshot($name, $baseRef);
            if (null === $workTree) {
                $err->writeln(sprintf('  <info>skipped</info> %s', $name));
                continue;
            }
            $queue[] = ['name' => $name, 'workTree' => $workTree];
        }

        $results = $this->runPool($queue, $format, $jobs, $err);
        $breaks = [];
        foreach ($components as $name) {
            if (isset($results[$name]) && $results[$name]['hasBreaks']) {
                $breaks[$name] = $results[$name]['output'];
            }
        }

        if (!$breaks) {
            $err->writeln('No breaking changes detected.');
            return Command::SUCCESS;
        }

        if ('markdown' === $format) {
            foreach ($breaks as $name => $details) {
                $output->write(sprintf("<details>\n<summary><b>%s</b></summary>\n\n%s\n\n</details>\n\n", $name, trim($details)));
            }
        } else {
            $output->write(implode("\n", $breaks) . "\n");
        }

        return $dryRun ? Command::SUCCESS : Command::FAILURE;
    }

    /**
     * @param array<int, array{name: string, workTree: string}> $queue
     * @return array<string, array{hasBreaks: bool, output: string}>
     */
    private function runPool(array $queue, string $format, int $jobs, OutputInterface $err): array
    {
        $running = [];
        $results = [];

        try {
            while ($queue || $running) {
                while (count($running) < $jobs && $queue) {
                    $item = array_shift($queue);
                    $err->writeln(sprintf('Checking %s', $item['name']));
                    $process = $this->createRoaveProcess($item['workTree'], $format);
                    $process->start();
                    $running[] = ['item' => $item, 'process' => $process];
                }

                foreach ($running as $idx => $slot) {
                    if (!$slot['process']->isRunning()) {
                        $proc = $slot['process'];
                        $name = $slot['item']['name'];
                        $hasBreaks = 0 !== $proc->getExitCode();
                        $results[$name] = [
                            'hasBreaks' => $hasBreaks,
                            'output' => $proc->getOutput() . $proc->getErrorOutput(),
                        ];
                        $err->writeln(sprintf(
                            '  <%s>%s</%1$s> %s',
                            $hasBreaks ? 'error' : 'info',
                            $hasBreaks ? 'breaking changes' : 'ok',
                            $name
                        ));
                        $this->fs->remove(dirname($slot['item']['workTree']));
                        unset($running[$idx]);
                    }
                }

                if ($running) {
                    usleep(20000);
                }
            }
        } finally {
            foreach ($running as $slot) {
                $slot['process']->stop(0);
                $this->fs->remove(dirname($slot['item']['workTree']));
            }
            foreach ($queue as $item) {
                $this->fs->remove(dirname($item['workTree']));
            }
        }

        return $results;
    }

    private function createRoaveProcess(string $workTree, string $format): Process
    {
        if ($this->processFactory) {
            return ($this->processFactory)($workTree, $format);
        }

        $default = getenv('HOME') . '/.composer/vendor/bin/roave-backward-compatibility-check';
        $bin = (new ExecutableFinder())->find('roave-backward-compatibility-check', $default);
        if (!is_executable((string) $bin)) {
            throw new RuntimeException('roave-backward-compatibility-check binary not found.');
        }

        $proc = new Process([$bin, '--from=HEAD~1', '--format=' . $format], $workTree);
        $proc->setTimeout(600);

        return $proc;
    }

    private function getChangedComponents(string $baseRef): array
    {
        $diff = $this->git(['diff', '--name-only', $baseRef], $this->rootDir);
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

    private function isComponent(string $name): bool
    {
        return (bool) preg_match('/^[A-Z]/', $name)
            && is_file($this->rootDir . '/' . $name . '/composer.json');
    }

    public function prepareSnapshot(string $name, string $baseRef): ?string
    {
        if (!$this->isComponent($name)) {
            throw new RuntimeException(sprintf('"%s" is not a valid component.', $name));
        }

        $check = new Process(['git', 'rev-parse', '--verify', '--quiet', "$baseRef:$name"], $this->rootDir);
        $check->run();
        if (!$check->isSuccessful()) {
            return null;
        }

        $scratch = sys_get_temp_dir() . '/bc-' . bin2hex(random_bytes(6));
        $workTree = $scratch . '/tree';
        $indexFile = $scratch . '/index';
        $this->fs->mkdir($workTree);

        $this->git(['init', '--quiet', '--initial-branch=main'], $workTree);
        $this->git(['read-tree', "$baseRef:$name"], $this->rootDir, ['GIT_INDEX_FILE' => $indexFile]);
        $this->git(['checkout-index', '--all', '--prefix=' . $workTree . '/'], $this->rootDir, ['GIT_INDEX_FILE' => $indexFile]);
        $this->fs->remove($indexFile);

        $this->git(['add', '--all'], $workTree);
        $this->commit($workTree, 'Baseline');

        $this->fs->remove(
            Finder::create()->in($workTree)->depth(0)->exclude('.git')->ignoreDotFiles(false)->ignoreVCS(false)
        );
        $this->fs->mirror(
            $this->rootDir . '/' . $name,
            $workTree,
            Finder::create()->in($this->rootDir . '/' . $name)
                ->exclude(self::EXCLUDED)->notName(self::EXCLUDED)->ignoreDotFiles(false)->ignoreVCS(false)
        );

        $this->git(['add', '--all'], $workTree);
        $diff = new Process(['git', 'diff', '--cached', '--quiet'], $workTree);
        $diff->run();
        if ($diff->isSuccessful()) {
            $this->fs->remove($scratch);
            return null;
        }

        $this->commit($workTree, 'Working copy');

        return $workTree;
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
