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

namespace Google\Cloud\Dev\Credentials;

use Google\Cloud\Dev\Command\GoogleCloudCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Configure credentials for tests.
 */
class Command extends GoogleCloudCommand
{
    protected function configure()
    {
        $this->setName('credentials')
            ->setDescription('Configure credentials for system tests')
            ->setHelp(file_get_contents(__DIR__ .'/help.txt'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $base = $this->rootPath;

        $keyfiles = getenv('GOOGLE_CLOUD_PHP_KEYFILES');
        $decoded = json_decode(base64_decode($keyfiles), true);
        if (!$keyfiles || json_last_error() !== JSON_ERROR_NONE) {
            $output->writeln('<error>You must specify `GOOGLE_CLOUD_PHP_KEYFILES` as a base64-encoded json array of keyfile names.</error>');
            return;
        }

        foreach ($decoded as $kf) {
            $err = false;

            $data = base64_decode(getenv($kf . '_ENCODED'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $output->writeln('<error>Required environment variable `' . $kf . '_ENCODED` not set or invalid!</error>');
                return;
            } else {
                $output->writeln('Found valid json at environment variable `' . $kf .'`');
            }

            $dir = $base . '/keys/';
            $path = $dir . $kf .'.json';

            if (!file_exists($dir)) {
                mkdir($dir);
            }

            if (file_put_contents($path, $data) !== false) {
                $output->writeln('Wrote keyfile contents to file `' . realpath($path) . '`');
            } else {
                $output->writeln('<error>Could not write to file</error>');
                return;
            }
        }

        $output->writeln('<info>Credentials configured!</info>');
    }
}
