<?php
/*
 * Copyright 2025 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Dev\Command;

use DateTime;
use Google\Cloud\Dev\Component;
use Google\Cloud\Dev\GitHub;
use Google\Cloud\Dev\Packagist;
use Google\Cloud\Dev\ReleaseNotes;
use Google\Cloud\Dev\RunShell;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReleaseVerifyCommand extends Command
{
    private const REPO_ID = 'googleapis/google-cloud-php';
    private const DOCS_URL = 'https://docs.cloud.google.com/php/docs/reference/%s/latest';
    private const DOCS_GRACE_PERIOD_DAYS = 7;
    private const VERIFY_MARKER_START = '<!-- RELEASE_VERIFY_START -->';
    private const VERIFY_MARKER_END = '<!-- RELEASE_VERIFY_END -->';
    private const FAILED_CHECK_CONCLUSIONS = ['failure', 'timed_out', 'cancelled', 'action_required'];

    private Client $httpClient;

    /**
     * @param ?Client $httpClient specify the HTTP client, useful for testing
     */
    public function __construct(?Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Client();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('release:verify')
            ->setDescription('Verifies that component releases exist on split repositories, Packagist, and Cloud RAD reference documentation.')
            ->addArgument('tag', InputArgument::OPTIONAL, 'The git tag of the release (e.g. v0.349.0)')
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED,
                'Get info for a single component'
            )
            ->addOption(
                'package-version',
                '',
                InputOption::VALUE_REQUIRED,
                'The version to check for'
            )
            ->addOption(
                'token',
                't',
                InputOption::VALUE_REQUIRED,
                'GitHub token to use for authentication',
                ''
            )
            ->addOption(
                'update-release',
                '',
                InputOption::VALUE_NONE,
                'Update the GitHub release body with the verification status table'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $updateRelease = (bool) $input->getOption('update-release');
        $tag = $input->getArgument('tag');

        $token = $input->getOption('token') ?: (getenv('GH_OAUTH_TOKEN') ?: (getenv('GITHUB_TOKEN') ?: ''));
        $github = new GitHub(new RunShell(), $this->httpClient, $token, $output);
        $packagist = new Packagist($this->httpClient, '', '', null, $output);

        $componentOption = $input->getOption('component');
        $overrideVersion = $input->getOption('package-version');

        [$releaseBody, $publishedAt, $items] = $this->resolveTarget(
            $github,
            $tag,
            $componentOption,
            $overrideVersion
        );

        $headers = ['Component', 'Version', 'Split Repo', 'Packagist', 'Docs'];

        $ageInSeconds = $publishedAt ? (time() - $publishedAt->getTimestamp()) : null;
        $ageInDays = $ageInSeconds !== null ? max(0, (int) floor($ageInSeconds / 86400)) : null;
        $isDocsWithinGracePeriod = $ageInSeconds !== null
            && $ageInSeconds < (self::DOCS_GRACE_PERIOD_DAYS * 86400);

        $notFound = [];
        $pending = [];
        $checkRuns = [];

        if ($tag !== null && !$componentOption) {
            $checkRuns = $github->getCheckRuns(self::REPO_ID, $tag) ?? [];
            usort($checkRuns, fn (array $a, array $b) => strcmp($a['name'] ?? '', $b['name'] ?? ''));

            foreach ($checkRuns as $run) {
                $runName = $run['name'] ?? 'Unknown';
                $runUrl = $run['html_url'] ?? '';
                if (($run['status'] ?? '') !== 'completed') {
                    $pending[] = sprintf('%s: %s (Check Run)', $tag, $runName);
                } elseif (in_array($run['conclusion'] ?? '', self::FAILED_CHECK_CONCLUSIONS, true)) {
                    $notFound[] = $runUrl
                        ? sprintf('- [%s (Check Run)](%s)', $runName, $runUrl)
                        : sprintf('- %s (Check Run)', $runName);
                }
            }
        }

        $rows = [];
        $mdRows = [];
        foreach ($items as $item) {
            /** @var Component $component */
            $component = $item['component'];
            $version = $item['version'];
            $tagVersion = 'v' . $version;
            $packageName = $component->getPackageName();

            $row = [$packageName, $version];
            $mdRow = ['`' . $packageName . '`', '`' . $version . '`'];

            $splitUrl = sprintf('https://github.com/%s/releases/tag/%s', $component->getRepoName(), $tagVersion);
            if ($github->doesTagExist($component->getRepoName(), $tagVersion)) {
                $row[] = '<info>OK</info>';
                $mdRow[] = sprintf('[OK](%s)', $splitUrl);
            } else {
                $row[] = '<error>NOT FOUND</error>';
                $mdRow[] = 'NOT FOUND';
                $notFound[] = sprintf('- [%s:%s (Split Repo)](%s)', $packageName, $tagVersion, $splitUrl);
            }

            $packagistUrl = sprintf('https://packagist.org/packages/%s#%s', $packageName, $tagVersion);
            if ($packagist->versionExists($packageName, $tagVersion)) {
                $row[] = '<info>OK</info>';
                $mdRow[] = sprintf('[OK](%s)', $packagistUrl);
            } else {
                $row[] = '<error>NOT FOUND</error>';
                $mdRow[] = 'NOT FOUND';
                $notFound[] = sprintf('- [%s:%s (Packagist)](%s)', $packageName, $tagVersion, $packagistUrl);
            }

            $docsUrl = sprintf(self::DOCS_URL, $component->getId());
            if ($this->docsVersionExists($component->getId(), $version)) {
                $row[] = '<info>OK</info>';
                $mdRow[] = sprintf('[OK](%s)', $docsUrl);
            } elseif ($isDocsWithinGracePeriod) {
                $row[] = sprintf('<comment>PENDING (%dd old)</comment>', $ageInDays);
                $mdRow[] = sprintf('PENDING (%dd old)', $ageInDays);
                $pending[] = sprintf('%s:%s (Docs)', $packageName, $tagVersion);
            } else {
                $row[] = '<error>NOT FOUND</error>';
                $mdRow[] = 'NOT FOUND';
                $notFound[] = sprintf('- [%s:%s (Docs)](%s)', $packageName, $tagVersion, $docsUrl);
            }

            $rows[] = $row;
            $mdRows[] = $mdRow;
        }

        $tableHeaders = $tag
            ? [
                [
                    new TableCell($tag, [
                        'rowspan' => 1,
                        'colspan' => count($headers),
                        'style' => new TableCellStyle(['align' => 'center', 'cellFormat' => '<info>%s</info>']),
                    ]),
                ],
                $headers,
            ]
            : [$headers];

        (new Table($output))
            ->setHeaders($tableHeaders)
            ->setRows($rows)
            ->render();

        if ($updateRelease && $tag !== null && $releaseBody !== null) {
            $verifyMarkdown = $this->buildReleaseVerificationMarkdown(
                $headers,
                $mdRows,
                $checkRuns,
                count($notFound) > 0,
                count($pending) > 0
            );
            $updatedBody = $this->upsertReleaseVerificationSection($releaseBody, $verifyMarkdown);
            if ($updatedBody !== $releaseBody) {
                if ($github->updateReleaseNotes(self::REPO_ID, $tag, $updatedBody)) {
                    $output->writeln(sprintf('<info>Updated release verification table for %s</info>', $tag));
                } else {
                    $output->writeln(sprintf('<error>Failed to update release notes for %s</error>', $tag));
                }
            }
        }

        if (count($pending) > 0) {
            $output->writeln(sprintf(
                '<comment>%d documentation version(s) PENDING (within %d-day grace period)</comment>',
                count($pending),
                self::DOCS_GRACE_PERIOD_DAYS
            ));
        }

        if (count($notFound) > 0) {
            $output->writeln(sprintf('<error>%s verification check(s) FAILED</error>', count($notFound)));
            foreach ($notFound as $notFoundItem) {
                $output->writeln(sprintf('<error>%s</error>', $notFoundItem));
            }
            return 1;
        }

        return 0;
    }

    /**
     * @return array{0: ?string, 1: ?DateTime, 2: array<int, array{component: Component, version: string}>}
     */
    private function resolveTarget(
        GitHub $github,
        ?string $tag,
        ?string $componentOption,
        ?string $overrideVersion
    ): array {
        $components = Component::getComponents($componentOption ? [$componentOption] : []);

        if ($tag) {
            $release = $github->getRelease(self::REPO_ID, $tag);
            if (false === $release) {
                throw new \InvalidArgumentException(sprintf('Tag "%s" not found', $tag));
            }
            if (!is_array($release) || !isset($release['body'])) {
                throw new \RuntimeException('Unable to retrieve tag');
            }
            $publishedAt = isset($release['published_at']) ? new DateTime($release['published_at']) : null;
            return [
                $release['body'],
                $publishedAt,
                $this->getReleaseItemsFromChangelog($release['body'], $components, $overrideVersion),
            ];
        }

        $items = [];
        foreach ($components as $component) {
            if (!($version = $overrideVersion) && !($version = $component->getComposerVersion())) {
                $version = $component->getPackageVersion();
            }
            $items[] = [
                'component' => $component,
                'version' => ltrim((string) $version, 'v'),
            ];
        }

        return [null, null, $items];
    }

    /**
     * @param string[] $headers
     * @param array<int, string[]> $mdRows
     * @param array<int, array<string, mixed>> $checkRuns
     */
    private function buildReleaseVerificationMarkdown(
        array $headers,
        array $mdRows,
        array $checkRuns,
        bool $hasFailures,
        bool $hasPending
    ): string {
        $statusLabel = $hasFailures ? 'FAILED' : ($hasPending ? 'PENDING' : 'VERIFIED');
        $lines = [
            self::VERIFY_MARKER_START,
            sprintf('<details><summary>Release Verification (%s)</summary>', $statusLabel),
            '',
        ];

        if (!empty($checkRuns)) {
            $lines[] = '### Post-Submit Checks';
            $lines[] = '| Check | Status |';
            $lines[] = '| --- | --- |';
            foreach ($checkRuns as $run) {
                $runName = $run['name'] ?? 'Unknown';
                $runUrl = $run['html_url'] ?? '';
                $label = $runUrl ? sprintf('[%s](%s)', $runName, $runUrl) : $runName;
                if (($run['status'] ?? '') !== 'completed') {
                    $status = 'PENDING';
                } elseif (in_array($run['conclusion'] ?? '', self::FAILED_CHECK_CONCLUSIONS, true)) {
                    $status = 'FAILED';
                } else {
                    $status = 'OK';
                }
                $lines[] = sprintf('| %s | %s |', $label, $status);
            }
            $lines[] = '';
        }

        $lines[] = '### Component Releases';
        $lines[] = '| ' . implode(' | ', $headers) . ' |';
        $lines[] = '| ' . implode(' | ', array_fill(0, count($headers), '---')) . ' |';
        foreach ($mdRows as $mdRow) {
            $lines[] = '| ' . implode(' | ', $mdRow) . ' |';
        }

        $lines[] = '';
        $lines[] = '</details>';
        $lines[] = self::VERIFY_MARKER_END;

        return implode("\n", $lines);
    }

    private function upsertReleaseVerificationSection(string $releaseBody, string $verifyMarkdown): string
    {
        $pattern = sprintf(
            '/%s.*?%s/s',
            preg_quote(self::VERIFY_MARKER_START, '/'),
            preg_quote(self::VERIFY_MARKER_END, '/')
        );
        if (preg_match($pattern, $releaseBody)) {
            return (string) preg_replace($pattern, $verifyMarkdown, $releaseBody);
        }

        return rtrim($releaseBody) . "\n\n" . $verifyMarkdown;
    }

    /**
     * @param Component[] $components
     * @return array<int, array{component: Component, version: string}>
     */
    private function getReleaseItemsFromChangelog(
        string $changelog,
        array $components,
        ?string $overrideVersion
    ): array {
        $releaseNotes = new ReleaseNotes($changelog);
        $items = [];
        foreach ($components as $component) {
            if ($version = $releaseNotes->getVersion($component->getId())) {
                $items[] = [
                    'component' => $component,
                    'version' => ltrim($overrideVersion ?: $version, 'v'),
                ];
            }
        }

        return $items;
    }

    private function docsVersionExists(string $componentId, string $version): bool
    {
        $url = sprintf(self::DOCS_URL, $componentId);
        try {
            $response = $this->httpClient->get($url, [
                'allow_redirects' => false,
                'http_errors' => false,
            ]);
        } catch (GuzzleException $e) {
            return false;
        }

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        $body = (string) $response->getBody();
        $quotedId = preg_quote($componentId, '/');
        $quotedVersion = preg_quote($version, '/');

        $optionPattern = sprintf(
            '/<option data-href="\/php\/docs\/reference\/%s\/(?:latest|%s)"[^>]*>\s*%s(?: \(latest\))?\s*<\/option>/',
            $quotedId,
            $quotedVersion,
            $quotedVersion
        );
        if (preg_match($optionPattern, $body)) {
            return true;
        }

        $latestPattern = sprintf(
            '/<option data-href="\/php\/docs\/reference\/%s\/latest"[^>]*>\s*([0-9]+\.[0-9]+\.[0-9]+[^\s<]*)\s*\(latest\)\s*<\/option>/',
            $quotedId
        );
        if (preg_match($latestPattern, $body, $matches)) {
            return version_compare($matches[1], $version, '>=');
        }

        return !str_contains($body, '<option data-href="/php/docs/reference/');
    }
}
