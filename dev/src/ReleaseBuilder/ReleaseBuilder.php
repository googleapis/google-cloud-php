<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Dev\ReleaseBuilder;

use Google\Cloud\Dev\Command\GoogleCloudCommand;
use Google\Cloud\Dev\ComponentVersionTrait;
use Google\Cloud\Dev\QuestionTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use vierbergenlars\SemVer\version;

/**
 * An interactive CLI for creating releases.
 */
class ReleaseBuilder extends GoogleCloudCommand
{
    use ComponentVersionTrait;
    use QuestionTrait;

    const TOKEN_ENV = 'GH_OAUTH_TOKEN';
    const COMPONENT_BASE = '%s/';
    const DEFAULT_COMPONENT = 'google-cloud';
    const DEFAULT_COMPONENT_COMPOSER = '%s/composer.json';
    const PATH_MANIFEST = '%s/docs/manifest.json';
    const TARGET_REGEX = '/([a-zA-Z0-9-_]{1,})\/([a-zA-Z0-9-_]{1,})\.git/';

    const GITHUB_RELEASES_ENDPOINT = 'https://api.github.com/repos/%s/%s/releases/tags/%s';
    const GITHUB_COMPARE_ENDPOINT = 'https://api.github.com/repos/%s/%s/compare/%s...master';

    CONST LEVEL_PATCH = 0;
    const LEVEL_MINOR = 1;
    const LEVEL_MAJOR = 2;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var string
     */
    private $manifest;

    /**
     * @var string
     */
    private $components;

    /**
     * @var string
     */
    private $defaultComponentComposer;

    /**
     * A list of allowable release types.
     *
     * @var array
     */
    private $allowedReleaseTypes = [
        self::LEVEL_PATCH,
        self::LEVEL_MINOR,
        self::LEVEL_MAJOR,
    ];

    /**
     * A list of release types with their human-readable names.
     *
     * @var array
     */
    private $levels = [
        self::LEVEL_PATCH => 'patch',
        self::LEVEL_MINOR => 'minor',
        self::LEVEL_MAJOR => 'major',
    ];

    public function __construct($rootPath)
    {
        $this->manifest = sprintf(self::PATH_MANIFEST, $rootPath);
        $this->components = sprintf(self::COMPONENT_BASE, $rootPath);
        $this->defaultComponentComposer = $rootPath .'/composer.json';

        $this->http = new Client;
        $this->token = getenv(self::TOKEN_ENV);

        parent::__construct($rootPath);
    }

