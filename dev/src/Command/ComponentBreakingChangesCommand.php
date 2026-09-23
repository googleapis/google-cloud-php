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

use Google\Cloud\Dev\BreakingChanges\SnapshotBuilder;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Detect backwards compatibility breaks in one or more components.
 *
 * @internal
 */
class ComponentBreakingChangesCommand extends Command
{
    public const FORMAT_GITHUB_ACTIONS = 'github-actions';
    public const FORMAT_MARKDOWN = 'markdown';
    public const ROAVE_BINARY = 'roave-backward-compatibility-check';

    private const FORMATS = [self::FORMAT_GITHUB_ACTIONS, self::FORMAT_MARKDOWN];

    private SnapshotBuilder $snapshots;
    private Filesystem $filesystem;
    /** @var callable(string, string): Process */
    private $processFactory;
    private ?string $roaveBinary = null;

    public function __construct(
        string $rootDir,
        ?SnapshotBuilder $snapshots = null,
        ?callable $processFactory = null,
        ?Filesystem $filesystem = null
    ) {
        $this->snapshots = $snapshots ?: new SnapshotBuilder($rootDir);
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->processFactory = $processFactory ?: function (string $workTree, string $format): Process {
            return (new Process(
                [$this->getRoaveBinary(), '--from=HEAD~1', '--format=' . $format],
                $workTree
            ))->setTimeout(600);
        };

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('component:breaking-changes')
            ->setDescription('Detect backwards compatibility breaks in components')
            ->setHelp(<<<EOF
Check every component modified relative to the base ref:

    ./dev/google-cloud component:breaking-changes

Check specific components:

    ./dev/google-cloud component:breaking-changes -c Storage -c BigQuery

Compare against a release tag in markdown format:

    ./dev/google-cloud component:breaking-changes --base-ref=v0.346.0 --format=markdown

EOF)
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Component to check. Defaults to all components modified relative to the base ref',
                []
            )
            ->addOption(
                'base-ref',
                null,
                InputOption::VALUE_REQUIRED,
                'Git ref to compare against',
                'origin/main'
            )
            ->addOption(
                'format',
                null,
                InputOption::VALUE_REQUIRED,
                'Output format (' . implode(', ', self::FORMATS) . ')',
                self::FORMAT_GITHUB_ACTIONS
            )
        ;
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

        $baseRef = $input->getOption('base-ref');

        // Progress goes to stderr so that stdout holds nothing but the report,
        // keeping the markdown format pipeable.
        $progress = $output instanceof ConsoleOutputInterface
            ? $output->getErrorOutput()
            : $output;

        $components = $input->getOption('component')
            ?: $this->snapshots->getChangedComponents($baseRef);

        if (!$components) {
            $progress->writeln('No components have changed.');
            return Command::SUCCESS;
        }

        $broken = [];
        foreach ($components as $componentName) {
            $progress->writeln(sprintf('Checking %s against %s', $componentName, $baseRef));

            $workTree = $this->snapshots->build($componentName, $baseRef);
            if (null === $workTree) {
                $progress->writeln(sprintf('  <info>skipped</info> %s: nothing to compare', $componentName));
                continue;
            }

            try {
                $process = ($this->processFactory)($workTree, $format);
                $process->run();
            } finally {
                $this->filesystem->remove($workTree);
            }

            if ($process->isSuccessful()) {
                $progress->writeln(sprintf('  <info>ok</info> %s', $componentName));
                continue;
            }

            $broken[$componentName] = $process->getOutput() . $process->getErrorOutput();
            $progress->writeln(sprintf('  <error>breaking changes</error> %s', $componentName));
        }

        if (!$broken) {
            $progress->writeln('No breaking changes detected.');
            return Command::SUCCESS;
        }

        $output->write($this->report($broken, $format));

        return Command::FAILURE;
    }

    private function getRoaveBinary(): string
    {
        if ($this->roaveBinary) {
            return $this->roaveBinary;
        }

        $default = getenv('HOME') . '/.composer/vendor/bin/' . self::ROAVE_BINARY;
        $this->roaveBinary = (new ExecutableFinder())->find(self::ROAVE_BINARY, $default);

        if (!is_executable($this->roaveBinary)) {
            throw new RuntimeException(sprintf(
                '"%s" not found. Install it with: composer global require roave/backward-compatibility-check',
                self::ROAVE_BINARY
            ));
        }

        return $this->roaveBinary;
    }

    /**
     * @param array<string, string> $broken
     */
    private function report(array $broken, string $format): string
    {
        if (self::FORMAT_MARKDOWN !== $format) {
            return implode("\n", $broken) . "\n";
        }

        $report = '';
        foreach ($broken as $componentName => $details) {
            $report .= sprintf(
                "<details>\n<summary><b>%s</b></summary>\n\n%s\n\n</details>\n\n",
                $componentName,
                trim($details)
            );
        }

        return $report;
    }
}
