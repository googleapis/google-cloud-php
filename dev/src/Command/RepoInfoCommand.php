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
use Symfony\Component\Console\Question\ConfirmationQuestion;
use GuzzleHttp\Client;

/**
 * List repo details
 * @internal
 */
class RepoInfoCommand extends Command
{
    private Client $http;
    private array $headers;

    private static $allFields = [
        'name' => 'Name',
        'has_issues' => 'Has Issues',
        'has_projects' => 'Has Projects',
        'has_wiki' => 'Has Wiki',
        'has_pages' => 'Has Pages',
        'has_discussions' => 'Has Discussions',
        'teams'   => 'Teams',
    ];
    protected function configure()
    {
        $this->setName('repo-info')
            ->setDescription('list info for all github repositories')
            ->addArgument('component', InputArgument::OPTIONAL, 'If specified, display repo info for this component only', '')
            ->addOption('token', 't', InputOption::VALUE_REQUIRED, 'Github token to use for authentication', '')
            ->addOption('page', 'p', InputOption::VALUE_REQUIRED, 'page to start from', '1')
            ->addOption('results-per-page', 'r', InputOption::VALUE_REQUIRED, 'results to display per page', '10')
            ->addOption('fix', 'f', InputOption::VALUE_NONE, 'whether to prompt to fix non-compliant repos')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->http = new Client();
        $this->headers = [
            'Accept' => 'application/vnd.github+json',
            'X-GitHub-Api-Version' => '2022-11-28',
        ];
        if ($token = $input->getOption('token')) {
            $this->headers['Authorization'] = 'Bearer ' . $token;
        }
        $nextPageQuestion = new ConfirmationQuestion('Next Page (enter)', true);
        $table = (new Table($output))->setHeaders(self::$allFields);
        if ($componentName = $input->getArgument('component')) {
            $table->setVertical();
        }
        $page = (int) $input->getOption('page');
        $resultsPerPage = (int) $input->getOption('results-per-page');
        $components = $componentName ? [new Component($componentName)] : Component::getComponents();
        foreach ($components as $i => $component) {
            if ($i < (($page-1) * $resultsPerPage)) {
                continue;
            }
            if ($i >= ($page * $resultsPerPage)) {
                $table->render();
                if (!$this->getHelper('question')->ask($input, $output, $nextPageQuestion)) {
                    return 0;
                }
                $table->setRows([]);
                $page++;
            }
            $details = $this->getRepoDetails($component);
            if ($input->getOption('fix')) {
                if (!$token) {
                    throw new \InvalidArgumentException('Token required to fix compliance');
                }
                $refreshDetails = false;
                if (!$this->checkSettingsCompliance($details)) {
                    $refreshDetails |= $this->askFixSettingsCompliance($input, $output, $details);
                }
                if (!$this->checkTeamCompliance($details)) {
                    $refreshDetails |= $this->askFixTeamCompliance($input, $output, $details);
                }
                if ($refreshDetails) {
                    $details = $this->getRepoDetails($component);
                }
            }
            $table->addRow($details);
        }
        $table->render();

        return 0;
    }

    private function checkSettingsCompliance(array $details)
    {
        return $details['has_issues'] === 'false'
            && $details['has_projects'] === 'false'
            && $details['has_wiki'] === 'false'
            && $details['has_pages'] === 'false'
            && $details['has_discussions'] === 'false';
    }

    private function checkTeamCompliance(array $details)
    {
        return !empty(array_filter(
            explode("\n", $details['teams']),
            fn ($team) => $team === 'yoshi-php: admin'
        ));
    }

    private function askFixSettingsCompliance(InputInterface $input, OutputInterface $output, array $details)
    {
        $fieldsToUpdate = array_keys(array_filter($details, fn ($value) => $value === 'true'));
        $question = new ConfirmationQuestion(sprintf(
            'Repo %s has the following configuration enabled: %s. Would you like to disable them? (Y/n)',
            $details['name'],
            implode(', ', $fieldsToUpdate)
        ), true);
        if ($this->getHelper('question')->ask($input, $output, $question)) {
            $url = 'https://api.github.com/repos/googleapis/' . $details['name'];
            $response = $this->http->patch($url, [
                'headers' => $this->headers,
                'body' => json_encode(array_fill_keys($fieldsToUpdate, false)),
            ]);
            return true;
        }
        return false;
    }

    private function askFixTeamCompliance(InputInterface $input, OutputInterface $output, array $details)
    {
        $question = new ConfirmationQuestion(sprintf(
            'Repo %s does not have "yoshi-php" as an admin. Would you like to add it? (Y/n)',
            $details['name']
        ), true);
        if ($this->getHelper('question')->ask($input, $output, $question)) {
            $url = 'https://api.github.com/orgs/googleapis/teams/yoshi-php/repos/googleapis/' . $details['name'];
            $response = $this->http->put($url, [
                'headers' => $this->headers,
                'body' => '{"permission":"admin"}',
            ]);
            return true;
        }
        return false;
    }

    private function getRepoDetails(Component $component): array
    {
        // get configuration fields
        $response = $this->http->get('https://api.github.com/repos/' . $component->getRepoName(), [
            'headers' => $this->headers
        ]);
        // use "array_intersect_key" to filter out fields that were not requested.
        $fields = array_map(
            fn ($field) => is_bool($field) ? var_export($field, true) : $field,
            array_intersect_key(
                json_decode((string) $response->getBody(), true),
                self::$allFields
            )
        );

        $fields['teams'] = $this->getRepoTeamDetails($component);

        return $fields;
    }

    private function getRepoTeamDetails(Component $component)
    {
        if (!isset($this->headers['Authorization'])) {
            return '**Token Required**';
        }
        // get team fields
        $response = $this->http->get(
            'https://api.github.com/repos/' . $component->getRepoName() . '/teams', [
            'headers' => $this->headers,
            'http_errors' => false,
        ]);
        if ($response->getStatusCode() === 200) {
            return implode("\n", array_map(
                fn ($team) => $team['name'] . ': ' . $team['permission'],
                json_decode((string) $response->getBody(), true)
            )) . "\n";
        }

        return '**ACCESS DENIED**';
    }
}
