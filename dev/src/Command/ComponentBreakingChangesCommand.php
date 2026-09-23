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

use Google\Cloud\Dev\BreakingChanges\RoaveRunner;
use Google\Cloud\Dev\BreakingChanges\SnapshotBuilder;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Detect backwards compatibility breaks in one or more components.
 *
 * @internal
 */
class ComponentBreakingChangesCommand extends Command
{
    public const FORMAT_GITHUB_ACTIONS = 'github-actions';
    public const FORMAT_MARKDOWN = 'markdown';

    private const FORMATS = [self::FORMAT_GITHUB_ACTIONS, self::FORMAT_MARKDOWN];

    private SnapshotBuilder $snapshots;
    private RoaveRunner $roave;

    public function __construct(
        string $rootDir,
        ?SnapshotBuilder $snapshots = null,
        ?RoaveRunner $roave = null
    ) {
        $this->snapshots = $snapshots ?: new SnapshotBuilder($rootDir);
        $this->roave = $roave ?: new RoaveRunner();

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

Compare against a release tag and report without failing:

    ./dev/google-cloud component:breaking-changes --base-ref=v0.346.0 --format=markdown --report-only

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
            ->addOption(
                'report-only',
                null,
                InputOption::VALUE_NONE,
                'Report breaking changes without failing. Exits 0 even when breaks are found'
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
        $reportOnly = $input->getOption('report-only');

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

            $snapshot = $this->snapshots->build($componentName, $baseRef);
            if (null === $snapshot) {
                $progress->writeln(sprintf('  <info>skipped</info> %s: nothing to compare', $componentName));
                continue;
            }

            try {
                $result = $this->roave->run($snapshot, $format);
            } finally {
                $snapshot->remove();
            }

            if (!$result['hasBreakingChanges']) {
                $progress->writeln(sprintf('  <info>ok</info> %s', $componentName));
                continue;
            }

            $broken[$componentName] = $result['output'];
            $progress->writeln(sprintf('  <error>breaking changes</error> %s', $componentName));
        }

        if (!$broken) {
            $progress->writeln('No breaking changes detected.');
            return Command::SUCCESS;
        }

        $output->write($this->report($broken, $format));

        return $reportOnly ? Command::SUCCESS : Command::FAILURE;
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
