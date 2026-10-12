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
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;

/**
 * Add a Version to a Component
 * @internal
 */
class ComponentAddVersionCommand extends Command
{
    private $rootPath;
    private RunProcess $runProcess;

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
        $this->setName('component:add-version')
            ->setDescription('Add a new version to an existing Component')
            ->addArgument('component', InputArgument::REQUIRED, 'Component to add the version to.')
            ->addArgument('version', InputArgument::REQUIRED, 'The new version to add.')
            ->addOption(
                'no-update',
                null,
                InputOption::VALUE_NONE,
                'Do not run the component:update command after adding the version'
            )
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_REQUIRED,
                'The timeout limit for executing commands in seconds. Defaults to 120.',
                120
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $componentName = $input->getArgument('component');
        $version = $input->getArgument('version');
        $unsafeTimeout = $input->getOption('timeout');

        if (!is_numeric($unsafeTimeout)) {
            throw new RuntimeException(
                'Error: The timeout option must be a positive integer'
            );
        }
        $timeout = (int) $unsafeTimeout;

        $librarianFile = sprintf('%s/librarian.yaml', $this->rootPath);
        if (!file_exists($librarianFile)) {
            throw new RuntimeException('librarian.yaml not found.');
        }

        $yaml = Yaml::parse(file_get_contents($librarianFile));
        $library = null;
        foreach ($yaml['libraries'] ?? [] as $lib) {
            if (($lib['output'] ?? null) === $componentName || ($lib['name'] ?? null) === $componentName) {
                $library = $lib;
                break;
            }
        }

        if (!$library || empty($library['apis'])) {
            throw new RuntimeException("Component '$componentName' not found in librarian.yaml.");
        }

        $baseApiPath = dirname($library['apis'][0]['path']);
        $newApiPath = $baseApiPath . '/' . $version;

        $existingPaths = array_column($library['apis'], 'path');
        if (in_array($newApiPath, $existingPaths, true)) {
            $output->writeln("Version '$version' already exists in librarian.yaml. Skipping...");
        } else {
            $output->writeln("Adding new version '$version' to librarian.yaml.");
            $this->runProcess->execute(['librarian', 'add', $newApiPath], $this->rootPath, $timeout);
        }

        // Run "component:update" command to generate the new version and add its sample to the README
        if ($input->getOption('no-update')) {
            // nothing left to do
            $output->writeln('Skipping component update: "--no-update" flag set');
            return 0;
        }

        $args = [
            '--component' => [$componentName],
            '--timeout' => $timeout,
        ];
        if (!$this->getApplication()->has('component:update')) {
            throw new \RuntimeException(
                'Application does not have an component:update command. '
                . 'Run with --no-update to skip this.'
            );
        }
        $updateCommand = $this->getApplication()->find('component:update');
        $returnCode = $updateCommand->run(new ArrayInput($args), $output);
        if ($returnCode !== Command::SUCCESS) {
            return $returnCode;
        }
        // Run "component:update:readme-sample" command to ensure our README contains the latest version's sample.
        $updateReadmeSampleArgs = ['--component' => [$componentName], '--force' => true];
        if (!$this->getApplication()->has('component:update:readme-sample')) {
            throw new \RuntimeException(
                'Application does not have an component:update:readme-sample command. '
                . 'Run with --no-update to skip this.'
            );
        }
        $updateReadmeSampleCommand = $this->getApplication()->find('component:update:readme-sample');
        return $updateReadmeSampleCommand->run(new ArrayInput($updateReadmeSampleArgs), $output);
    }
}
