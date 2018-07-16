<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Dev\Release;

use Google\Cloud\Dev\Command\GoogleCloudCommand;
use Google\Cloud\Dev\ComponentVersionTrait;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use vierbergenlars\SemVer\version;

class Release extends GoogleCloudCommand
{
    use ComponentVersionTrait;

    const COMPONENT_BASE = '%s/';
    const DEFAULT_COMPONENT = 'google-cloud';
    const DEFAULT_COMPONENT_COMPOSER = '%s/composer.json';
    const PATH_MANIFEST = '%s/docs/manifest.json';

    private $manifest;

    private $defaultComponentComposer;

    private $components;

    private $allowedReleaseTypes = [
        'major', 'minor', 'patch'
    ];

    public function __construct($rootPath)
    {
        $this->manifest = sprintf(self::PATH_MANIFEST, $rootPath);
        $this->defaultComponentComposer = sprintf(self::DEFAULT_COMPONENT_COMPOSER, $rootPath);
        $this->components = sprintf(self::COMPONENT_BASE, $rootPath);

        parent::__construct($rootPath);
    }

    protected function configure()
    {
        $this->setName('release')
             ->setDescription('Prepares a new release')
             ->addArgument('version', InputArgument::REQUIRED, 'The new version number.')
             ->addArgument('component', InputArgument::OPTIONAL, '[optional] The component ID. Defaults to `google-cloud`.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $componentInput = $input->getArgument('component') ?: self::DEFAULT_COMPONENT;
        $component = $this->getComponentComposer($this->rootPath, $componentInput);

        $version = $input->getArgument('version');

        // If the version is one of "major", "minor" or "patch", determine the
        // correct incrementation.
        if (in_array(strtolower($version), $this->allowedReleaseTypes)) {
            $version = $this->getNextVersionName($version, $component);
        }

        try {
            $validatedVersion = new version($version);
        } catch (\Exception $e) {
            throw new RuntimeException(sprintf(
                'Given version %s is not a valid version name',
                $version
            ));
        }

        $version = (string) $validatedVersion;

        $output->writeln(sprintf(
            'Adding version %s to Documentation Manifest for component %s.',
            $version,
            $component['id']
        ));

        $this->addToComponentManifest($version, $component);

        $output->writeln(sprintf(
            'Setting component version constant to %s.',
            $version
        ));

        foreach ((array) $component['entry'] as $entry) {
            $entryUpdated = $this->updateComponentVersionConstant(
                $version,
                $component['path'],
                $entry
            );
            if ($entryUpdated) {
                $output->writeln(sprintf(
                    'File %s VERSION constant updated to %s',
                    $entry,
                    $version
                ));
            }
        }

        if ($component['id'] !== 'google-cloud') {
            $this->updateComponentVersionFile($version, $component);
            $output->writeln(sprintf(
                'Component %s VERSION file updated to %s',
                $component['id'],
                $version
            ));

            $this->updateComposerReplacesVersion($version, $component);

            $output->writeln(sprintf(
                'google-cloud composer replaces for component %s updated to version %s',
                $component['id'],
                $version
            ));
        }

        $output->writeln(sprintf(
            'Release %s generated!',
            $version
        ));
    }

    private function getNextVersionName($type, array $component)
    {
        $manifest = $this->getComponentManifest($this->manifest, $component['id']);

        if ($manifest['versions'][0] === 'master') {
            $lastRelease = new version('0.0.0');
        } else {
            $lastRelease = new version($manifest['versions'][0]);
        }

        return $lastRelease->inc($type);
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
