<?php
/*
 * Copyright 2025 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Dev\Command;

use Google\Cloud\Dev\Component;
use Google\Cloud\Dev\Packagist;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class ReleaseVerifyCommand extends Command
{
    protected function configure()
    {
        $this->setName('release:verify')
            ->setDescription('Verifies the package version from packagist.')
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED,
                'Get info for a single component'
            )
            ->addOption(
                'package-version',
                '',
                InputOption::VALUE_REQUIRED,
                'The version to check for'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $packagist = new Packagist(new Client(), '', '', null, $output);
        $components = Component::getComponents($input->getOption('component') ? [$input->getOption('component')] : []);
        $overrideVersion = $input->getOption('package-version');

        $notFound = [];
        foreach ($components as $component) {
            $packageName = $component->getPackageName();
            if (!($version = $overrideVersion) && !($version = $component->getComposerVersion())) {
                $version = 'v' . $component->getPackageVersion();
            }

            $output->write(sprintf('Verifying package <info>%s</info> version <info>%s</info>... ', $packageName, $version));
            if ($packagist->versionExists($packageName, $version)) {
                $output->writeln('<info>OK</info>');
            } else {
                $output->writeln('<error>NOT FOUND</error>');
                $notFound[] = $packageName . ':' . $version;
            }
        }

        if (count($notFound) > 0) {
            $output->writeln(sprintf('<error>%s package version(s) NOT FOUND</error>', count($notFound)));
            foreach ($notFound as $notFoundPackageName) {
                $output->writeln(sprintf('<error>%s</error>', $notFoundPackageName));
            }
            return 1;
        }

        return 0;
    }
}
