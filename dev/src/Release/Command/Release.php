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

use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Release extends Command
{
    const PATH_MANIFEST = 'docs/manifest.json';
    const PATH_SERVICE_BUILDER = 'src/ServiceBuilder.php';

    private $cliBasePath;

    public function __construct($cliBasePath)
    {
        $this->cliBasePath = $cliBasePath;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('release')
             ->setDescription('Prepares a new release')
             ->addArgument('version', InputArgument::REQUIRED, 'The new version number');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (strpos($input->getArgument('version'), 'v') === 0) {
            throw new RuntimeException('Please do not include the `v` version prefix.');
        }

        $output->writeln(sprintf(
            'Adding version %s to Documentation Manifest.',
            $input->getArgument('version')
        ));

        $this->addToManifest($input->getArgument('version'));

        $output->writeln(sprintf(
            'Setting ServiceBuilder version constant to %s.',
            $input->getArgument('version')
        ));

        $this->updateServiceBuilder($input->getArgument('version'));

        $output->writeln(sprintf(
            'Release %s generated!',
            $input->getArgument('version')
        ));
    }

    private function addToManifest($version)
    {
        $path = $this->cliBasePath .'/../'. self::PATH_MANIFEST;
        if (!file_exists($path)) {
            throw new RuntimeException('Manifest file not found at '. $path);
        }

        $manifest = json_decode(file_get_contents($path), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Could not decode manifest json');
        }

        array_unshift($manifest['versions'], 'v'. $version);

        $result = file_put_contents($path, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ."\n");

        if (!$result) {
            throw new RuntimeException('File write failed');
        }
    }

    private function updateServiceBuilder($version)
    {
        $path = $this->cliBasePath .'/../'. self::PATH_SERVICE_BUILDER;
        if (!file_exists($path)) {
            throw new RuntimeException('ServiceBuilder not found at '. $path);
        }

        $sb = file_get_contents($path);

        $replacement = sprintf("const VERSION = '%s';", $version);

        $sb = preg_replace("/const VERSION = '[0-9.]{0,}'\;/", $replacement, $sb);

        $result = file_put_contents($path, $sb);

        if (!$result) {
            throw new RuntimeException('File write failed');
        }
    }
}
