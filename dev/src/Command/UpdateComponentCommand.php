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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;
use Exception;

/**
 * Update Component Command
 *
 * This command updates one or all components by running Owlbot to copy code
 * from googleapis-gen and process the files.
 *
 * @internal
 */
class UpdateComponentCommand extends Command
{
    private const OWLBOT_CLI_IMAGE = 'gcr.io/cloud-devrel-public-resources/owlbot-cli:latest';

    private $rootPath;
    private RunProcess $runProcess;

    /**
     * @param string $rootPath The path to the repository root directory.
     * @param RunProcess $runProcess Instance to execute Symfony Process commands, useful for tests.
     */
    public function __construct($rootPath, ?RunProcess $runProcess = null)
    {
        $this->rootPath = realpath($rootPath);
        $this->runProcess = $runProcess ?: new RunProcess();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('update-component')
            ->setDescription('Update one or all components using Owlbot')
            ->addArgument(
                'component',
                InputArgument::OPTIONAL,
                'The name of the component to update. If not provided, all components will be updated.'
            )
            ->addOption(
                'googleapis-gen-path',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to googleapis-gen repo',
                $this->rootPath . '/../googleapis-gen'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $componentName = $input->getArgument('component');
        $googleApisGenDir = realpath($input->getOption('googleapis-gen-path'));

        if (!$googleApisGenDir) {
            throw new RuntimeException(
                'Error: googleapis-gen directory not found at ' . $input->getOption('googleapis-gen-path') .
                '. Please provide a valid path using the --googleapis-gen-path option.'
            );
        }

        $this->checkDockerAvailable();

        // Find components to update
        $components = $this->findComponents($componentName);

        if (empty($components)) {
            if ($componentName) {
                throw new RuntimeException("Component '$componentName' not found.");
            } else {
                throw new RuntimeException("No components found.");
            }
        }

        foreach ($components as $component) {
            $output->writeln("\n<info>Running Owlbot in $component</info>");

            // Copy code from googleapis-gen
            $output->writeln("Copying code from googleapis-gen...");
            $result = $this->owlbotCopyCode($component, $googleApisGenDir);
            $output->writeln($result);

            // Copy bazel-bin files
            $output->writeln("Copying bazel-bin files...");
            $result = $this->owlbotCopyBazelBin($component, $googleApisGenDir);
            $output->writeln($result);
        }

        // Run post-processing for all generated files
        $output->writeln("\n<info>Running Owlbot post-processing for all generated files</info>");
        $result = $this->owlbotPostProcessor();
        $output->writeln($result);

        $output->writeln("\n<info>Component update completed successfully!</info>");

        return Command::SUCCESS;
    }

    /**
     * Find components to update based on the provided component name.
     *
     * @param string|null $componentName Optional component name to filter by.
     * @return array List of component names to update.
     */
    private function findComponents(?string $componentName): array
    {
        $command = ['find', $this->rootPath, '-mindepth', '1', '-maxdepth', '1', '-type', 'd'];

        if ($componentName) {
            $command[] = '-name';
            $command[] = $componentName;
        }

        $command[] = '-printf';
        $command[] = '%f\n';

        $output = $this->runProcess->execute($command);

        // Filter to only include directories that start with an uppercase letter
        $components = array_filter(
            explode("\n", $output),
            fn($dir) => $dir && preg_match('/^[A-Z]/', $dir)
        );

        return $components;
    }

    /**
     * Run Owlbot copy-code command to copy code from googleapis-gen.
     *
     * @param string $componentName The name of the component to update.
     * @param string $googleApisGenDir Path to googleapis-gen directory.
     * @return string Command output.
     */
    private function owlbotCopyCode(string $componentName, string $googleApisGenDir): string
    {
        list($userId, $groupId) = $this->getUserAndGroupId();

        $command = [
            'docker', 'run', '--rm',
            '--user', sprintf('%s:%s', $userId, $groupId),
            '-v', sprintf('%s:/repo', $this->rootPath),
            '-v', sprintf('%s:/googleapis-gen', $googleApisGenDir),
            '-w', '/repo',
            '--env', 'HOME=/tmp',
            self::OWLBOT_CLI_IMAGE,
            'copy-code',
            '--source-repo=/googleapis-gen',
            sprintf('--config-file=%s/.OwlBot.yaml', $componentName)
        ];

        return $this->runProcess->execute($command);
    }

    /**
     * Run Owlbot copy-bazel-bin command to copy bazel-bin files.
     *
     * @param string $componentName The name of the component to update.
     * @param string $googleApisGenDir Path to googleapis-gen directory.
     * @return string Command output.
     */
    private function owlbotCopyBazelBin(string $componentName, string $googleApisGenDir): string
    {
        list($userId, $groupId) = $this->getUserAndGroupId();

        $command = [
            'docker', 'run', '--rm',
            '--user', sprintf('%s:%s', $userId, $groupId),
            '-v', sprintf('%s:/repo', $this->rootPath),
            '-v', sprintf('%s/bazel-bin:/bazel-bin', $googleApisGenDir),
            self::OWLBOT_CLI_IMAGE,
            'copy-bazel-bin',
            sprintf('--config-file=%s/.OwlBot.yaml', $componentName),
            '--source-dir', '/bazel-bin',
            '--dest', '/repo'
        ];

        return $this->runProcess->execute($command);
    }

    /**
     * Run Owlbot post-processor.
     *
     * @return string Command output.
     */
    private function owlbotPostProcessor(): string
    {
        list($userId, $groupId) = $this->getUserAndGroupId();
        $owlbotLock = Yaml::parse(file_get_contents($this->rootPath . '/.github/.OwlBot.lock.yaml'));
        $owlbotPhpImage = sprintf('%s@%s', $owlbotLock['docker']['image'], $owlbotLock['docker']['digest']);

        $command = [
            'docker', 'pull', $owlbotPhpImage
        ];
        $this->runProcess->execute($command);

        $command = [
            'docker', 'run', '--rm',
            '--user', sprintf('%s:%s', $userId, $groupId),
            '-v', sprintf('%s:/repo', $this->rootPath),
            '-w', '/repo',
            $owlbotPhpImage
        ];

        return $this->runProcess->execute($command);
    }

    /**
     * Check if Docker is available.
     *
     * @throws RuntimeException If Docker is not available.
     */
    private function checkDockerAvailable(): void
    {
        $command = ['which', 'docker'];
        $output = $this->runProcess->execute($command);

        if (strlen($output) == 0) {
            throw new RuntimeException('Error: Docker is not available.');
        }
    }

    /**
     * Get the current user ID and group ID.
     *
     * @return array Array containing user ID and group ID.
     */
    private function getUserAndGroupId(): array
    {
        $userId = posix_getuid();
        $groupId = posix_getgid();

        return [$userId, $groupId];
    }
}
