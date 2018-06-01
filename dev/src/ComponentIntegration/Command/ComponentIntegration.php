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

namespace Google\Cloud\Dev\ComponentIntegration\Command;

use Google\Cloud\Dev\Command\GoogleCloudCommand;
use Google\Cloud\Dev\GetComponentsTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use vierbergenlars\SemVer\version;

/**
 * Test component integration.
 */
class ComponentIntegration extends GoogleCloudCommand
{
    use GetComponentsTrait;

    const TESTING_DIR = '.testing';
    const MANIFEST_PATH = 'docs/manifest.json';

    private $execute = false;
    private $tmpDir;
    private $output;

    protected function configure()
    {
        $this->setName('integration')
            ->setDescription('Test each component individually.')
            ->addOption('umbrella', 'u', InputOption::VALUE_NONE, 'If set, umbrella version update check will be skipped.')
            ->addOption('preserve', 'p', InputOption::VALUE_NONE, 'If set, testing directory will not be deleted if an error occurs. ' .
                'This may be a useful tool when debugging problems.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->execute = true;
        $this->output = $output;

        $rootPath = $this->rootPath;
        $manifestPath = $rootPath . DIRECTORY_SEPARATOR . self::MANIFEST_PATH;

        $components = $this->getComponents($rootPath, $rootPath);

        $dest = $rootPath . DIRECTORY_SEPARATOR . self::TESTING_DIR;
        $this->tmpDir = $dest;
        @mkdir($dest);

        // If `--preserve|-p` is not provided, .testing will be deleted if an error occurs.
        if (!$input->getOption('preserve')) {
            register_shutdown_function(function () use ($dest) {
                $this->deleteTmp($dest);
            });
        }

        $guzzle = new Client;

        // Check that the umbrella version is updated.
        $skipUmbrellaCheck = $input->getOption('umbrella');
        $isUmbrellaUpdated = $this->checkUmbrellaUpdate($guzzle, $rootPath, $manifestPath);

        if (!$skipUmbrellaCheck && !$isUmbrellaUpdated) {
            throw new \RuntimeException('Umbrella package version has not been updated!');
        }

        // do setup on components -- copy to tmp directory and check version info
        foreach ($components as &$component) {
            $tmpDir = $this->copyComponent($rootPath, $dest, $component);

            $localLatestVersion = $this->getComponentVersion($manifestPath, $component['id']);
            $remoteLatestVersion = $this->getRemoteLatestVersion($guzzle, $component);

            // If the latest version in the manifest is greater than the latest remote,
            // then the component is being updated.
            // use semver to normalize both versions.
            $isUpdated = version::gt($localLatestVersion, $remoteLatestVersion);
            $component['useLocalPath'] = $isUpdated;
            $component['tmpDir'] = $tmpDir;
        }

        $components = $this->updateComposerFiles($dest, $components);

        // run tests on each component.
        foreach ($components as $component) {
            if (isset($component['missingDependency']) && $component['missingDependency']) {
                $this->output->writeln('<comment>Skipping '. $component['id'] .' because a required PHP extension is missing.</comment>');
                $this->output->writeln('');
                continue;
            }

            $this->testComponent($component);
        }

        $this->deleteTmp($dest);
    }

    private function checkUmbrellaUpdate(Client $guzzle, $rootPath, $manifestPath)
    {
        $component = $this->getComponentComposer($rootPath, 'google-cloud', $rootPath .'/composer.json');
        $localLatestVersion = $this->getComponentVersion($manifestPath, $component['id']);
        $remoteLatestVersion = $this->getRemoteLatestVersion($guzzle, $component);

        return version::gt($localLatestVersion, $remoteLatestVersion);
    }

    private function copyComponent($rootPath, $dest, array $component)
    {
        $src = $rootPath . DIRECTORY_SEPARATOR . $component['path'];
        $dest = $dest . DIRECTORY_SEPARATOR . $component['id'];

        if (file_exists($dest)) {
            $this->deleteTmp($dest);
        }

        $this->output->writeln('Creating temp directory for '. $component['id']);
        $this->output->writeln('path: '. $dest);
        $this->output->writeln('');

        @mkdir($dest);
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            } else {
                copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
        }

        return $dest;
    }

