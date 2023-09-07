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
    public function __construct(Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Client();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('release-info')
            ->setDescription('list information for a google-cloud-php release')
            ->addArgument('tag', InputArgument::REQUIRED, 'The git tag of the release (e.g. v0.200.0)')
            ->addOption('token', 't', InputOption::VALUE_REQUIRED, 'Github token to use for authentication', '')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'output format, can be "json" or "shell"', 'shell')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $github = new Github(
            new RunShell(),
            $this->httpClient,
            $input->getOption('token')
        );

        $changelog = $github->getChangelog(
            self::REPO_ID,
            $tag = $input->getArgument('tag')
        );

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

        switch ($input->getOption('format')) {
            case 'shell':
                (new Table($output))
                    ->setHeaders(['component', 'id', 'version'])
                    ->setRows($releases)
                    ->render();
                break;
            case 'json':
                $releases = ['version' => $tag, 'releases' => $releases];
                $output->writeln(json_encode($releases, JSON_PRETTY_PRINT));
                break;
            default:
                throw new \InvalidArgumentException('invalid format');
        }

        return 0;
    }
}
