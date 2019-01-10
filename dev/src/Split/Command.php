<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Dev\Split;

use Google\Cloud\Dev\Command\GoogleCloudCommand;
use Google\Cloud\Dev\ComponentManager;
use GuzzleHttp\Client;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A Symfony command for executing subtree splits.
 *
 * @internal
 */
class Command extends GoogleCloudCommand
{
    const PARENT_TAG_NAME = 'https://github.com/googleapis/google-cloud-php/releases/tag/%s';
    const EXEC_DIR = '.split';

    private $components;
    private $github;
    private $split;

    /**
     * @param string $rootPath The path to the repository root directory.
     * @param ComponentManager $components An instance of the Component Manager.
     * @param GitHub|null $github The Github API wrapper. If not provided, it
     *        will be instantiated. Available for testing purposes.
     * @param Split|null $split The Splitsh wrapper. If not provided, it will be
     *        instantiated. Available for testing purposes.
     */
    public function __construct(
        $rootPath,
        ComponentManager $components,
        GitHub $github = null,
        Split $split = null
    ) {
        parent::__construct($rootPath);

        $this->rootPath = realpath($rootPath);
        $this->components = $components;
        $this->github = $github;
        $this->split = $split;
    }

    protected function configure()
    {
        $this->setName('split')
            ->setDescription('Split subtree and push to various remotes.')
            ->addArgument(
                'parent',
                InputArgument::REQUIRED,
                'The parent repository tag to which each component is linked.'
            )
            ->addOption(
                'token',
                't',
                InputOption::VALUE_OPTIONAL,
                sprintf(
                    'A Github Auth Token. If not provided, uses value of environment variable `%s`.',
                    self::TOKEN_ENV
                )
            )
            ->addOption(
                'splitsh',
                null,
                InputOption::VALUE_OPTIONAL,
                'Path to a pre-compiled splitsh-lite binary.'
            )
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_OPTIONAL,
                'Split and release only a single component.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (PHP_VERSION_ID < 50600) {
            throw new \RuntimeException('This command is only available in PHP 5.6 and later.');
        }

        $execDir = $this->rootPath . '/' . self::EXEC_DIR;
        $github = $this->github;
        $split = $this->split;

        $shell = new RunShell;

        if (!$github) {
            $output->writeln('<comment>[info]</comment> Instantiating GitHub API Wrapper.');

            $token = $input->getOption('token');
            if (!$token && getenv(self::TOKEN_ENV)) {
                $token = getenv(self::TOKEN_ENV);
            } else {
                throw new \RuntimeException(sprintf(
                    'Could not find GitHub auth token. Please set the environment ' .
                    'variable `%s` or pass token as console argument.',
                    self::TOKEN_ENV
                ));
            }

            $guzzle = new Client;
            $github = new GitHub($shell, $guzzle, $token);
        } else {
            $output->writeln('<comment>[info]</comment> Using injected Github API Wrapper.');
        }

        if (!$split) {
            $output->writeln('<comment>[info]</comment> Instantiating Splitsh Wrapper.');

            $split = new Split($shell);
        } else {
            $output->writeln('<comment>[info]</comment> Using injected Splitsh Wrapper.');
        }

        @mkdir($execDir);

        if ($input->getOption('splitsh')) {
            $output->writeln('<comment>[info]</comment> Using User-Provided Splitsh binary.');
            $splitBinaryPath = $input->getOption('splitsh');
        } else {
            $output->writeln('<comment>[info]</comment> Compiling Splitsh');
            $this->writeDiv($output);

            $install = new SplitInstall($shell, $execDir);

            $res = $install->installFromSource($this->rootPath);

            $output->writeln(sprintf(
                '<comment>[info]</comment> Splitsh Installer says <info>%s</info>',
                $res[0]
            ));

            $splitBinaryPath = $res[1];
        }

        $componentId = $input->getOption('component');
        $components = $this->components->componentsExtra($componentId);

        // remove umbrella component.
        $components = array_filter($components, function ($component, $key) {
            return $key !== 'google-cloud';
        }, ARRAY_FILTER_USE_BOTH);

        $manifestPath = $this->rootPath . '/docs/manifest.json';

        $parentTagSource = sprintf(self::PARENT_TAG_NAME, $input->getArgument('parent'));

        foreach ($components as $component) {
            $output->writeln('');
            $localVersion = current($this->components->componentsVersion($component['id']));
            $isAlreadyTagged = $github->doesTagExist($component['target'], $localVersion);

            $output->writeln(sprintf(
                '<comment>%s</comment>: Starting on component. Target version <info>%s</info>',
                $component['id'],
                $localVersion
            ));

            $this->writeDiv($output);

            if ($isAlreadyTagged) {
                $output->writeln(sprintf(
                    'Version <info>%s</info> already exists on target <info>%s</info>',
                    $localVersion,
                    $component['target']
                ));

                $output->writeln('<comment>[info]</comment> Skipping.');
                continue;
            }

            $output->writeln(sprintf(
                '<comment>%s</comment>: Running splitsh',
                $component['id']
            ));


            $splitBranch = $split->execute($splitBinaryPath, $this->rootPath, $component['path']);
            if ($splitBranch) {
                $output->writeln(sprintf('Split succeeded, branch <info>%s</info> created.', $splitBranch));
            } else {
                $output->writeln('<error>Split failed!</error>');
            }

            $output->writeln('');

            $output->writeln(sprintf(
                '<comment>%s</comment>: Push to github target %s',
                $component['id'],
                $component['target']
            ));

            $res = $github->push($component['target'], $splitBranch);
            if ($res[0]) {
                $output->writeln(sprintf('<comment>%s</comment>: Push succeeded.', $component['id']));
            } else {
                $output->writeln(sprintf('<error>%s</error>: Push failed.', $component['id']));
            }

            $output->writeln('');
            $output->writeln('<comment>[info]</comment> Creating GitHub tag.');

            // @todo once the release builder is refactored, this should generate
            //       actually useful release notes for the component in question.
            $notes = sprintf(
                'For release notes, please see the [associated Google Cloud PHP release](%s).',
                $parentTagSource
            );

            $res = $github->createRelease(
                $component['target'],
                $localVersion,
                $component['displayName'] . ' ' . $localVersion,
                $notes
            );

            if ($res) {
                $output->writeln(sprintf('<comment>%s</comment>: Tag succeeded.', $component['id']));
            } else {
                $output->writeln(sprintf('<error>%s</error>: Tag failed.', $component['id']));
            }

            $output->writeln('');
            $output->writeln('');
        }
    }

    private function writeDiv(OutputInterface $output)
    {
        $output->writeln('--------');
    }
}