    protected function configure()
    {
        $this->setName('rb')
             ->setDescription('An interactive tool for creating releases.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $version = $this->getComponentVersion($this->manifest, 'google-cloud');
        $composer = $this->getComponentComposer($this->manifest, 'google-cloud');
        list ($org, $repo) = $this->getOrgAndRepo($composer);

        if (!$this->hasExpectedBase($org, $repo, $version)) {
            throw new \RuntimeException(sprintf(
                'Expected tag %s not found in %s/%s',
                $version,
                $org,
                $repo
            ));
        }

        $commits = $this->getCommits($org, $repo, $version);
        $output->writeln(sprintf('%s commits found.', count($commits)));

        $release = [];
        foreach ($commits as $commit) {
            $components = $this->getCommitComponentModifiedList($commit['url']);
            if (!$components) {
                continue;
            }

            $commitRelease = $this->interactiveCommitRelease($output, $commit, $components);
            $release = $this->mergeCommitIntoRelease($release, $commitRelease);
        }

        $release = $this->determineUmbrellaLevel($release);
        $release = $this->determineReleaseVersions($release);

        $this->updateComponentVersions($release);
        $notesLocation = $this->createReleaseNotes($release);

        $output->writeln(sprintf(
            '<fg=white;bg=green>Release created!</>'. PHP_EOL .'Release notes generated at <info>%s</info>',
            realpath($notesLocation)
        ));
    }

    /**
     * Iterate through a release and do the work of preparing a release.
     *
     * @param array $release An associative array, where the key is the
     *        component ID and the value is structured data describing the
     *        release.
     * @return void
     */
    private function updateComponentVersions(array $release)
    {
        foreach ($release as $key => $releaseComponent)
        {
            $component = $this->getComponentComposer($this->rootPath(), $key);

            $this->addToComponentManifest($releaseComponent['version'], $component);
            foreach ((array) $component['entry'] as $entry) {
                $entryUpdated = $this->updateComponentVersionConstant(
                    $releaseComponent['version'],
                    $component['path'],
                    $entry
                );
            }

            if ($component['id'] !== 'google-cloud') {
                $this->updateComponentVersionFile($releaseComponent['version'], $component);
                $this->updateComposerReplacesVersion($releaseComponent['version'], $component);
            }
        }
    }

    /**
     * Iterate through a release and determine the new version numbers based on
     * the release type of each component (patch, minor, major) and the latest
     * previous release number.
     *
     * @param array $release An associative array, where the key is the
     *        component ID and the value is structured data describing the
     *        release.
     * @return array $release
     */
    private function determineReleaseVersions(array $release)
    {
        foreach ($release as $key => &$component) {
            $latestVersion = $this->getComponentVersion($this->manifest, $key);
            $latestVersion = $latestVersion !== 'master'
                ? $latestVersion
                : '0.0.0';

            $oldVersion = new version($latestVersion);

            $component['version'] = (string) $oldVersion->inc($this->levels[$component['level']]);
        }

        return $release;
    }

    /**
     * Determine the release level of the umbrella package by examining the
     * levels of all affected components and incrementing the umbrella by the
     * highest level of a component release.
     *
     * In other words, if three components are released as patches, the umbrella
     * will be a patch release. If there are any minor releases, the umbrella is
     * released as a minor. The umbrella package will never be incrememted as a
     * major release.
     *
     * @param array $release An associative array, where the key is the
     *        component ID and the value is structured data describing the
     *        release.
     * @return array $release
     */
    private function determineUmbrellaLevel(array $release)
    {
        $levels = [];
        array_walk($release, function ($component) use (&$levels) {
            $levels[] = $component['level'];
        });

        $levels = array_unique($levels);
        rsort($levels);

        // Since we don't use major versions of the umbrella, major versions of
        // components only bump the umbrella by a minor increment.
        if ($levels[0] === self::LEVEL_MAJOR) {
            $levels[0] = self::LEVEL_MINOR;
        }

        $release[self::DEFAULT_COMPONENT] = [
            'level' => $levels[0]
        ];

        return $release;
    }

    /**
     * Build a release notes markdown file.
     *
     * @param array $release An associative array, where the key is the
     *        component ID and the value is structured data describing the
     *        release.
     * @return void
     */
    private function createReleaseNotes(array $release)
    {
        $locationTemplate = $this->rootPath .'/build/release-%s.md';

        $umbrella = $release[self::DEFAULT_COMPONENT];
        $location = sprintf($locationTemplate, $umbrella['version']);

        unset($release[self::DEFAULT_COMPONENT]);

        ksort($release);

        $notes = [];
        foreach ($release as $key => $component) {
            $messages = [];
            foreach ($component['messages'] as $message) {
                $messages[] = sprintf('* %s', $message);
            }

            $notes[] = sprintf('### google/%s v%s', $key, $component['version'])
                . PHP_EOL . PHP_EOL . implode(PHP_EOL, $messages);
        }

        $template = file_get_contents(__DIR__ .'/templates/release-notes.md.txt');
        $template = str_replace('{version}', $umbrella['version'], $template);
        $template = str_replace('{notes}', implode(PHP_EOL . PHP_EOL, $notes), $template);

        file_put_contents($location, $template);

        return $location;
    }

    /**
     * Interlace new commit release data into an existing release structure.
     *
     * @param array $release An associative array, where the key is the
     *        component ID and the value is structured data describing the
     *        release.
     * @param array $commitRelease The release data generated for a single commit.
     * @return array $release
     */
    private function mergeCommitIntoRelease(array $release, array $commitRelease)
    {
        foreach ($commitRelease as $key => $commit) {
            if (!isset($release[$key])) {
                $release[$key] = [
                    'level' => $commit['level'],
                    'messages' => [$commit['message']]
                ];
            } else {
                $release[$key]['messages'][] = $commit['message'];
                $release[$key]['level'] = ($release[$key]['level'] >= $commit['level'])
                    ? $release[$key]['level']
                    : $commit['level'];
            }
        }

        return $release;
    }

    /**
     * Determine defaults for components affected by the commit, display an
     * overview and provide an interface for modifications.
     *
     * @param OutputInterface $output The Symfony Output for writing to stdout
     * @param array $commit The commit data.
     * @param array $components Components modified by the commit.
     * @return array Structured data about components modified in this commit.
     */
    private function interactiveCommitRelease(OutputInterface $output, array $commit, array $components)
    {
        $commitRelease = $this->processCommit($output, $commit, $components);

        $proceed = false;
        do {
            $this->displayCommitSummary($output, $commitRelease);

            $output->writeln('');

            $choices = [
                'Proceed without changes',
                'Change component release type or message.',
                'Start over'
            ];
            $q = $this->choice('Choose an action', $choices, $choices[0]);

            $action = $this->removeDefaultFromChoice($this->askQuestion($q));

            switch ($action) {
                case $choices[0]:
                    $proceed = true;
                    break;

                case $choices[1]:
                    $commitRelease = $this->handleChange($output, $commitRelease);
                    break;

                case $choices[2]:
                    $commitRelease = $this->processCommit($output, $commit, $components);
                    break;
            }
        } while (!$proceed);

        $output->writeln('');

        return $commitRelease;
    }

    /**
     * An interactive flow for modifying release data.
     *
     * @param OutputInterface $output
     * @param array $commitRelease Structured data about components modified by
     *        the current commit.
     */
    public function handleChange(OutputInterface $output, array $commitRelease)
    {
        $choices = array_keys($commitRelease);

        $noMoreChanges = false;
        do {
            if (count($choices) > 1) {
                $q = $this->choice('Choose a component to modify.', array_merge($choices, [
                    'Go Back'
                ]));
                $component = $this->askQuestion($q);

                if ($component === 'Go Back') {
                    $noMoreChanges = true;
                    continue;
                }
            } else {
                $component = $choices[0];
            }

            $componentOverview = sprintf(
                '<info>google/%s</info> [<info>%s</info>]:',
                $component,
                $this->levels[$commitRelease[$component]['level']]
            );

            $q = $this->choice(sprintf('%s What to you want to change?', $componentOverview), [
                'Message',
                'Release Type',
                'Go Back'
            ]);
            $action = $this->askQuestion($q);

            switch ($action) {
                case 'Message':
                    $commitRelease[$component]['message'] = $this->askMessage(
                        $commitRelease[$component],
                        $componentOverview
                    );
                    break;

                case 'Release Type':
                    $commitRelease[$component]['level'] = $this->askLevel(
                        $componentOverview
                    );
                    break;

                case 'Go Back':
                    if (count($choices) === 1) {
                        $noMoreChanges = true;
                    }

                    continue;
                    break;
            }
        } while (!$noMoreChanges);

        return $commitRelease;
    }

    /**
     * Interactive multiple-choice dialog to select a release level.
     *
     * @param string $overview A string describing the name and current state of
     *        the component.
     * @return int The new commit level.
     */
    private function askLevel($overview)
    {
        $q = $this->choice(sprintf(
            '%s Choose a release level.',
            $overview
        ), $this->levels);

        $level = $this->askQuestion($q);

        return array_search($level, $this->levels);
    }

    /**
     * An interactive dialog to modify the release note for a component.
     *
     * @param array $component An array containing component data.
     * @param string $overview A string describing the name and current state of
     *        the component.
     * @return string
     */
    private function askMessage(array $component, $overview)
    {
        $message = $this->ask(sprintf(
            '%s Enter a release note message. Do not enter the Pull Request reference number.'.
            PHP_EOL .'  - Message: <info>%s</info>',
            $overview,
            $component['message']
        ), $component['message']);

        $message .= ' (#'. $component['ref'] .')';

        return $message;
    }

    /**
     * Top-level CLI to process a single commit and display information to the user.
     *
     * @param OutputInterface $output
     * @param array $commit Data about the commit.
     * @param array $components Data about all components modified in the commit.
     * @return array
     */
    private function processCommit(OutputInterface $output, array $commit, array $components)
    {
        $output->writeln(sprintf(
            'Processing Commit: <info>%s</info>',
            $commit['message']
        ));
        $output->writeln(sprintf('View on GitHub: %s', $commit['htmlUrl']));
        $output->writeln('----------');
        $output->writeln('');

        $message = trim($this->ask('Enter a release summary for this commit. You can change this later.', $commit['message']));

        $commitRelease = [];
        foreach ($components as $key => $component) {
            $componentRelease = isset($commitRelease[$key])
                ? $commitRelease[$key]
                : ['level' => self::LEVEL_PATCH, 'message' => '', 'reasons' => []];

            $lowestAllowedLevel = $componentRelease['level'];
            $suggestedLevel = $lowestAllowedLevel;
            $allowedLevels = array_filter($this->levels, function ($name, $key) use ($lowestAllowedLevel) {
                return $key >= $lowestAllowedLevel;
            }, ARRAY_FILTER_USE_BOTH);

            $output->writeln(sprintf('Component <comment>%s</comment> modified by commit.', $key));

            list ($suggestedLevel, $reasons) =
                $this->determineSuggestedLevel($allowedLevels, $suggestedLevel, $component['files']);

            $output->writeln(sprintf(
                'We suggest a <info>%s</info> release because of the following reasons. Please do not use this as an ' .
                'absolute guide, as this tool is unable to determine the correct outcome in every scenario.',
                $this->levels[$suggestedLevel]
            ));
            $output->writeln('');

            foreach ($reasons as $reason) {
                $output->writeln('* '. $reason);
            }

            $output->writeln('');

            $componentRelease['level'] = $suggestedLevel;
            $componentRelease['message'] = $message .' (#'. $commit['reference'] .')';
            $componentRelease['reasons'] = array_merge($componentRelease['reasons'], $reasons);
            $componentRelease['ref'] = $commit['reference'];

            $commitRelease[$key] = $componentRelease;
        }

        return $commitRelease;
    }

    /**
     * Formatted summary of the release state of components in the commit.
     *
     * @param OutputInterface $output
     * @param array $commitRelease Release data scoped to a single commit.
     * @return void
     */
    private function displayCommitSummary(OutputInterface $output, array $commitRelease)
    {
        $output->writeln('Commit Summary');
        $output->writeln('-----');

        foreach ($commitRelease as $key => $releaseInfo) {
            $output->writeln(sprintf('<info>google/%s</info> [<info>%s</info>]', $key, $this->levels[$releaseInfo['level']]));
            $output->writeln(sprintf('  - Message: <info>%s</info>', $releaseInfo['message']));
        }
    }

    /**
     * Logic to determine the best release level for a component.
     *
     * @param array $levelChoices Allowed levels for the component.
     * @param string $suggestedLevel The current suggested level for the release.
     * @param array $files A list of files in the component folder modified in
     *        the commit.
     * @return array [$suggestedLevel, $reasons]
     */
    private function determineSuggestedLevel(array $levelChoices, $suggestedLevel, array $files)
    {
        $reasons = [];

        if ($levelChoices !== $this->levels) {
            $suggestedLevel = array_keys($levelChoices)[0];
            $reasons[] = 'Another change specified a higher minimum release level.';
        }

        if (isset($levelChoices[self::LEVEL_MINOR]) && (bool) array_filter($files, function ($file) {
            $parts = explode('/', $file);
            return isset($parts[1]) && $parts[1] === 'src' && count($parts) > 2;
        })) {
            $suggestedLevel = self::LEVEL_MINOR;
            $reasons[] = 'There are changes in the component `src` folder.';
        }

        if (isset($levelChoices[self::LEVEL_MINOR]) && in_array('composer.json', $files)) {
            $suggestedLevel = self::LEVEL_MINOR;
            $reasons[] = 'The component `composer.json` file was modified.';
        }

        if ($suggestedLevel === self::LEVEL_PATCH) {
            $reasons[] = 'None of the indicators show the commit includes a client-facing code change.';
        }

        return [$suggestedLevel, $reasons];
    }

    /**
     * Parse the organization and repo from a composer file.
     *
     * @param array $composer
     * @return array [$org, $repo]
     */
    private function getOrgAndRepo(array $composer)
    {
        $target = $composer['target'];

        $matches = [];
        preg_match(self::TARGET_REGEX, $target, $matches);

        $org = $matches[1];
        $repo = $matches[2];

        return [$org, $repo];
    }

    /**
     * Check that a Github Repository has the expected release.
     *
     * Used to verify existence of the previous release to compare against.
     *
     * @param string $org The github organization
     * @param string $repo The github repository name.
     * @param string $version The version to search for.
     * @return bool
     */
    private function hasExpectedBase($org, $repo, $version)
    {
        $url = sprintf(
            self::GITHUB_RELEASES_ENDPOINT,
            $org,
            $repo,
            $version
        );

        try {
            $res = $this->http->get($url, [
                'auth' => [null, $this->token]
            ]);
            return true;
        } catch (RequestException $e) {
            return false;
        }
    }

    /**
     * Get a list of commits between a version and the current repository state.
     *
     * @param string $org The github organization
     * @param string $repo The github repository name.
     * @param string $version The version to search for.
     * @return array
     */
    private function getCommits($org, $repo, $version)
    {
        $url = sprintf(
            self::GITHUB_COMPARE_ENDPOINT,
            $org,
            $repo,
            $version
        );

        $res = json_decode($this->http->get($url, [
            'auth' => [null, $this->token]
        ])->getBody(), true);
        $commits = [];
        foreach ($res['commits'] as $commit) {
            $message = $commit['commit']['message'];

            $description = explode("\n", $message)[0];
            $matches = [];
            preg_match('/(.{0,})\(\#(\d{1,})\)/', $description, $matches);
            $commits[] = [
                'url' => $commit['url'],
                'htmlUrl' => $commit['html_url'],
                'message' => trim($matches[1]),
                'reference' => $matches[2],
                'hash' => $commit['sha']
            ];
        }

        return $commits;
    }

    /**
     * Query the github API for a list of files modified by a commit.
     *
     * @param string $url The URL to the commit.
     * @return array A list of files.
     */
    private function getCommitComponentModifiedList($url)
    {
        $commit = json_decode($this->http->get($url, [
            'auth' => [null, $this->token]
        ])->getBody(), true);

        $changedComponents = [];
        $fileDirectoryComponent = [];
        foreach ($commit['files'] as $file) {
            $filename = $file['filename'];
            if (strpos($filename, '/') === false) {
                continue;
            }

            $fileParts = explode('/', $filename);
            $componentDirectory = $fileParts[0];

            $composerPath = $this->rootPath .'/'. $componentDirectory .'/composer.json';
            if (!array_key_exists($composerPath, $fileDirectoryComponent)) {
                if (!file_exists($composerPath)) {
                    continue;
                }

                $composer = json_decode(file_get_contents($composerPath), true)['extra']['component'];
                $fileDirectoryComponent[$composerPath] = $composer;
            } else {
                $composer = $fileDirectoryComponent[$composerPath];
            }

            if (!isset($changedComponents[$composer['id']])) {
                $changedComponents[$composer['id']] = [
                    'files' => [],
                    'level' => 'minor'
                ];
            }

            $changedComponents[$composer['id']]['files'][] = $file['filename'];
        }

        return $changedComponents;
    }

    protected function questionHelper()
    {
        return $this->getHelper('question');
    }

    protected function input()
    {
        return $this->input;
    }

    protected function output()
    {
        return $this->output;
    }

    protected function rootPath()
    {
        return $this->rootPath;
    }

    protected function manifest()
    {
        return $this->manifest;
    }
}
