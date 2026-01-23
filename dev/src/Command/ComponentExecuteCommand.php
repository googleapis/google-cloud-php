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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $code = $input->getArgument('code');
        $components = Component::getComponents();

        $codeToExecute = file_exists($code) ? file_get_contents($code) : $code;
        if (0 === strpos($codeToExecute, '<?php')) {
            $codeToExecute = substr($codeToExecute, 5);
        }
        $output->writeln('<info>' . $codeToExecute . '</>');
        foreach ($components as $component) {
            $output->writeln('Executing for ' . $component->getName());
            eval($codeToExecute);
        }

        return 0;
    }
}
