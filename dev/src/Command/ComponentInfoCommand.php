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

use Google\Cloud\Dev\NewComponent;
use Google\Cloud\Dev\Component;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * List component details
 * @internal
 */
class ComponentInfoCommand extends Command
{
    protected function configure()
    {
        $this->setName('component-info')
            ->setDescription('list info of a component or the whole library')
            ->addArgument('name', InputArgument::OPTIONAL, 'Component to check compliance for.', '')
            ->addOption('csv', '', InputOption::VALUE_REQUIRED, 'export findings to csv.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $components = [];
        if ($componentName = rtrim($input->getArgument('name'), '/')) {
            $components[] = $this->getComponentDetails(new Component($componentName), true);
        } else {
            foreach (Component::getComponents() as $component) {
                $components[] = $this->getComponentDetails($component, $input->getOption('verbose'));
            }
        }

        if ($csv = $input->getOption('csv')) {
            $fp = fopen($csv, 'wa+');
            foreach ($components as $component) {
                fputcsv($fp, $component);
            }
            fclose($fp);
            $output->writeln('Output written to ' . $csv);
        } else {
            $table = new Table($output);
            $table
                ->setHeaders(array_keys($components[0]))
                ->setRows($components)
            ;
            if ($componentName) {
                $table->setVertical();
            }
            $table->render();
        }

        return 0;
    }

    private function getComponentDetails(Component $component, bool $verbose): array
    {
        $info = [
            'Component Name' => $component->getName(),
            'Package Name' => $component->getPackageName(),
            'Package Version' => $component->getLocalVersion(),
        ];

        if ($verbose) {
            $info['Release Level'] = $component->getReleaseLevel();
            $info['Php Namespace(s)'] = implode("\n", $component->getNamespaces());
            $info['Github Repo'] = $component->getRepoName();
            $info['Protobuf Package'] = $component->getProtoPackage();
            $info['Service Address'] = $component->getServiceAddress();
            $info['Description'] = $component->getDescription();
        }
        return $info;
    }
}