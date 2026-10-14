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
                'from',
                '',
                InputOption::VALUE_REQUIRED,
                'Date string representing how far back to verify releases (e.g. "-14 days")'
            )
            ->addOption(
                'token',
                't',
                InputOption::VALUE_REQUIRED,
                'GitHub token to use for authentication',
                ''
            )
            ->addOption(
                'docs-only',
                '',
                InputOption::VALUE_NONE,
                'Only verify Cloud RAD reference documentation'
            )
            ->addOption(
                'skip-docs',
                '',
                InputOption::VALUE_NONE,
                'Skip Cloud RAD reference documentation verification'
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
        $docsOnly = (bool) $input->getOption('docs-only');
        $skipDocs = (bool) $input->getOption('skip-docs');
        $updateRelease = (bool) $input->getOption('update-release');
        if ($docsOnly && $skipDocs) {
            throw new \InvalidArgumentException('Cannot specify both --docs-only and --skip-docs');
        }

        $tag = $input->getArgument('tag');
        $from = $input->getOption('from');
        if ($from && $tag) {
            throw new \InvalidArgumentException('cannot specify both a tag and a from date');
        }

        $token = (string) $input->getOption('token');
        $github = new GitHub(new RunShell(), $this->httpClient, $token, $output);
        $packagist = new Packagist($this->httpClient, '', '', null, $output);

        $componentOption = $input->getOption('component');
        $overrideVersion = $input->getOption('package-version');

        $headers = $this->getColumnHeaders($docsOnly, $skipDocs);
        $releases = $this->getReleasesToVerify($github, $tag, $from, $componentOption, $overrideVersion);

        $allFailures = [];
        $allPending = [];

        foreach ($releases as $release) {
            $releaseTag = $release['tag'];
            $releaseFailures = [];
            $releasePending = [];

            // 1. Verify post-submit GitHub Actions check runs on the release tag
            $checkRuns = [];
            if ($releaseTag !== null && !$docsOnly && !$componentOption) {
                $checkRuns = $this->verifyReleaseCheckRuns(
                    $github,
                    $releaseTag,
                    $releaseFailures,
                    $releasePending
                );
            }

            // 2. Verify each component in the release (Split Repo, Packagist, and Cloud RAD Docs)
            $cliRows = [];
            $markdownRows = [];
            $ageInDays = $this->getReleaseAgeInDays($release['publishedAt']);

            foreach ($release['items'] as $item) {
                [$cliRow, $markdownRow] = $this->verifyComponentRelease(
                    $github,
                    $packagist,
                    $item['component'],
                    $item['version'],
                    $docsOnly,
                    $skipDocs,
                    $ageInDays,
                    $releaseFailures,
                    $releasePending
                );
                $cliRows[] = $cliRow;
                $markdownRows[] = $markdownRow;
            }

            // 3. Render the CLI table for this release
            $this->renderCliTable($output, $releaseTag, $headers, $cliRows);

            // 4. Optionally update the GitHub Release body with the collapsible verification table
            if ($updateRelease && $releaseTag !== null && $release['releaseBody'] !== null) {
                $this->updateGitHubReleaseBody(
                    $github,
                    $output,
                    $releaseTag,
                    $release['releaseBody'],
                    $headers,
                    $markdownRows,
                    $checkRuns,
                    count($releaseFailures) > 0,
                    count($releasePending) > 0
                );
            }

            $allFailures = array_merge($allFailures, $releaseFailures);
            $allPending = array_merge($allPending, $releasePending);
        }

        if (count($allPending) > 0) {
            $output->writeln(sprintf(
                '<comment>%d documentation version(s) PENDING (within %d-day grace period)</comment>',
                count($allPending),
                self::DOCS_GRACE_PERIOD_DAYS
            ));
        }

        if (count($allFailures) > 0) {
            $output->writeln(sprintf('<error>%s verification check(s) FAILED</error>', count($allFailures)));
            foreach ($allFailures as $failure) {
                $output->writeln(sprintf('<error>%s</error>', $failure));
            }
            return 1;
        }

        return 0;
    }

    /**
     * Build the table column headers based on which verification checks are enabled.
     *
     * @return string[]
     */
    private function getColumnHeaders(bool $docsOnly, bool $skipDocs): array
    {
        $headers = ['Component', 'Version'];
        if (!$docsOnly) {
            $headers[] = 'Split Repo';
            $headers[] = 'Packagist';
        }
        if (!$skipDocs) {
            $headers[] = 'Docs';
        }

        return $headers;
    }

    /**
     * Calculate the age of a release in whole days, or null if no publish date is available.
     */
    private function getReleaseAgeInDays(?DateTime $publishedAt): ?int
    {
        if ($publishedAt === null) {
            return null;
        }
        $ageInSeconds = time() - $publishedAt->getTimestamp();

        return max(0, (int) floor($ageInSeconds / 86400));
    }

    /**
     * Fetch and evaluate GitHub Actions check runs for a release tag.
     *
     * @param string[] $failures
     * @param string[] $pending
     * @return array<int, array<string, mixed>>
     */
    private function verifyReleaseCheckRuns(
        GitHub $github,
        string $releaseTag,
        array &$failures,
        array &$pending
    ): array {
        $checkRuns = $github->getCheckRuns(self::REPO_ID, $releaseTag) ?? [];
        usort($checkRuns, fn (array $a, array $b) => strcmp($a['name'] ?? '', $b['name'] ?? ''));

        foreach ($checkRuns as $run) {
            $runName = $run['name'] ?? 'Unknown';
            $runUrl = $run['html_url'] ?? '';
            if (($run['status'] ?? '') !== 'completed') {
                $pending[] = sprintf('%s: %s (Check Run)', $releaseTag, $runName);
            } elseif (in_array($run['conclusion'] ?? '', self::FAILED_CHECK_CONCLUSIONS, true)) {
                $failures[] = $runUrl
                    ? sprintf('- [%s (Check Run)](%s)', $runName, $runUrl)
                    : sprintf('- %s (Check Run)', $runName);
            }
        }

        return $checkRuns;
    }

    /**
     * Verify a single component release across Split Repo, Packagist, and Cloud RAD Docs,
     * returning both the CLI table row and the Markdown table row.
     *
     * @param string[] $failures
     * @param string[] $pending
     * @return array{0: string[], 1: string[]}
     */
    private function verifyComponentRelease(
        GitHub $github,
        Packagist $packagist,
        Component $component,
        string $version,
        bool $docsOnly,
        bool $skipDocs,
        ?int $ageInDays,
        array &$failures,
        array &$pending
    ): array {
        $tagVersion = 'v' . $version;
        $packageName = $component->getPackageName();

        $cliRow = [$packageName, $version];
        $markdownRow = ['`' . $packageName . '`', '`' . $version . '`'];

        // Check Split Repo tag and Packagist version unless --docs-only is set
        if (!$docsOnly) {
            $splitUrl = sprintf('https://github.com/%s/releases/tag/%s', $component->getRepoName(), $tagVersion);
            if ($github->doesTagExist($component->getRepoName(), $tagVersion)) {
                $cliRow[] = '<info>OK</info>';
                $markdownRow[] = sprintf('[OK](%s)', $splitUrl);
            } else {
                $cliRow[] = '<error>NOT FOUND</error>';
                $markdownRow[] = 'NOT FOUND';
                $failures[] = sprintf('- [%s:%s (Split Repo)](%s)', $packageName, $tagVersion, $splitUrl);
            }

            $packagistUrl = sprintf('https://packagist.org/packages/%s#%s', $packageName, $tagVersion);
            if ($packagist->versionExists($packageName, $tagVersion)) {
                $cliRow[] = '<info>OK</info>';
                $markdownRow[] = sprintf('[OK](%s)', $packagistUrl);
            } else {
                $cliRow[] = '<error>NOT FOUND</error>';
                $markdownRow[] = 'NOT FOUND';
                $failures[] = sprintf('- [%s:%s (Packagist)](%s)', $packageName, $tagVersion, $packagistUrl);
            }
        }

        // Check Cloud RAD reference docs unless --skip-docs is set
        if (!$skipDocs) {
            $docsUrl = sprintf(self::DOCS_URL, $component->getId());
            $isWithinGracePeriod = $ageInDays !== null && $ageInDays < self::DOCS_GRACE_PERIOD_DAYS;

            if ($this->docsVersionExists($component->getId(), $version)) {
                $cliRow[] = '<info>OK</info>';
                $markdownRow[] = sprintf('[OK](%s)', $docsUrl);
            } elseif ($isWithinGracePeriod) {
                $cliRow[] = sprintf('<comment>PENDING (%dd old)</comment>', $ageInDays);
                $markdownRow[] = sprintf('PENDING (%dd old)', $ageInDays);
                $pending[] = sprintf('%s:%s (Docs)', $packageName, $tagVersion);
            } else {
                $cliRow[] = '<error>NOT FOUND</error>';
                $markdownRow[] = 'NOT FOUND';
                $failures[] = sprintf('- [%s:%s (Docs)](%s)', $packageName, $tagVersion, $docsUrl);
            }
        }

        return [$cliRow, $markdownRow];
    }

    /**
     * Render the verification results table to the console output.
     *
     * @param string[] $headers
     * @param array<int, string[]> $rows
     */
    private function renderCliTable(
        OutputInterface $output,
        ?string $releaseTag,
        array $headers,
        array $rows
    ): void {
        $tableHeaders = [$headers];
        if ($releaseTag !== null) {
            // Prepend a full-width banner row displaying the release tag name
            $tagBanner = new TableCell($releaseTag, [
                'colspan' => count($headers),
                'style' => new TableCellStyle([
                    'align' => 'center',
                    'cellFormat' => '<info>%s</info>',
                ]),
            ]);
            array_unshift($tableHeaders, [$tagBanner]);
        }

        (new Table($output))
            ->setHeaders($tableHeaders)
            ->setRows($rows)
            ->render();
    }

    /**
     * Resolve the list of releases (and their component versions) to verify:
     * - If `--from` is provided, fetches all monorepo GitHub releases since that date.
     * - If `tag` is provided, fetches that single monorepo GitHub release.
     * - Otherwise, verifies the current local version of all components (or `-c` component).
     *
     * @return array<int, array{tag: ?string, releaseBody: ?string, publishedAt: ?DateTime, items: array<int, array{component: Component, version: string}>}>
     */
    private function getReleasesToVerify(
        GitHub $github,
        ?string $tag,
        ?string $from,
        ?string $componentOption,
        ?string $overrideVersion
    ): array {
        $components = Component::getComponents($componentOption ? [$componentOption] : []);

        if ($from) {
            $releases = $github->getReleases(self::REPO_ID, new DateTime($from));
            if ($releases === null) {
                throw new \RuntimeException('Unable to retrieve releases');
            }
            $releasesToVerify = [];
            foreach ($releases as $release) {
                $releaseTag = $release['tag_name'];
                $changelog = $release['body'] ?? $github->getChangelog(self::REPO_ID, $releaseTag);
                if (false === $changelog) {
                    throw new \InvalidArgumentException(sprintf('Tag "%s" not found', $releaseTag));
                }
                if (null === $changelog) {
                    throw new \RuntimeException('Unable to retrieve tag');
                }
                $publishedAt = isset($release['published_at']) ? new DateTime($release['published_at']) : null;
                $items = $this->getReleaseItemsFromChangelog($changelog, $components, $overrideVersion);
                if ($items) {
                    $releasesToVerify[] = [
                        'tag' => $releaseTag,
                        'releaseBody' => $changelog,
                        'publishedAt' => $publishedAt,
                        'items' => $items,
                    ];
                }
            }
            return $releasesToVerify;
        }

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
                [
                    'tag' => $tag,
                    'releaseBody' => $release['body'],
                    'publishedAt' => $publishedAt,
                    'items' => $this->getReleaseItemsFromChangelog($release['body'], $components, $overrideVersion),
                ],
            ];
        }

        // Default when no tag or --from is supplied: verify all local components
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

        return [
            [
                'tag' => null,
                'releaseBody' => null,
                'publishedAt' => null,
                'items' => $items,
            ],
        ];
    }

    /**
     * Parse component versions from a monorepo GitHub release changelog body.
     *
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

    /**
     * Update the GitHub Release body with the collapsible verification status table if it changed.
     *
     * @param string[] $headers
     * @param array<int, string[]> $markdownRows
     * @param array<int, array<string, mixed>> $checkRuns
     */
    private function updateGitHubReleaseBody(
        GitHub $github,
        OutputInterface $output,
        string $releaseTag,
        string $releaseBody,
        array $headers,
        array $markdownRows,
        array $checkRuns,
        bool $hasFailures,
        bool $hasPending
    ): void {
        $verifyMarkdown = $this->buildReleaseVerificationMarkdown(
            $headers,
            $markdownRows,
            $checkRuns,
            $hasFailures,
            $hasPending
        );
        $updatedBody = $this->upsertReleaseVerificationSection($releaseBody, $verifyMarkdown);
        if ($updatedBody === $releaseBody) {
            return;
        }

        if ($github->updateReleaseNotes(self::REPO_ID, $releaseTag, $updatedBody)) {
            $output->writeln(sprintf('<info>Updated release verification table for %s</info>', $releaseTag));
        } else {
            $output->writeln(sprintf('<error>Failed to update release notes for %s</error>', $releaseTag));
        }
    }

    /**
     * Build the collapsible Markdown block appended to the GitHub Release body.
     *
     * @param string[] $headers
     * @param array<int, string[]> $markdownRows
     * @param array<int, array<string, mixed>> $checkRuns
     */
    private function buildReleaseVerificationMarkdown(
        array $headers,
        array $markdownRows,
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
        foreach ($markdownRows as $markdownRow) {
            $lines[] = '| ' . implode(' | ', $markdownRow) . ' |';
        }

        $lines[] = '';
        $lines[] = '</details>';
        $lines[] = self::VERIFY_MARKER_END;

        return implode("\n", $lines);
    }

    /**
     * Replace an existing verification section in the release body, or append it at the end.
     */
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
     * Check whether the given component version has been published to Cloud RAD reference docs.
     *
     * Note: This must use a GET request to `/latest` rather than a HEAD request because:
     * 1. Versioned URLs (`/php/docs/reference/{id}/{version}`) always return a 301 redirect to
     *    `/latest` even for nonexistent versions (e.g. `9.9.9`).
     * 2. A HEAD request to `/latest` returns 200 OK as long as *any* older version of the package
     *    exists, so we must inspect the HTML `<option>` version selector in the response body to
     *    confirm that `$version` (or a newer version) is actually live.
     */
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
