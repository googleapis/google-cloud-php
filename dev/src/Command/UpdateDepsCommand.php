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
 * Update package dependencies
 *
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
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED|InputOption::VALUE_IS_ARRAY, 'bumps deps for the specified component/file')
            ->addOption('bump', '', InputOption::VALUE_NONE, 'Bump to latest version of the package')
            ->addOption('add', '', InputOption::VALUE_OPTIONAL, 'Adds the dep if it doesn\'t exist (--add=dev for require-dev)', false)
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

        $projectRoot = realpath(__DIR__ . '/../../../');
        $result = (new Finder())->files()->in($projectRoot)->depth('<= 1')->name('composer.json');
        $paths = array_map(fn ($file) => $file->getPathname(), iterator_to_array($result));
        sort($paths);

        $componentPath = $input->getOption('local') ? $this->getComponentName($paths, $package) : null;
        $updateCount = 0;
        foreach ($input->getOption('component') ?: $paths as $jsonFile) {
            if (is_dir($jsonFile) && file_exists($jsonFile . '/composer.json')) {
                $jsonFile .= '/composer.json';
            }
            $composerJson = json_decode(file_get_contents($jsonFile), true);
            $require = 'require';
            if (!isset($composerJson['require'][$package])) {
                if (isset($composerJson['require-dev'][$package])) {
                    $require = 'require-dev';
                } elseif (false === $input->getOption('add')) {
                    continue;
                } elseif ('dev' === $input->getOption('add')) {
                    $require = 'require-dev';
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
            $output->writeln(sprintf('Updated <info>%s</>', basename(dirname($jsonFile))));
            file_put_contents($jsonFile, json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
            $updateCount++;
        }
        $output->writeln("Updated <fg=white>$updateCount packages</> to use <comment>$package</>: <info>$version</>");

        return 0;
    }

    private function getComponentName(array $paths, string $package): string
    {
        foreach ($paths as $path) {
            $composerJson = json_decode(file_get_contents($path), true);
            if (isset($composerJson['name']) && $composerJson['name'] === $package) {
                return basename(dirname($path));
            }
        }

        throw new \InvalidArgumentException('Component not found for package ' . $package);
    }
}