    private function deleteTmp($path)
    {
        $this->output->writeln('Deleting '. $path);
        $this->output->writeln('');

        if (!strpos($this->tmpDir, $path) === false) {
            throw new \RuntimeException('cannot delete files outside test root path.');
        }

        passthru('rm -rf '. $path);
    }

    private function getRemoteLatestVersion(Client $guzzle, array $component)
    {
        $target = str_replace('.git', '', trim($component['target'], '/'));

        $uri = 'https://api.github.com/repos/'. $target .'/releases/latest';
        if (getenv('GH_OAUTH_TOKEN')) {
            $uri .= '?access_token='. getenv('GH_OAUTH_TOKEN');
        }

        try {
            $res = $guzzle->get($uri);
        } catch (RequestException $e) {
            return '0.0.0';
        }

        $release = json_decode((string) $res->getBody(), true);

        if (!isset($release['tag_name'])) {
            throw new \RuntimeException('Unexpected response from '. $uri);
        }

        return $release['tag_name'];
    }

    private function updateComposerFiles($tmpDir, array $components)
    {
        $repositories = [];
        $aliases = [];

        foreach ($components as $component) {
            if (!$component['useLocalPath']) {
                continue;
            }

            $repositories[] = [
                'type' => 'path',
                'url' => '../'. $component['id']
            ];

            $aliases[] = $component['id'];
        }

        foreach ($components as &$component) {
            $composerFile = $component['tmpDir'] . DIRECTORY_SEPARATOR .'composer.json';
            $composer = json_decode(file_get_contents($composerFile), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException(sprintf(
                    'Could not decode composer file %s. Got error %s',
                    $composerFile,
                    json_last_error_msg()
                ));
            }

            foreach ($aliases as $alias) {
                $id = $component['id'];
                if (
                    !in_array($id, $aliases) && (
                    array_key_exists('google/'. $alias, $composer['require']) ||
                    array_key_exists('google/'. $alias, $composer['require-dev'])
                )) {
                    $aliases[] = $id;

                    $repositories[] = [
                        'type' => 'path',
                        'url' => '../'. $component['id']
                    ];
                }
            }

            $component['missingDependency'] = false;
            foreach ($composer['require'] as $require => $version) {
                if (strpos($require, 'ext-') === 0) {
                    $ext = str_replace('ext-', '', $require);
                    if (!extension_loaded($ext)) {
                        $component['missingDependency'] = true;
                        continue;
                    }
                }
            }
        }

        foreach ($components as $component) {
            $composerFile = $component['tmpDir'] . DIRECTORY_SEPARATOR .'composer.json';
            $this->modifyComposerFile($composerFile, $repositories, $aliases);
        }

        return $components;
    }

    private function testComponent(array $component)
    {
        $this->output->writeln('<info>Testing component '. $component['id'] .'</info>');
        $this->output->writeln('');
        $commands = [
            "cd {$component['tmpDir']}",
            "composer update --no-suggest",
            "echo \"\\nRUNNING UNIT TESTS\\n\"",
            "vendor/bin/phpunit",
            "echo \"\\nRUNNING SNIPPET TESTS\\n\"",
            "vendor/bin/phpunit -c phpunit-snippets.xml.dist"
        ];

        passthru(implode(" && ", $commands), $exitCode);

        if ($exitCode !== 0) {
            throw new \RuntimeException('Testing '. $component['id'] .' exited with a non-zero code');
        }

        $this->output->writeln('');
    }

    private function modifyComposerFile($composerFile, array $repositories, array $aliases)
    {
        $composer = json_decode(file_get_contents($composerFile), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Could not decode composer file '. $composerFile);
        }

        foreach ($aliases as $alias) {
            if (isset($composer['require']['google/'. $alias])) {
                $composer['require']['google/'. $alias] = "@dev";
            }

            if (isset($composer['require-dev']['google/'. $alias])) {
                $composer['require-dev']['google/'. $alias] = "@dev";
            }
        }

        $oldRepositories = isset($composer['repositories'])
            ? $composer['repositories']
            : [];

        $composer['repositories'] = array_merge($oldRepositories, $repositories);

        file_put_contents($composerFile, json_encode($composer, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    }
}
