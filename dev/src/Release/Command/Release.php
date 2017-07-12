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

namespace Google\Cloud\Dev\Release\Command;

use Google\Cloud\Dev\GetComponentsTrait;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use vierbergenlars\SemVer\version;

class Release extends Command
{
    use GetComponentsTrait;

    const COMPONENT_BASE = '%s/../src';
    const DEFAULT_COMPONENT = 'google-cloud';
    const DEFAULT_COMPONENT_COMPOSER = '%s/../composer.json';
    const PATH_MANIFEST = '%s/../docs/manifest.json';
    const PATH_SERVICE_BUILDER = '%s/../src/ServiceBuilder.php';

    private $cliBasePath;

    private $defaultClient;

    private $manifest;

    private $defaultComponentComposer;

    private $components;

    private $allowedReleaseTypes = [
        'major', 'minor', 'patch'
    ];

    public function __construct($cliBasePath)
    {
        $this->cliBasePath = $cliBasePath;

        $this->defaultClient = sprintf(self::PATH_SERVICE_BUILDER, $cliBasePath);
        $this->manifest = sprintf(self::PATH_MANIFEST, $cliBasePath);
        $this->defaultComponentComposer = sprintf(self::DEFAULT_COMPONENT_COMPOSER, $cliBasePath);
        $this->components = sprintf(self::COMPONENT_BASE, $cliBasePath);

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('release')
             ->setDescription('Prepares a new release')
             ->addArgument('version', InputArgument::REQUIRED, 'The new version number.')
             ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED,
                'The component for which the version should be updated.',
                self::DEFAULT_COMPONENT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $component = $this->getComponentComposer($input->getOption('component'));

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

        $this->updateComponentVersionConstant($version, $component);
        $output->writeln(sprintf(
            'File %s VERSION constant updated to %s',
            $component['entry'],
            $version
        ));

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

    private function addToComponentManifest($version, array $component)
    {
        $manifest = $this->getManifest($this->manifest);
        $index = $this->getManifestComponentModuleIndex($this->manifest, $manifest, $component['id']);

        array_unshift($manifest['modules'][$index]['versions'], 'v'. $version);

        $content = json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ."\n";
        $result = file_put_contents($this->manifest, $content);

        if (!$result) {
            throw new RuntimeException('File write failed');
        }
    }

    private function updateComponentVersionConstant($version, array $component)
    {
        if (is_null($component['entry'])) {
            return false;
        }

        $path = $this->cliBasePath .'/../'. $component['path'] .'/'. $component['entry'];
        if (!file_exists($path)) {
            throw new \RuntimeException(sprintf(
                'Component entry file %s does not exist',
                $path
            ));
        }

        $entry = file_get_contents($path);

        $replacement = sprintf("const VERSION = '%s';", $version);

        $entry = preg_replace("/const VERSION = [\'\\\"]([0-9.]{0,}|master)[\'\\\"]\;/", $replacement, $entry);

        $result = file_put_contents($path, $entry);

        if (!$result) {
            throw new RuntimeException('File write failed');
        }

        return true;
    }

    private function updateComponentVersionFile($version, array $component)
    {
        $path = $this->cliBasePath .'/../'. $component['path'] .'/VERSION';
        $result = file_put_contents($path, $version);

        if (!$result) {
            throw new RuntimeException('File write failed');
        }

        return true;
    }

    private function updateComposerReplacesVersion($version, array $component)
    {
        $composer = $this->cliBasePath .'/../composer.json';
        if (!file_exists($composer)) {
            throw new \Exception('Invalid composer.json path');
        }

        $data = json_decode(file_get_contents($composer), true);

        $data['replace'][$component['name']] = $version;

        file_put_contents($composer, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    }
}
