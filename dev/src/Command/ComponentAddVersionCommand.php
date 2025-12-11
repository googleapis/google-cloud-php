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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;

/**
 * Add a Component
 * @internal
 */
class ComponentAddVersionCommand extends Command
{
    private const OWL_BOT_REGEX='/.*\/\(([\w|]+)\).*/';

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
                'Do not run the update-component command after adding the component skeleton'
            )
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_REQUIRED,
                'The timeout limit for executing commands in seconds. Defaults to 60.',
                120
            );
    }

    private $rootPath;

    /**
     * @param string $rootPath The path to the repository root directory.\
     */
    public function __construct($rootPath)
    {
        $this->rootPath = realpath($rootPath);
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $componentName = $input->getArgument('component');
        $version = $input->getArgument('version');

        // Ensure component exists
        $owlbotFile = sprintf('%s/%s/.OwlBot.yaml', $this->rootPath, $componentName);
        if (!file_exists($owlbotFile)) {
            throw new RuntimeException(".Owlbot.yaml for component '$componentName' not found.");
        }
        $output->writeln("Adding new version '$version' to .OwlBot.yaml.");
        $yaml = Yaml::parse(file_get_contents($owlbotFile));
        foreach ($yaml['deep-copy-regex'] as $i => $deepCopyRegex) {
            if (preg_match(self::OWL_BOT_REGEX, $deepCopyRegex['source'], $matches)) {
                // ensure version doesn't already exist in .OwlBot.yaml before adding it
                if (false !== array_search($version, explode('|', $matches[1]))) {
                    $output->writeln("Version '$version' already exists in deep-copy-regex. Skipping... ");
                    continue;
                }
                $newVersion = $matches[1] . '|' . $version;
                $yaml['deep-copy-regex'][$i]['source'] = str_replace($matches[1], $newVersion, $matches[0]);
            }
        }
        // Ensure YAML has changed before writing it
        if ($yaml != Yaml::parse(file_get_contents($owlbotFile))) {
            file_put_contents($owlbotFile, Yaml::dump($yaml, 3, 2, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK));
        }

        // Run "update-component" command to generate the new version and add its sample to the README
        if ($input->getOption('no-update')) {
            // nothing left to do
            $output->writeln('Skipping component update: "--no-update" flag set');
            return 0;
        }

        $args = [
            'component' => $componentName,
            '--timeout' => $input->getOption('timeout'),
        ];
        if (!$this->getApplication()->has('component:update:gencode')) {
            throw new \RuntimeException(
                'Application does not have an component:update:gencode command. '
                . 'Run with --no-update to skip this.'
            );
        }
        $updateCommand = $this->getApplication()->find('component:update:gencode');
        $returnCode = $updateCommand->run(new ArrayInput($args), $output);
        if ($returnCode !== Command::SUCCESS) {
            return $returnCode;
        }
        // Run "component:update:readme-sample" command to ensure our README contains the latest version's sample.
        $updateReadmeSampleArgs = ['--component' => [$componentName], '--update' => true];
        if (!$updateReadmeSampleCommand = $this->getApplication()->find('component:update::readme-sample')) {
            throw new \RuntimeException(
                'Application does not have an component:update::readme-sample command. '
                . 'Run with --no-update to skip this.'
            );
        }
        return $updateReadmeSampleCommand->run(new ArrayInput($updateReadmeSampleArgs), $output);
    }
}
