<?php
/**
 * Copyright 2023 Google Inc.
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

use Google\Cloud\Dev\RunProcess;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;

/**
 * Update Component Command
 *
 * This command updates one or all components by running Librarian to generate
 * code and post-process the files.
 *
 * @internal
 */
class ComponentUpdateCommand extends Command
{
    private $rootPath;
    private RunProcess $runProcess;
    private int $timeout;

    /**
     * @param string $rootPath The path to the repository root directory.
     * @param RunProcess|null $runProcess Instance to execute Symfony Process commands, useful for tests.
     */
    public function __construct($rootPath, ?RunProcess $runProcess = null)
    {
        $this->rootPath = realpath($rootPath);
        $this->runProcess = $runProcess ?: new RunProcess();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('component:update')
            ->setDescription('Update one or all components using Librarian')
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Update the specified component(s)',
                []
            )
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_REQUIRED,
                'The timeout limit for executing commands in seconds. Defaults to 120.',
                120
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $unsafeTimeout = $input->getOption('timeout');

        if (!is_numeric($unsafeTimeout)) {
            throw new RuntimeException(
                'Error: The timeout option must be a positive integer'
            );
        }

        $this->timeout = (int) $unsafeTimeout;

        $this->checkLibrarianAvailable();

        $componentNames = $input->getOption('component');
        if (empty($componentNames)) {
            $output->writeln("\n<info>Running librarian generate --all</info>");
            $result = $this->runProcess->execute(
                ['librarian', 'generate', '--all'],
                $this->rootPath,
                $this->timeout
            );
            $output->writeln($result);
        } else {
            $libraries = $this->loadLibraries();
            $targets = [];
            foreach ($componentNames as $componentName) {
                $targets[$componentName] = $this->getLibraryName($componentName, $libraries);
            }

            foreach ($targets as $componentName => $libraryName) {
                $output->writeln("\n<info>Running librarian in $componentName</info>");
                $result = $this->runProcess->execute(
                    ['librarian', 'generate', $libraryName],
                    $this->rootPath,
                    $this->timeout
                );
                $output->writeln($result);
            }
        }

        $output->writeln("\n<info>Component update completed successfully!</info>");

        return Command::SUCCESS;
    }

    /**
     * Load library configurations from librarian.yaml.
     *
     * @return array<int, array<string, mixed>>
     */
    private function loadLibraries(): array
    {
        $librarianFile = $this->rootPath . '/librarian.yaml';
        if (!file_exists($librarianFile)) {
            throw new RuntimeException('Error: librarian.yaml not found at ' . $librarianFile);
        }

        $yaml = Yaml::parse(file_get_contents($librarianFile));
        return $yaml['libraries'] ?? [];
    }

    /**
     * Resolve a component name (or library name) to its librarian library name.
     *
     * @param string $componentName
     * @param array<int, array<string, mixed>> $libraries
     * @return string
     */
    private function getLibraryName(string $componentName, array $libraries): string
    {
        foreach ($libraries as $library) {
            if (($library['output'] ?? null) === $componentName || ($library['name'] ?? null) === $componentName) {
                return $library['name'];
            }
        }

        throw new RuntimeException('Invalid component name provided: ' . $componentName);
    }

    /**
     * Check if Librarian CLI is available.
     *
     * @throws RuntimeException If librarian is not available.
     */
    private function checkLibrarianAvailable(): void
    {
        $command = ['which', 'librarian'];
        $output = $this->runProcess->execute($command, null, $this->timeout);

        if (strlen($output) == 0) {
            throw new RuntimeException('Error: librarian is not available.');
        }
    }
}
