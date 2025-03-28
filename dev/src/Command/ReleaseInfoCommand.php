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
use Google\Cloud\Dev\GitHub;
use Google\Cloud\Dev\ReleaseNotes;
use Google\Cloud\Dev\RunShell;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;

/**
 * List release details
 * @internal
 */
class ReleaseInfoCommand extends Command
{
    private Client $httpClient;

    private const REPO_ID = 'googleapis/google-cloud-php';

    /**
     * @param Client $httpClient specify the HTTP client, useful for testing
     */
    public function __construct(?Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Client();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('release-info')
            ->setDescription('list information for a google-cloud-php release')
            ->addArgument('tag', InputArgument::OPTIONAL, 'The git tag of the release (e.g. v0.200.0)')
            ->addOption('token', 't', InputOption::VALUE_REQUIRED, 'Github token to use for authentication', '')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'output format, can be "json", "shell", or "sql"', 'shell')
            ->addOption(
                'from',
                '',
                InputOption::VALUE_REQUIRED,
                'Date string representing how far back to get release data (e.g. "-6 months")'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $github = new Github(
            new RunShell(),
            $this->httpClient,
            $input->getOption('token'),
            $output
        );

        if ($from = $input->getOption('from')) {
            if ($input->getArgument('tag')) {
                throw new \InvalidArgumentException('cannot specify both a tag and a from date');
            }
            $releases = [];
            $tags = [];
            foreach ($github->getReleases(self::REPO_ID, new \DateTime($from)) as $release) {
                $releases = array_merge($releases, $this->getReleaseDataFromTag($release['tag_name'], $github));
                $tags[] = $release['tag_name'];
            }
            $tag = implode(', ', $tags);
        } else {
            if (!$tag = $input->getArgument('tag')) {
                // if no tag is supplied, get the most recent tag
                $releases = $github->getReleases(self::REPO_ID);
                $tag = $releases[0]['tag_name'] ?? '';
            }
            $releases = $this->getReleaseDataFromTag($tag, $github);
        }

        switch ($input->getOption('format')) {
            case 'shell':
                (new Table($output))
                    ->setHeaders([
                        [
                            new TableCell($tag, [
                                'rowspan' => 1,
                                'colspan' => 3,
                                'style' => new TableCellStyle(['align' => 'center', 'cellFormat' => '<info>%s</info>'])
                            ])
                        ],
                        ['component', 'id', 'version']
                    ])
                    ->setRows($releases)
                    ->render();
                break;
            case 'json':
                $releases = ['version' => $tag, 'releases' => $releases];
                $output->writeln(json_encode($releases, JSON_PRETTY_PRINT));
                break;
            case 'sql':
                foreach ($releases as $release) {
                    $component = new Component($release['component']);
                    // Some components make calls to multiple services, so we can add a query line for each one.
                    foreach (array_filter($component->getApiShortnames()) as $shortname) {
                        // The following service names are used by more than one package, so we exclude them to be more accurate
                        if (in_array($shortname, [
                            'beyondcorp', // used by cloud-beyondcorp-[appconnections|appconnectors|appgateways|clientconnectorservices|clientgateways]
                            'analyticshub', // used by cloud-bigquery-analyticshub and cloud-bigquery-data-exchange
                            'datastore', // used by cloud-datastore and cloud-datastore-admin
                            'dialogflow', // used by cloud-dialogflow and cloud-dialogflow-cx
                            'containeranalysis', // used by cloud-container-analysis and grafeas
                            'policytroubleshooter', // used by cloud-policy-troubleshooter and cloud-policytroubleshooter-iam
                            'redis', // used by cloud-redis and cloud-redis-cluster
                            'merchantapi', // used by shopping-merchant-inventories and shopping-merchant-reports
                        ])) {
                            // corresponds to multiple packages, so skip
                            continue;
                        }

                        $lines["$shortname-$release[version]"] = sprintf(
                            '(service_name = "%s" and client_library_version = "%s")',
                            $shortname,
                            $release['version']
                        );
                    }
                }
                ksort($lines); // order by service name and version
                $output->writeln(implode("\nOR ", $lines));
                break;
            default:
                throw new \InvalidArgumentException('invalid format');
        }

        return 0;
    }

    private function getReleaseDataFromTag(string $tag, Github $github)
    {
        $changelog = $github->getChangelog(self::REPO_ID, $tag);
        if (false === $changelog) {
            throw new \InvalidArgumentException(sprintf('Tag "%s" not found', $tag));
        }
        if (null === $changelog) {
            throw new \RuntimeException('Unable to retrieve tag');
        }

        $releaseNotes = new ReleaseNotes($changelog);

        $releases = [];
        foreach (Component::getComponents() as $component) {
            if ($version = $releaseNotes->getVersion($component->getId())) {
                $releases[] = [
                    'component' => $component->getName(),
                    'id' => $component->getId(),
                    'version' => $version,
                ];
            }
        }

        return $releases;
    }
}
