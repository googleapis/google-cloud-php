<?php
/**
 * Copyright 2026 Google Inc.
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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Google\Cloud\Dev\Component;
use Google\Cloud\Dev\GitHub;
use Google\Cloud\Dev\Packagist;
use Google\Cloud\Dev\RunShell;
use GuzzleHttp\Client;
use Symfony\Component\Console\Input\InputOption;

/**
 * Execute commands for every Component
 *
 * ```bash
 * // execute PHP code directly (don't forget to escape `$` for bash
 * ./dev/google-cloud component:execute "copy('SECURITY.md', \$component->getPath() . '/SECURITY.md');"
 * // execute a PHP file (don't forget to escape `$` for bash
 * ./dev/google-cloud component:execute copy_file.php
 * ```
 *
 * @internal
 */
class ComponentExecuteCommand extends Command
{
    private const PACKAGIST_USERNAME = 'google-cloud';

    protected function configure()
    {
        $this->setName('component:execute')
            ->setDescription('Execute a command for each component')
            ->setHelp(<<<EOF
Execute PHP code directly (don't forget to escape `$` for bash):

    ./dev/google-cloud component:execute "copy('SECURITY.md', \\\$component->getPath() . '/SECURITY.md');"

Execute a PHP file:

    ./dev/google-cloud component:execute copy_file.php

EOF)
            ->addArgument('code', InputArgument::REQUIRED, 'Path to a file or PHP code to execute')
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED, 'If specified, display repo info for this component only', '')
            ->addOption('token', 't', InputOption::VALUE_REQUIRED, 'Github token to use for authentication', '')
            ->addOption('packagist-token', 'p', InputOption::VALUE_REQUIRED, 'Packagist token for the webhook')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Create github client wrapper
        $http = new Client();
        $github = new GitHub(new RunShell(), $http, $input->getOption('token'), $output);
        $packagist = new Packagist($http, self::PACKAGIST_USERNAME, $input->getOption('packagist-token') ?? '');

        $componentName = $input->getOption('component');
        $components = $componentName ? [new Component($componentName)] : Component::getComponents();

        $code = $input->getArgument('code');
        if (file_exists($code)) {
            $executeFn = require $code;
        } else {
            if (0 === strpos($code, '<?php')) {
                $code = substr($code, 5);
            }
            $executeFn = function ($component, $github, $packagist, $output) use ($code) {
                eval($code);
            };
        }

        foreach ($components as $component) {
            $output->writeln('Executing for ' . $component->getName());
            $executeFn($component, $github, $packagist, $output);
        }

        return 0;
    }
}
