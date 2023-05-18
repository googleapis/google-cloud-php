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
    private static $allFields = [
        'name' => 'Component Name',
        'package_name' => 'Package Name',
        'package_version' => 'Package Version',
        'api_versions' => 'API Version(s)',
        'release_level' => 'Release Level',
        'migration' => 'Migration',
        'php_namespaces' => 'Php Namespace(s)',
        'github_repo' => 'Github Repo',
        'proto' => 'Proto',
        'service_address' => 'Service Address',
        'description' => 'Description',
    ];
    protected function configure()
    {
        $this->setName('component-info')
            ->setDescription('list info of a component or the whole library')
            ->addArgument('name', InputArgument::OPTIONAL, 'If specified, display info for this component only', '')
            ->addOption('csv', '', InputOption::VALUE_REQUIRED, 'export findings to csv.')
            ->addOption('fields', 'f', InputOption::VALUE_REQUIRED, sprintf(
                "Comma-separated list of fields. The following fields are available: \n - %s\n",
                implode("\n - ", array_keys(self::$allFields))
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fields = $input->getOption('fields')
            ? explode(',', $input->getOption('fields'))
            : array_keys(self::$allFields);
        // Filter out invalid fields
        $requestedFields = array_intersect_key(array_flip($fields), self::$allFields);
        $components = [];
        if ($componentName = rtrim($input->getArgument('name'), '/')) {
            $components[] = $this->getComponentDetails(new Component($componentName), $requestedFields);
        } else {
            foreach (Component::getComponents() as $component) {
                $components[] = $this->getComponentDetails($component, $requestedFields);
            }
        }

        // use "array_intersect_key" to filter out fields that were not requested.
        // use "array_replace" to sort the fields in the order they were requested.
        $headers = array_values(array_replace(
            $requestedFields,
            array_intersect_key(self::$allFields, $requestedFields)
        ));

        if ($csv = $input->getOption('csv')) {
            $fp = fopen($csv, 'wa+');
            fputcsv($fp, $headers);
            foreach ($components as $component) {
                fputcsv($fp, $component);
            }
            fclose($fp);
            $output->writeln('Output written to ' . $csv);
        } else {
            $table = new Table($output);
            $table
                ->setHeaders($headers)
                ->setRows($components)
            ;
            if ($componentName) {
                $table->setVertical();
            }
            $table->render();
        }

        return 0;
    }

    private function getComponentDetails(Component $component, array $requestedFields): array
    {
        // use "array_intersect_key" to filter out fields that were not requested.
        // use "array_replace" to sort the fields in the order they were requested.
        return array_replace($requestedFields, array_intersect_key([
            'name' => $component->getName(),
            'package_name' => $component->getPackageName(),
            'package_version' => $component->getLocalVersion(),
            'api_versions' => implode(', ', $component->getVersions()),
            'release_level' => $component->getReleaseLevel(),
            'migration' => $component->getMigrationStatus(),
            'php_namespaces' => implode(', ', $component->getNamespaces()),
            'github_repo' => $component->getRepoName(),
            'proto' => $component->getProtoPackage(),
            'service_address' => implode(', ', $component->getServiceAddresses()),
            'description' => $component->getDescription(),
        ], $requestedFields));
    }
}