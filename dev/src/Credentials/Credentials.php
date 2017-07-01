<?php
/**
 * Copyright 2017 Google Inc.
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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Credentials extends Command
{
    private $keyfiles = [
        'GOOGLE_CLOUD_PHP_TESTS',
        'GOOGLE_CLOUD_PHP_TESTS_WHITELIST'
    ];

    private $cliBasePath;

    public function __construct($cliBasePath)
    {
        $this->cliBasePath = $cliBasePath;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('credentials')
            ->setDescription('Configure system test credentials');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $base = $this->cliBasePath .'/../';
        @mkdir($base . 'keys');

        foreach ($this->keyfiles as $kf) {
            $err = false;

            $data = base64_decode(getenv($kf . '_ENCODED'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $output->writeln("Required environment variable `" . $kf . "_ENCODED` not set or invalid!");
                exit(1);
            } else {
                $output->writeln("Found valid json at environment variable `" . $kf);
            }

            $path = $base . 'keys/' . $kf .'.json';
            if (file_put_contents($path, $data) !== false) {
                $output->writeln("Wrote keyfile contents to file `" . realpath($path) . "`");
            } else {
                $output->writeln("Could not write to file");
                exit(1);
            }
        }
    }
}
