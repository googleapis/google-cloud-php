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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

/**
 * List repo details
 * @internal
 */
class UpdateDepsCommand extends Command
{
    protected function configure()
    {
        $this->setName('update-deps')
            ->setDescription('update a dependency across all components')
            ->addArgument('package', InputArgument::REQUIRED, 'Package name to update, e.g. "google/gax"')
            ->addArgument('version', InputArgument::OPTIONAL, 'Package version to update to, e.g. "1.4.0"', '')
            ->addOption('bump', '', InputOption::VALUE_NONE, 'Bump to latest version of the package')
            ->addOption('add', '', InputOption::VALUE_NONE, 'Adds the dep if it doesn\'t exist')
            ->addOption('add-dev', '', InputOption::VALUE_NONE, 'Adds the dep to dev if it doesn\'t exist')
            ->addOption('local', '', InputOption::VALUE_NONE, 'Add a link to the local component')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $package = $input->getArgument('package');
        if (!$version = $input->getArgument('version')) {
            if (!$input->getOption('bump')) {
                throw new \InvalidArgumentException('You must either supply a package version or the --bump flag');
            }
            if (!$version = Composer::getLatestVersion($package)) {
                throw new \InvalidArgumentException('Could not find a version for ' . $package);
            }
        } elseif ($input->getOption('bump')) {
            throw new \InvalidArgumentException('You cannot supply both a package version and the --bump flag');
        }

        if ($input->getOption('add') && $this->getOption('add-dev')) {
            throw new \InvalidArgumentException('You cannot supply both --add and --add-dev');
        }

        $projectRoot = realpath(__DIR__ . '/../../../');
        $result = (new Finder())->files()->in($projectRoot)->depth('<= 1')->name('composer.json');
        $paths = array_map(fn ($file) => $file->getRelativePathname(), iterator_to_array($result));
        sort($paths);

        $componentPath = $input->getOption('local') ? $this->getComponentName($paths, $package) : null;
        $updateCount = 0;
        foreach ($paths as $path) {
            $composerJson = json_decode(file_get_contents($projectRoot . '/' . $path), true);
            if (isset($composerJson['require'][$package])) {
                $require = 'require';
            } elseif (isset($composerJson['require-dev'][$package])) {
                $require = 'require-dev';
            } else {
                // Set a default "require" using "add" and "add-dev" options if it doesn't exist
                $require = $input->getOption('add') ? 'require' : ($input->getOption('add-dev') ? 'require-dev' : null);
                if (!$require) {
                    continue;
                }
                if (!isset($composerJson[$require][$package])) {
                    $composerJson[$require] = [];
                }
            }
            $composerJson[$require][$package] = $version;
            if ($input->getOption('local')) {
                $composerJson['repositories'] ??= [];
                $composerJson['repositories'][] = [
                    'type' => 'path',
                    'url' => '../' . $componentPath,
                    'options' => [
                        'versions' => [$package => $version],
                    ]
                ];
            }
            $output->writeln("Updated <info>$path</>");
            file_put_contents($projectRoot . '/' . $path, json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
            $updateCount++;
        }
        $output->writeln("Updated <fg=white>$updateCount files</> to use <comment>$package</>: <info>$version</>");

        return 0;
    }

    private function getComponentName(array $paths, string $package): string
    {
        foreach ($paths as $path) {
            $composerJson = json_decode(file_get_contents($path), true);
            if (isset($composerJson['name']) && $composerJson['name'] === $package) {
                return dirname($path);
            }
        }

        throw new \LogicException('Component not found for package ' . $package);
    }
}
