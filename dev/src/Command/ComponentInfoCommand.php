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
use GuzzleHttp\Client;

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
        'api_versions' => 'API Version',
        'release_level' => 'Release Level',
        'migration' => 'Migration',
        'php_namespaces' => 'Php Namespace',
        'github_repo' => 'Github Repo',
        'proto' => 'Proto Path',
        'service_address' => 'Service Address',
        'shortname' => 'API Shortname',
        'description' => 'Description',
        'available_api_versions' => 'Availble API Versions',
    ];
    private static $defaultFields = [
        'name',
        'package_name',
        'package_version',
        'api_versions',
        'release_level',
        'migration',
        'proto',
        'shortname',
    ];

    private string $token;

    protected function configure()
    {
        $this->setName('component-info')
            ->setDescription('list info of a component or the whole library')
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED, 'get info for a single component', '')
            ->addOption('csv', '', InputOption::VALUE_REQUIRED, 'export findings to csv.')
            ->addOption('fields', 'f', InputOption::VALUE_REQUIRED, sprintf(
                "Comma-separated list of fields. The following fields are available: \n - %s\n" .
                "NOTE: \"available_api_versions\" are omited by default because they take a long time to load.\n" .
                "Use --show-available-api-versions to include them.\n",
                implode("\n - ", array_keys(self::$allFields))
            ))
            ->addOption('token', 't', InputOption::VALUE_REQUIRED, 'Github token to use for authentication', '')
            ->addOption(
                'show-available-api-versions',
                '',
                InputOption::VALUE_NONE,
                'Show available API versions for each component. Requires an API call'
            )
            ->addOption('expanded', '', InputOption::VALUE_NONE, 'Break down each component by packages')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fields = $input->getOption('fields')
            ? explode(',', $input->getOption('fields'))
            : self::$defaultFields;
        if ($input->getOption('show-available-api-versions')) {
            $fields[] = 'available_api_versions';
        }
        $this->token = $input->getOption('token');

        // Filter out invalid fields
        $requestedFields = array_intersect_key(array_flip($fields), self::$allFields);

        // Compile all the component data into rows
        $componentName = $input->getOption('component');
        $components = $componentName ? [new Component($componentName)] : Component::getComponents();

        $rows = [];
        foreach ($components as $component) {
            $rows = array_merge($rows, $this->getComponentDetails(
                $component,
                $requestedFields,
                $input->getOption('expanded')
            ));
        }

        // output the component data
        $headers = array_values(array_replace(
            $requestedFields,
            array_intersect_key(self::$allFields, $requestedFields)
        ));

        if ($csv = $input->getOption('csv')) {
            $fp = fopen($csv, 'wa+');
            fputcsv($fp, $headers);
            foreach ($rows as $row) {
                fputcsv($fp, $row);
            }
            fclose($fp);
            $output->writeln('Output written to ' . $csv);
        } else {
            $table = new Table($output);
            $table
                ->setHeaders($headers)
                ->setRows($rows)
            ;
            if (count($rows) == 1) {
                $table->setVertical();
            }
            $table->render();
        }

        return 0;
    }

    private function getComponentDetails(Component $component, array $requestedFields, bool $expanded): array
    {
        $rows = [];
        if ($expanded) {
            foreach ($component->getComponentPackages() as $pkg) {
                $availableApiVersions = '';
                if (array_key_exists('available_api_versions', $requestedFields)) {
                    $availableApiVersions = $this->getAvailableApiVersions($component);
                }
                // use "array_intersect_key" to filter out fields that were not requested.
                // use "array_replace" to sort the fields in the order they were requested.
                $rows[] = array_replace($requestedFields, array_intersect_key([
                    'name' => $component->getName() . "\\" . $pkg->getName(),
                    'package_name' => $component->getPackageName(),
                    'package_version' => $component->getPackageVersion(),
                    'api_versions' => $pkg->getName(),
                    'release_level' => $component->getReleaseLevel(),
                    'migration' => $pkg->getMigrationStatus(),
                    'php_namespaces' => implode("\n", array_keys($component->getNamespaces())),
                    'github_repo' => $component->getRepoName(),
                    'proto' => $pkg->getProtoPackage(),
                    'service_address' => $pkg->getServiceAddress(),
                    'shortname' => $pkg->getApiShortname(),
                    'description' => $component->getDescription(),
                    'available_api_versions' => $availableApiVersions,
                ], $requestedFields));
            }
        } else {
            // use "array_intersect_key" to filter out fields that were not requested.
            // use "array_replace" to sort the fields in the order they were requested.
            $details = array_replace($requestedFields, array_intersect_key([
                'name' => $component->getName(),
                'package_name' => $component->getPackageName(),
                'package_version' => $component->getPackageVersion(),
                'api_versions' => implode("\n", $component->getApiVersions()),
                'release_level' => $component->getReleaseLevel(),
                'migration' => implode("\n", $component->getMigrationStatuses()),
                'php_namespaces' => implode("\n", array_keys($component->getNamespaces())),
                'github_repo' => $component->getRepoName(),
                'proto' => implode("\n", $component->getProtoPackages()),
                'service_address' => implode("\n", $component->getServiceAddresses()),
                'shortname' => implode("\n", $component->getApiShortnames()),
                'description' => $component->getDescription(),
            ], $requestedFields));

            if (array_key_exists('available_api_versions', $requestedFields)) {
                $details['available_api_versions'] = $this->getAvailableApiVersions($component);
            }

            $rows[] = $details;
        }

        return $rows;
    }

    private function getAvailableApiVersions(Component $component): string
    {
        $protos = $component->getProtoPackages();
        $proto = array_shift($protos);
        // Proto packages should be in a version directory
        $versionPath = dirname($proto);
        $versionsUrl = 'https://api.github.com/repos/googleapis/googleapis/contents/' . $versionPath;
        $client = new Client();
        $response = $client->get($versionsUrl, [
            'headers' => [
                'Accept' => 'application/vnd.github+json',
                'X-GitHub-Api-Version' => '2022-11-28',
                'Authorization' => $this->token ? 'Bearer ' . $this->token : ''
            ],
        ]);
        $versions = array_map('lcfirst', $component->getApiVersions());

        return implode(', ', array_map(
            fn ($file) => ucfirst($file['name']),
            array_filter(
                json_decode((string) $response->getBody(), true),
                fn ($file) => $file['type'] === 'dir' && $file['name'][0] === 'v' && !in_array($file['name'], $versions)
            )
        ));
    }
}