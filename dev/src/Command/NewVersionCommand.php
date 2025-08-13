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

use Google\Cloud\Dev\Composer;
use Google\Cloud\Dev\NewComponent;
use Google\Cloud\Dev\RunProcess;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\Client;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use RuntimeException;
use Exception;
use Google\Cloud\Dev\Component;

/**
 * Add a Component
 * @internal
 */
class NewVersionCommand extends Command
{
    private const OWL_BOT_REGEX='/.*\/\(([\w|]+)\).*/';

    protected function configure()
    {
        $this->setName('new-version')
            ->setDescription('Add a new version to an existing Component')
            ->addArgument('component', InputArgument::REQUIRED, 'Component to add the version to.')
            ->addArgument('version', InputArgument::REQUIRED, 'The new version to add.')
            ->addOption(
                'no-update-component',
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
        $components = Component::getComponents([$componentName]);
        if (empty($components)) {
            throw new RuntimeException("Component '$componentName' not found.");
        }

        $output->writeln("Adding new version '$version' to .OwlBot.yaml.");
        $owlbotFile = sprintf('%s/%s/.OwlBot.yaml', $this->rootPath, $componentName);
        $yaml = Yaml::parse(file_get_contents($owlbotFile));
        foreach ($yaml['deep-copy-regex'] as $i => $deepCopyRegex) {
            if (preg_match(self::OWL_BOT_REGEX, $deepCopyRegex['source'], $matches)) {
                $newVersion = $matches[1] . '|' . $version;
                $yaml['deep-copy-regex'][$i]['source'] = str_replace($matches[1], $newVersion, $matches[0]);
            }
        }
        file_put_contents($owlbotFile, Yaml::dump($yaml, 3, 2, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK));

        if ($input->getOption('no-update-component')) {
            // nothing left to do
            $output->writeln('Skipping component update: "--no-update-component" flag set');
            return 0;
        }

        $args = [
            'component' => $componentName,
            '--timeout' => $input->getOption('timeout'),
        ];
        if (!$this->getApplication()->has('update-component')) {
            throw new \RuntimeException(
                'Application does not have an update-component command. '
                . 'Run with --no-update-component to skip this.'
            );
        }
        $updateCommand = $this->getApplication()->find('update-component');
        return $updateCommand->run(new ArrayInput($args), $output);
    }
}
