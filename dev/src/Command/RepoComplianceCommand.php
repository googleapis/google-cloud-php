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
use Google\Cloud\Dev\Packagist;
use Google\Cloud\Dev\RunShell;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use GuzzleHttp\Client;
use InvalidArgumentException;

/**
 * List repo details
 * @internal
 */
class RepoComplianceCommand extends Command
{
    private const PACKAGIST_USERNAME = 'google-cloud';
    public const PHP_TEAM = 'cloud-sdk-php-team';
    private GitHub $github;
    private Packagist $packagist;

    protected function configure()
    {
        $this->setName('repo:compliance')
            ->setDescription('ensure all github repositories meet compliance')
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED, 'If specified, display repo info for this component only', '')
            ->addOption('token', 't', InputOption::VALUE_REQUIRED, 'Github token to use for authentication', '')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'can be "ci" or "table"', 'table')
            ->addOption('packagist-token', 'p', InputOption::VALUE_REQUIRED, 'Packagist token for the webhook')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Create github client wrapper
        $http = new Client();
        $this->github = new GitHub(new RunShell(), $http, $input->getOption('token'), $output);
        $this->packagist = new Packagist($http, self::PACKAGIST_USERNAME, $input->getOption('packagist-token') ?? '');

        $format = $input->getOption('format');
        if (!in_array($format, ['ci', 'table'])) {
            throw new InvalidArgumentException('Invalid format "' . $format . '", must be "table" or "ci"');
        }

        $table = (new Table($output));
        $table->setColumnWidths([55, 20, 22, 33, 50]);
        $table->setStyle('compact');
        $headers = $format == 'ci' ? ['Name', 'Compliance'] : [
            'Name',
            'Repo Config',
            'Packagist Config',
            'Teams',
            'Compliance'
        ];
        (clone $table)->setHeaders($headers)->render();

        $componentName = $input->getOption('component');
        $components = $componentName ? [new Component($componentName)] : Component::getComponents();

        $isCompliant = true;
        $emoji = fn ($check) => match ($check) { 'skipped' => '⚪', false => '❌', true => '✅', null => '❓'};
        foreach ($components as $i => $component) {
            $isNewComponent = $component->getPackageVersion() === '0.0.0'
                || $component->getPackageVersion() === '0.1.0' && $format == 'ci';

            do {
                $refreshDetails = false;
                if (!$details = $this->getRepoDetails($component) ){
                    $isCompliant = $settingsCheck = $packagistCheck = $webhookCheck = $teamCheck = false;
                    $details = array_fill(0, count($headers) - 1, '**REPO NOT FOUND**');
                    $details[0] = str_replace('googleapis/', '', $component->getRepoName());
                    continue;
                }
                $settingsCheck = $packagistCheck = $webhookCheck = $teamCheck = true;
                if (!$this->checkSettingsCompliance($details)) {
                    $settingsCheck = false;
                    $refreshDetails |= $this->askFixSettingsCompliance($input, $output, $details);
                }
                if (!$this->checkWebhookCompliance($details)) {
                    $webhookCheck = $this->github->token ? ($isNewComponent ? 'skipped' : false) : null;
                    $refreshDetails |= $this->askFixWebhookCompliance($input, $output, $details);
                }
                if (!$this->checkPackagistCompliance($details)) {
                    // New components don't have packagist config, so bypass for CI.
                    $packagistCheck = $isNewComponent ? 'skipped' : false;
                    $refreshDetails |= $this->askFixPackagistCompliance($input, $output, $details);
                    $details['packagist_config'] ??= '**PACKAGE NOT FOUND**';
                }
                if (!$this->checkTeamCompliance($details)) {
                    $teamCheck = $this->github->token ? false : null;
                    $refreshDetails |= $this->askFixTeamCompliance($input, $output, $component->getRepoName());
                }
            } while ($refreshDetails);

            $details['compliant'] = implode("\n", [
                sprintf('%s Issues, Projects, Wiki, Pages, and Discussion are disabled', $emoji($settingsCheck)),
                sprintf('%s Packagist webhook is configured', $emoji($webhookCheck)),
                sprintf('%s Packagist maintainer is "google-cloud"', $emoji($packagistCheck)),
                sprintf('%s Github teams permissions are configured correctly', $emoji($teamCheck)),
                '',
            ]);
            $isCompliant &= $settingsCheck && $webhookCheck && $packagistCheck && $teamCheck;
            if ($format == 'ci') {
                unset($details['repo_config'], $details['packagist_config'], $details['teams']);
            }
            (clone $table)->addRow($details)->render();
        }

        return $isCompliant ? Command::SUCCESS : Command::FAILURE;
    }

    private function checkSettingsCompliance(array $details)
    {
        return $details['repo_config'] === "issues: false
projects: false
wiki: false
pages: false
discussions: false";
    }

    private function checkTeamCompliance(array $details)
    {
        return !empty(array_filter(
            explode("\n", $details['teams']),
            fn ($team) => $team === (self::PHP_TEAM . ': admin')
        ));
    }

    private function askFixSettingsCompliance(InputInterface $input, OutputInterface $output, array $details)
    {
        if (!$this->github->token || $input->getOption('format') == 'ci') {
            // without a token, or in CI mode, don't ask to fix compliance
            return false;
        }
        $explodedConfig = array_map(fn ($line) => explode(': ', $line), explode("\n", $details['repo_config']));
        $fields = array_combine(array_column($explodedConfig, 0), array_column($explodedConfig, 1));
        $fieldsToUpdate = array_keys(array_filter($fields, fn ($value) => $value === 'true'));
        $question = new ConfirmationQuestion(sprintf(
            'Repo %s has the following configuration enabled: %s. Would you like to disable them? (Y/n)',
            $details['name'],
            implode(', ', $fieldsToUpdate)
        ), true);
        if ($this->getHelper('question')->ask($input, $output, $question)) {
            $this->github->updateRepoDetails(
                'googleapis/' . $details['name'],
                array_fill_keys(array_map(
                    fn ($key) => 'has_' . $key,
                    array_keys($fields)
                ), false)
            );
            return true;
        }
        return false;
    }

    private function checkWebhookCompliance(array $details): bool
    {
        if (!$this->github->token) {
            return false;
        }

        $repoName = 'googleapis/' . $details['name'];
        $webhookUrl = $this->packagist->getWebhookUrl();

        return null !== $this->github->getWebhook($repoName, $webhookUrl);
    }

    private function askFixWebhookCompliance(InputInterface $input, OutputInterface $output, array $details)
    {
        if (!$this->github->token || $input->getOption('format') == 'ci') {
            // without a token, or in CI mode, don't ask to fix compliance
            return false;
        }

        $question = new ConfirmationQuestion(sprintf(
            'Repo %s does not have the packagist webhook configured. Would you like to configure it? (Y/n)',
            $details['name'],
        ), true);
        if ($this->getHelper('question')->ask($input, $output, $question)) {
            if (!$packagistToken = $this->packagist->getApiToken()) {
                throw new \Exception('Packagist token required to update webhook compliance');
            }

            $repoName = 'googleapis/' . $details['name'];
            $webhookUrl = $this->packagist->getWebhookUrl();
            if (!$this->github->addWebhook($repoName, $webhookUrl, $packagistToken)) {
                $output->writeln(sprintf('<error>%s</error>: Unable to create Packagist webhook.', $repoName));

                return false;
            }
            $output->writeln(sprintf('<comment>%s</comment>: Packagist webhook created.', $repoName));
            return true;
        }

        return false;
    }

    private function checkPackagistCompliance(array $details)
    {
        return !empty(array_filter(
            explode("\n", (string) $details['packagist_config']),
            fn ($team) => $team === self::PACKAGIST_USERNAME
        ));
    }

    private function askFixPackagistCompliance(InputInterface $input, OutputInterface $output, array $details)
    {
        if (!$this->github->token || $input->getOption('format') == 'ci' || $details['packagist_config'] === null) {
            // cannot fix compliance without a token, or in CI mode, or without packagist config
            return false;
        }
        throw new \Exception('not implemented');
    }

    private function askFixTeamCompliance(InputInterface $input, OutputInterface $output, string $repoName)
    {
        if (!$this->github->token || $input->getOption('format') == 'ci') {
            // without a token, or in CI mode, don't ask to fix compliance
            return false;
        }
        $question = new ConfirmationQuestion(sprintf(
            'Repo %s does not have "%s" as an admin. Would you like to add it? (Y/n)',
            $repoName,
            self::PHP_TEAM,
        ), true);
        if ($this->getHelper('question')->ask($input, $output, $question)) {
            return $this->github->updateTeamPermission('googleapis', self::PHP_TEAM, $repoName, 'admin');
        }
        return false;
    }

    private function getRepoDetails(Component $component): array|null
    {
        if (!$repoDetails = $this->github->getRepoDetails($component->getRepoName())) {
            return null;
        }

        if (null !== $packagistDetails = $this->packagist->getMaintainers($component->getPackageName())) {
            $packagistDetails = implode("\n", $packagistDetails);
        }

        // use "array_intersect_key" to filter out fields that were not requested.
        $fields = array_map(
            fn ($field) => var_export($field, true),
            array_intersect_key(
                $repoDetails,
                array_flip(['has_issues', 'has_projects', 'has_wiki', 'has_pages', 'has_discussions'])
            )
        );

        return [
            'name' => $repoDetails['name'],
            'repo_config' => implode("\n", array_map(
                fn ($v, $k) => sprintf('%s: %s', str_replace('has_', '', $k), $v),
                $fields,
                array_keys($fields),
            )),
            'packagist_config' => $packagistDetails,
            'teams' => $this->getRepoTeamDetails($component),
        ];
    }

    private function getRepoTeamDetails(Component $component)
    {
        if (!$this->github->token) {
            return '**Token Required**';
        }
        // get team fields
        $teams = $this->github->getTeams($component->getRepoName());
        if (is_null($teams)) {
            return '**ACCESS DENIED**';
        }
        return implode("\n", array_map(
            fn ($team) => $team['name'] . ': ' . $team['permission'],
            $teams
        )) . "\n";
    }
}
