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
    const PARENT_TAG_NAME = 'https://github.com/%s/releases/tag/%s';
    const EXEC_DIR = '.split';

    /**
     * @var ComponentManager
     */
    private $componentManager;

    /**
     * @param string $rootPath The path to the repository root directory.
     * @param ComponentManager $componentManaher An instance of the Component
     *        Manager.
     */
    public function __construct($rootPath, ComponentManager $componentManager)
    {
        parent::__construct($rootPath);

        $this->rootPath = realpath($rootPath);
        $this->componentManager = $componentManager;
    }

    /**
     * Command configuration.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('split')
            ->setDescription('Split subtree and push to various remotes.')
            ->addArgument(
                'repo',
                InputArgument::REQUIRED,
                'The parent repository, in the form of `organization/repository`'
            )
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

    /**
     * Execute Split and Release process.
     *
     * @param InputInterface $input The Symfony input handler.
     * @param OutputInterface $output The Symfony output handler.
     * @return int The exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (PHP_VERSION_ID < 50600) {
            throw new \RuntimeException('This command is only available in PHP 5.6 and later.');
        }

        $output->writeln("<info>[INFO]</info>: Parent repository: " . $input->getArgument('repo'));
        $output->writeln("<info>[INFO]</info>: Parent tag: " . $input->getArgument('parent'));

        $execDir = $this->rootPath . '/' . self::EXEC_DIR;
        $token = $this->githubToken($input->getOption('token'));

        $shell = new RunShell;
        $guzzle = $this->guzzleClient();
        $github = $this->githubClient($output, $shell, $guzzle, $token);
        $split = $this->splitWrapper($output, $shell);

        @mkdir($execDir);

        $splitBinaryPath = $this->splitshInstall($output, $shell, $execDir, $input->getOption('splitsh'));

        $componentId = $input->getOption('component');
        $components = $this->componentManager->componentsExtra($componentId);

        // remove umbrella component.
        $components = array_filter($components, function ($component, $key) {
            return $key !== 'google-cloud';
        }, ARRAY_FILTER_USE_BOTH);

        $manifestPath = $this->rootPath . '/docs/manifest.json';

        $parentTagSource = sprintf(
            self::PARENT_TAG_NAME,
            $input->getArgument('repo'),
            $input->getArgument('parent')
        );

        $changelog = $github->getChangelog(
            $input->getArgument('repo'),
            $input->getArgument('parent')
        );

        $releaseNotes = new ReleaseNotes($changelog);

        $errors = [];
        foreach ($components as $component) {
            $res = $this->processComponent(
                $output,
                $github,
                $split,
                $releaseNotes,
                $component,
                $splitBinaryPath,
                $parentTagSource
            );
            if (!$res) {
                $errors[] = $component['id'];
            }

            $output->writeln('');
            $output->writeln('');
        }

        if ($errors) {
            $output->writeln('<error>[ERROR]</error>: One or more components reported an error.');
            $output->writeln('Please correct errors and try again.');
            $output->writeln('Error component(s): ' . implode(', ', $errors));

            return 1;
        }

        return 0;
    }

    /**
     * Process release for a given component.
     *
     * Checks if the tag exists on the remote target, splits the component,
     * pushes to the remote target and creates a github release.
     *
     * @param OutputInterface $output Allows writing to cli.
     * @param GitHub A GitHub API wrapper.
     * @param Split A Splitsh wrapper.
     * @param ReleaseNotes The parsed release notes.
     * @param array $component The component data.
     * @param string $splitBinaryPath The path to the splitsh binary.
     * @param string $parentTagSource The URI to the parent tag.
     * @return bool
     */
    private function processComponent(
        OutputInterface $output,
        GitHub $github,
        Split $split,
        ReleaseNotes $releaseNotes,
        array $component,
        $splitBinaryPath,
        $parentTagSource
    ) {
        $output->writeln('');
        $localVersion = current($this->componentManager->componentsVersion($component['id']));
        $isAlreadyTagged = $github->doesTagExist($component['target'], $localVersion);
        $defaultBranch = $github->getDefaultBranch($component['target']) ?: 'main';

        // If the repo is empty, it's new and we don't want to force-push.
        $isTargetEmpty = $github->isTargetEmpty($component['target']);

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
            return true;
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

            return false;
        }

        $output->writeln('');

        $output->writeln(sprintf(
            '<comment>%s</comment>: Push to github target %s',
            $component['id'],
            $component['target']
        ));

        $res = $github->push($component['target'], $splitBranch, $defaultBranch, $isTargetEmpty);
        if ($res[0]) {
            $output->writeln(sprintf('<comment>%s</comment>: Push succeeded.', $component['id']));
        } else {
            $output->writeln(sprintf('<error>%s</error>: Push failed.', $component['id']));

            return false;
        }

        $output->writeln('');
        $output->writeln('<comment>[info]</comment> Creating GitHub tag.');

        $notes = $releaseNotes->get($component['id']);
        if (!$notes) {
            $notes = sprintf(
                'For release notes, please see the [associated Google Cloud PHP release](%s).',
                $parentTagSource
            );
        }

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

            return false;
        }

        return true;
    }

    /**
     * Fetch the GitHub auth token from the user or environment.
     *
     * @param string|null $userToken The user token, if provided, else `null`.
     * @return string
     * @throws \RuntimeException If no user token was given and the environment
     *         variable is not set.
     */
    protected function githubToken($userToken)
    {
        $token = $userToken ?: getenv(self::TOKEN_ENV);

        if (!$token) {
            throw new \RuntimeException(sprintf(
                'Could not find GitHub auth token. Please set the environment ' .
                'variable `%s` or pass token as console argument.',
                self::TOKEN_ENV
            ));
        }

        return $token;
    }

    /**
     * Initialize the Split wrapper.
     *
     * You can override this method in unit tests.
     *
     * @param OutputInterface $output Allows writing to cli.
     * @param RunShell $shell A wrapper for executing shell commands.
     * @return Split
     */
    protected function splitWrapper(OutputInterface $output, RunShell $shell)
    {
        $output->writeln('<comment>[info]</comment> Instantiating Splitsh Wrapper.');

        return new Split($shell);
    }

    /**
     * Initialize the Github client.
     *
     * You can override this method in unit tests.
     *
     * @param OutputInterface $output Allows writing to cli.
     * @param RunShell $shell A wrapper for executing shell commands.
     * @param Client $guzzle A guzzle client for executing HTTP requests.
     * @param string $token A Github auth token.
     * @return GitHub
     */
    protected function githubClient(OutputInterface $output, RunShell $shell, Client $guzzle, $token)
    {
        $output->writeln('<comment>[info]</comment> Instantiating GitHub API Wrapper.');

        return new GitHub($shell, $guzzle, $token);
    }

    /**
     * Create a Guzzle client.
     *
     * You can override this method in unit tests.
     *
     * @return Client
     */
    protected function guzzleClient()
    {
        return new Client;
    }

    /**
     * Install the Splitsh program.
     *
     * You can override this method in unit tests.
     *
     * @param OutputInterface $output Allows writing to cli.
     * @param RunShell $shell A wrapper for executing shell commands.
     * @param string $execDir The path to a working directory.
     * @param string|null The path to an existing splitsh binary, or null if
     *        install from source is desired.
     * @return string
     */
    protected function splitshInstall(OutputInterface $output, RunShell $shell, $execDir, $binaryPath)
    {
        if ($binaryPath) {
            $output->writeln('<comment>[info]</comment> Using User-Provided Splitsh binary.');
            return $binaryPath;
        }

        $output->writeln('<comment>[info]</comment> Compiling Splitsh');
        $this->writeDiv($output);

        $install = new SplitInstall($shell, $execDir);

        $res = $install->installFromSource($this->rootPath);

        $output->writeln(sprintf(
            '<comment>[info]</comment> Splitsh Installer says <info>%s</info>',
            $res[0]
        ));

        return $res[1];
    }

    private function writeDiv(OutputInterface $output)
    {
        $output->writeln('--------');
    }
}
