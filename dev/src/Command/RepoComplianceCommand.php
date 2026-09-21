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
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'If specified, display repo info for this component only'
            )
            ->addOption('token', 't', InputOption::VALUE_REQUIRED, 'Github token to use for authentication')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'can be "ci" or "table"', 'table')
            ->addOption('packagist-token', 'p', InputOption::VALUE_REQUIRED, 'Packagist token for the webhook')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Create github client wrapper
        $http = new Client();
        $this->github = new GitHub(new RunShell(), $http, (string) $input->getOption('token'), $output);
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

        $components = $input->getOption('component')
            ? array_map(fn ($c) => new Component($c), $input->getOption('component'))
            : Component::getComponents();

        $emoji = fn ($check) => match ($check) { 'skipped' => '⚪', false => '❌', true => '✅', null => '❓'};
        $failed = [];
        foreach ($components as $i => $component) {
            $isNewComponent = $component->getPackageVersion() === '0.0.0'
                || ($component->getPackageVersion() === '0.1.0' && $format == 'ci');

            do {
                $refreshDetails = false;
                if (!$details = $this->getRepoDetails($component)) {
                    $repoCheck = $packagistCheck = $webhookCheck = $teamsCheck = false;
                    $details = array_fill(0, count($headers) - 1, '**REPO NOT FOUND**');
                    $details[0] = str_replace('googleapis/', '', $component->getRepoName());
                    continue;
                }
                $repoCheck = $packagistCheck = $webhookCheck = $teamsCheck = true;
                if (!$this->checkSettingsCompliance($component, $details)) {
                    $repoCheck = false;
                    $refreshDetails |= $this->askFixSettingsCompliance($input, $output, $component, $details);
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
                    $teamsCheck = $this->github->token ? false : null;
                    $refreshDetails |= $this->askFixTeamCompliance($input, $output, $component->getRepoName());
                }
            } while ($refreshDetails);

            $details['compliant'] = implode("\n", [
                sprintf('%s [repo] Issues, Projects, Wiki, Pages, Discussions and Pull Requests are ' .
                    'configured correctly', $emoji($repoCheck)),
                sprintf('%s [webhook] Packagist webhook is configured', $emoji($webhookCheck)),
                sprintf('%s [packagist] Packagist maintainer is "google-cloud"', $emoji($packagistCheck)),
                sprintf('%s [teams] Github teams permissions are configured correctly', $emoji($teamsCheck)),
                '',
            ]);
            if ($format == 'ci') {
                unset($details['repo_config'], $details['packagist_config'], $details['teams']);
            }
            $componentTable = (clone $table);
            $componentTable->addRow($details)->render();

            if (!($repoCheck && $webhookCheck && $packagistCheck && $teamsCheck)) {
                $failed[] = $componentTable;
            }
        }

        if (count($failed) > 0) {
            $output->writeln('<error>ERROR: ' . count($failed) . ' components failed the repo compliance check:');
            foreach ($failed as $table) {
                $table->render();
            }
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * The GitHub settings each split repository is expected to have.
     *
     * Migrated repositories have issues and pull requests which our commit
     * history links to, and disabling either would hide them, so both tabs stay
     * visible. New issues are turned away by the issue template config, and new
     * pull requests by the "collaborators only" creation policy.
     */
    private function getExpectedSettings(Component $component): array
    {
        $isMigrated = $component->isMigratedRepo();

        return [
            'has_issues' => $isMigrated,
            'has_projects' => false,
            'has_wiki' => false,
            'has_pages' => false,
            'has_discussions' => false,
            'has_pull_requests' => $isMigrated,
        ] + ($isMigrated ? ['pull_request_creation_policy' => 'collaborators_only'] : []);
    }

    private function formatSettings(array $settings): string
    {
        return implode("\n", array_map(
            fn ($v, $k) => sprintf('%s: %s', str_replace('has_', '', $k), var_export($v, true)),
            $settings,
            array_keys($settings),
        ));
    }

    private function checkSettingsCompliance(Component $component, array $details)
    {
        return $details['repo_config'] === $this->formatSettings($this->getExpectedSettings($component));
    }

    private function checkTeamCompliance(array $details)
    {
        return !empty(array_filter(
            explode("\n", $details['teams']),
            fn ($team) => $team === (self::PHP_TEAM . ': admin')
        ));
    }

    private function askFixSettingsCompliance(
        InputInterface $input,
        OutputInterface $output,
        Component $component,
        array $details
    ) {
        if (!$this->github->token || $input->getOption('format') == 'ci') {
            // without a token, or in CI mode, don't ask to fix compliance
            return false;
        }
        $expected = $this->getExpectedSettings($component);
        $question = new ConfirmationQuestion(sprintf(
            "Repo %s has the following configuration:\n%s\n\nExpected:\n%s\n\nWould you like to update it? (Y/n)",
            $details['name'],
            $details['repo_config'],
            $this->formatSettings($expected)
        ), true);
        if ($this->getHelper('question')->ask($input, $output, $question)) {
            $this->github->updateRepoDetails('googleapis/' . $details['name'], $expected);
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

        // only display the settings we have an expectation for, in a stable order.
        $actual = [];
        foreach (array_keys($this->getExpectedSettings($component)) as $key) {
            $actual[$key] = $repoDetails[$key] ?? null;
        }

        return [
            'name' => $repoDetails['name'],
            'repo_config' => $this->formatSettings($actual),
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
