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

namespace Google\Cloud\Dev\Command;

use Google\Cloud\Dev\Component;
use Google\Cloud\Dev\GitHub;
use Google\Cloud\Dev\Packagist;
use Google\Cloud\Dev\ReleaseNotes;
use Google\Cloud\Dev\RunShell;
use Google\Cloud\Dev\Split;
use Google\Cloud\Dev\SplitInstall;
use GuzzleHttp\BodySummarizer;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A Symfony command for executing subtree splits.
 *
 * @internal
 */
class SplitCommand extends Command
{
    const PARENT_TAG_NAME = 'https://github.com/%s/releases/tag/%s';
    const EXEC_DIR = '.split';
    const TOKEN_ENV = 'GH_OAUTH_TOKEN';

    private string $rootPath;

    /**
     * @param string $rootPath The path to the repository root directory.
     */
    public function __construct($rootPath)
    {
        $this->rootPath = realpath($rootPath);
        parent::__construct();
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
                'packagist-username',
                '',
                InputOption::VALUE_REQUIRED,
                'A packagist username. If provided, new packages will automatically be submitted ' .
                'via the packagist API.',
            )
            ->addOption(
                'packagist-token',
                '',
                InputOption::VALUE_REQUIRED,
                'A Packagist API Auth Token. If provided, new packages will automatically be ' .
                'submitted via the packagist API.',
            )
            ->addOption(
                'packagist-safe-token',
                '',
                InputOption::VALUE_REQUIRED,
                'A Packagist API Auth Token. This token can only be used for package updates, and ' .
                'is not very sensitive if leaked.',
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
            )
            ->addOption(
                'update-release-notes',
                '',
                InputOption::VALUE_NONE,
                'Update the release notes if the release already exists.'
            )
            ->addOption(
                'component-branch',
                '',
                InputOption::VALUE_OPTIONAL,
                'Specify the branch of the component to push to.'
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
        $output->writeln("<info>[INFO]</info>: Parent repository: " . $input->getArgument('repo'));
        $output->writeln("<info>[INFO]</info>: Parent tag: " . $input->getArgument('parent'));

        $execDir = $this->rootPath . '/' . self::EXEC_DIR;
        $token = $this->githubToken($input->getOption('token'));

        $shell = new RunShell();
        $guzzle = $this->guzzleClient();
        $github = $this->githubClient($output, $shell, $guzzle, $token);
        $split = $this->splitWrapper($output, $shell);
        $packagist = null;
        if ($packagistUsername = $input->getOption('packagist-username')) {
            if (!$packagistToken = $input->getOption('packagist-token')) {
                throw new \InvalidArgumentException('A packagist token must be provided if a username is provided.');
            }
            $packagistSafeToken = $input->getOption('packagist-safe-token');
            $packagist = new Packagist($guzzle, $packagistUsername, $packagistToken, $packagistSafeToken, $output);
        }


        @mkdir($execDir);
        if (!$splitBinaryPath = $input->getOption('splitsh')) {
            throw new \InvalidArgumentException('A splitsh binary path must be provided.');
        }
        $changelog = $github->getChangelog(
            $input->getArgument('repo'),
            $input->getArgument('parent')
        );

        $releaseNotes = new ReleaseNotes($changelog);
        $branchToPush = $input->getOption('component-branch');

        if ($componentId = $input->getOption('component')) {
            $components = [new Component($componentId)];
        } else {
            // Build a list of components to update based on the release notes
            $components = [];
            foreach (Component::getComponents() as $component) {
                if ($releaseNotes->get($component->getId())) {
                    $components[] = $component;
                }
            }
        }

        $parentTagSource = sprintf(
            self::PARENT_TAG_NAME,
            $input->getArgument('repo'),
            $input->getArgument('parent')
        );

        $errors = [];
        foreach ($components as $component) {
            $res = $this->processComponent(
                $output,
                $github,
                $split,
                $releaseNotes,
                $component,
                $splitBinaryPath,
                $parentTagSource,
                $input->getOption('update-release-notes'),
                $packagist,
                $branchToPush
            );
            if (!$res) {
                $errors[] = $component->getId();
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
     * @param ?Packagist $packagist The Packagist API object (if configured).
     * @param ?string $branchToPush The branch to which the component will be pushed.
     * @return bool
     */
    private function processComponent(
        OutputInterface $output,
        GitHub $github,
        Split $split,
        ReleaseNotes $releaseNotes,
        Component $component,
        $splitBinaryPath,
        $parentTagSource,
        $updateReleaseNotes,
        ?Packagist $packagist,
        ?string $branchToPush
    ) {
        $output->writeln('');
        $tagName = 'v' . $component->getPackageVersion();
        $repoName = $component->getRepoName();
        $componentId = $component->getId();
        $isAlreadyTagged = $github->doesTagExist($repoName, $tagName);
        if (is_null($branchToPush)) {
            $branchToPush = $github->getDefaultBranch($repoName) ?: 'main';
        }

        // If the repo is empty, it's new and we don't want to force-push.
        $isTargetEmpty = $github->isTargetEmpty($repoName);

        $output->writeln(sprintf(
            '<comment>%s</comment>: Starting on component. Target version <info>%s</info>',
            $componentId,
            $tagName
        ));

        $this->writeDiv($output);

        if ($isAlreadyTagged) {
            $output->writeln(sprintf(
                'Version <info>%s</info> already exists on target <info>%s</info>',
                $tagName,
                $repoName
            ));

            if ($updateReleaseNotes && ($notes = $releaseNotes->get($componentId)) && ($version = $releaseNotes->getVersion($componentId))) {
                $github->updateReleaseNotes($repoName, 'v' . $version, $notes);
                $output->writeln(sprintf('<comment>[info]</comment> Release notes updated for version <info>%s</info>.', $version));
            } else {
                $output->writeln('<comment>[info]</comment> Skipping.');
            }

            return true;
        }

        $output->writeln(sprintf(
            '<comment>%s</comment>: Running splitsh',
            $componentId
        ));

        $splitBranch = $split->execute($splitBinaryPath, $this->rootPath, $component->getName());
        if ($splitBranch) {
            $output->writeln(sprintf('Split succeeded, branch <info>%s</info> created.', $splitBranch));
        } else {
            $output->writeln('<error>Split failed!</error>');

            return false;
        }

        $output->writeln('');

        $output->writeln(sprintf(
            '<comment>%s</comment>: Push to github target %s',
            $componentId,
            $repoName
        ));

        $res = $github->push($repoName, $splitBranch, $branchToPush, $isTargetEmpty);
        if ($res[0]) {
            $output->writeln(sprintf('<comment>%s</comment>: Push succeeded.', $componentId));
        } else {
            $output->writeln(sprintf('<error>%s</error>: Push failed.', $componentId));

            return false;
        }

        $output->writeln('');
        $output->writeln('<comment>[info]</comment> Creating GitHub tag.');

        $notes = $releaseNotes->get($componentId);
        if (!$notes) {
            $notes = sprintf(
                'For release notes, please see the [associated Google Cloud PHP release](%s).',
                $parentTagSource
            );
        }

        $res = $github->createRelease(
            $repoName,
            $tagName,
            $component->getPackageName() . ' ' . $tagName,
            $notes
        );

        if ($res) {
            $output->writeln(sprintf('<comment>%s</comment>: Tag succeeded.', $componentId));
        } else {
            $output->writeln(sprintf('<error>%s</error>: Tag failed.', $componentId));

            return false;
        }

        // This is the first release!
        if ($tagName === 'v0.1.0') {
            // Ensure issues/projects/wiki/pages/discussion are disabled and the repo is public
            $ret = $github->updateRepoDetails($repoName, [
                'has_issues' => false,
                'has_projects' => false,
                'has_wiki' => false,
                'has_pages' => false,
                'has_discussions' => false,
                'visibility' => 'public',
            ]);

            if ($ret) {
                $output->writeln(sprintf('<comment>%s</comment>: Disabled repo issues/projects/etc for first release.', $componentId));
            } else {
                $output->writeln(sprintf('<error>%s</error>: Unable to update repo details.', $componentId));

                return false;
            }

            // Submit the new package to Packagist and add a webhook to update it
            if ($packagist) {
                $output->writeln('<comment>[info]</comment> Creating Packagist package.');

                $res = $packagist->submitPackage('https://github.com/' . $repoName);

                if ($res) {
                    $output->writeln(sprintf('<comment>%s</comment>: Packagist package created.', $componentId));
                } else {
                    $output->writeln(sprintf('<error>%s</error>: Unable to create Packagist package.', $componentId));

                    return false;
                }

                // use the safe API token if possible
                $apiToken = $packagist->getSafeApiToken() ?: $packagist->getApiToken();
                if ($github->addWebhook($repoName, $packagist->getWebhookUrl(), $apiToken)) {
                    $output->writeln(sprintf('<comment>%s</comment>: Packagist webhook package created.', $componentId));
                } else {
                    $output->writeln(sprintf('<error>%s</error>: Unable to create Packagist webhook.', $componentId));

                    return false;
                }
            }

            // Ensure "yoshi-php" is an admin
            $ret = $github->updateTeamPermission('googleapis', 'yoshi-php', $repoName, 'admin');

            if ($ret) {
                $output->writeln(sprintf('<comment>%s</comment>: Added "yoshi-php" as admin.', $componentId));
            } else {
                $output->writeln(sprintf('<error>%s</error>: Unable to add "yoshi-php" as admin.', $componentId));

                return false;
            }
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

        return new GitHub($shell, $guzzle, $token, $output);
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
        // Create a new HTTP Errors middleware with a body summarizer of length
        // 240 characters (the default is 120)
        $httpErrorsMiddleware = Middleware::httpErrors(new BodySummarizer(240));
        $stack = HandlerStack::create();
        $stack->remove('http_errors');
        $stack->unshift($httpErrorsMiddleware, 'http_errors');
        return new Client(['handler' => $stack]);
    }

    private function writeDiv(OutputInterface $output)
    {
        $output->writeln('--------');
    }
}
