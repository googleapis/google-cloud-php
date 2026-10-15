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
    private const DOCS_GRACE_PERIOD_DAYS = 7;
    private const TABLE_HEADERS = ['Component', 'Version', 'Packagist', 'Docs'];
    private const VERIFY_MARKER_START = '<!-- RELEASE_VERIFY_START -->';
    private const VERIFY_MARKER_END = '<!-- RELEASE_VERIFY_END -->';

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
            ->setDescription('Verifies that component releases exist on Packagist and Cloud RAD reference documentation.')
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
        $tag = $input->getArgument('tag');
        $componentOption = $input->getOption('component');
        $overrideVersion = $input->getOption('package-version');
        $token = (string) $input->getOption('token');
        $updateRelease = (bool) $input->getOption('update-release');

        $github = new GitHub(new RunShell(), $this->httpClient, $token, $output);
        $packagist = new Packagist($this->httpClient, '', '', null, $output);

        [$releaseBody, $publishedAt, $items] = $this->getComponentsToVerify(
            $github,
            $tag,
            $componentOption,
            $overrideVersion
        );

        $notFound = [];
        $pending = [];

        // 1. Verify post-submit GitHub Actions check runs on the release tag
        $checkRuns = [];
        if ($tag !== null && !$componentOption) {
            $checkRuns = $this->verifyReleaseCheckRuns($github, $tag, $notFound, $pending);
        }

        // 2. Verify each component release across Packagist and Cloud RAD Docs
        $cliRows = [];
        $markdownRows = [];
        $ageInDays = $publishedAt ? max(0, (int) floor((time() - $publishedAt->getTimestamp()) / 86400)) : null;

        foreach ($items as $item) {
            [$cliRow, $markdownRow] = $this->verifyComponentRelease(
                $packagist,
                $item['component'],
                $item['version'],
                $ageInDays,
                $notFound,
                $pending
            );
            $cliRows[] = $cliRow;
            $markdownRows[] = $markdownRow;
        }

        // 3. Render the CLI table
        $this->renderCliTable($output, $tag, $cliRows);

        // 4. Optionally update the GitHub Release body with the collapsible verification table
        if ($updateRelease && $tag !== null && $releaseBody !== null) {
            $updatedBody = $this->withVerificationTable(
                $releaseBody,
                $markdownRows,
                $checkRuns,
                count($notFound) > 0,
                count($pending) > 0
            );
            if ($github->updateReleaseNotes(self::REPO_ID, $tag, $updatedBody)) {
                $output->writeln(sprintf('<info>Updated release verification table for %s</info>', $tag));
            } else {
                $output->writeln(sprintf('<error>Failed to update release notes for %s</error>', $tag));
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
     * Resolve the release body, publish date, and component versions to verify:
     * - If `tag` is provided, fetches that monorepo GitHub release and extracts the released component versions.
     * - Otherwise, returns the current local version of all components (or `-c` component).
     *
     * @return array{0: ?string, 1: ?DateTime, 2: array<int, array{component: Component, version: string}>}
     */
    private function getComponentsToVerify(
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
            $releaseNotes = new ReleaseNotes($release['body']);
            $publishedAt = isset($release['published_at']) ? new DateTime($release['published_at']) : null;

            $items = [];
            foreach ($components as $component) {
                if ($version = $releaseNotes->getVersion($component->getId())) {
                    $items[] = [
                        'component' => $component,
                        'version' => ltrim($overrideVersion ?: $version, 'v'),
                    ];
                }
            }

            return [$release['body'], $publishedAt, $items];
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
     * Fetch and evaluate GitHub Actions check runs for a release tag.
     *
     * @param string[] $notFound
     * @param string[] $pending
     * @return array<int, array<string, mixed>>
     */
    private function verifyReleaseCheckRuns(
        GitHub $github,
        string $tag,
        array &$notFound,
        array &$pending
    ): array {
        $checkRuns = $github->getCheckRuns(self::REPO_ID, $tag) ?? [];
        foreach ($checkRuns as $run) {
            $runName = $run['name'] ?? 'Unknown';
            $runUrl = $run['html_url'] ?? '';
            if (($run['status'] ?? '') !== 'completed') {
                $pending[] = sprintf('%s: %s (Check Run)', $tag, $runName);
            } elseif (GitHub::isCheckRunFailed($run)) {
                $notFound[] = $runUrl
                    ? sprintf('- [%s (Check Run)](%s)', $runName, $runUrl)
                    : sprintf('- %s (Check Run)', $runName);
            }
        }

        return $checkRuns;
    }

    /**
     * Verify a single component release across Packagist and Cloud RAD Docs,
     * returning both the CLI table row and the Markdown table row.
     *
     * @param string[] $notFound
     * @param string[] $pending
     * @return array{0: string[], 1: string[]}
     */
    private function verifyComponentRelease(
        Packagist $packagist,
        Component $component,
        string $version,
        ?int $ageInDays,
        array &$notFound,
        array &$pending
    ): array {
        $tagVersion = 'v' . $version;
        $packageName = $component->getPackageName();

        $cliRow = [$packageName, $version];
        $markdownRow = ['`' . $packageName . '`', '`' . $version . '`'];

        // Check Packagist version
        $packagistUrl = sprintf('https://packagist.org/packages/%s#%s', $packageName, $tagVersion);
        if ($packagist->versionExists($packageName, $tagVersion)) {
            $cliRow[] = '<info>OK</info>';
            $markdownRow[] = sprintf('[✅ OK](%s)', $packagistUrl);
        } else {
            $cliRow[] = '<error>NOT FOUND</error>';
            $markdownRow[] = '❌ NOT FOUND';
            $notFound[] = sprintf('- [%s:%s (Packagist)](%s)', $packageName, $tagVersion, $packagistUrl);
        }

        // Check Cloud RAD reference docs (with 7-day grace period for recent releases)
        $docsUrl = $component->getDocumentationUrl();
        $isWithinGracePeriod = $ageInDays !== null && $ageInDays < self::DOCS_GRACE_PERIOD_DAYS;
        if ($component->docsVersionExists($version, $this->httpClient)) {
            $cliRow[] = '<info>OK</info>';
            $markdownRow[] = sprintf('[✅ OK](%s)', $docsUrl);
        } elseif ($isWithinGracePeriod) {
            $cliRow[] = sprintf('<comment>PENDING (%dd old)</comment>', $ageInDays);
            $markdownRow[] = sprintf('⏳ PENDING (%dd old)', $ageInDays);
            $pending[] = sprintf('%s:%s (Docs)', $packageName, $tagVersion);
        } else {
            $cliRow[] = '<error>NOT FOUND</error>';
            $markdownRow[] = '❌ NOT FOUND';
            $notFound[] = sprintf('- [%s:%s (Docs)](%s)', $packageName, $tagVersion, $docsUrl);
        }

        return [$cliRow, $markdownRow];
    }

    /**
     * Render the verification results table to the console output.
     *
     * @param array<int, string[]> $rows
     */
    private function renderCliTable(OutputInterface $output, ?string $tag, array $rows): void
    {
        $tableHeaders = [self::TABLE_HEADERS];
        if ($tag !== null) {
            // Prepend a full-width banner row displaying the release tag name
            $tagBanner = new TableCell($tag, [
                'colspan' => count(self::TABLE_HEADERS),
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
     * Build and upsert the collapsible release verification Markdown section into the release body.
     *
     * @param array<int, string[]> $componentRows
     * @param array<int, array<string, mixed>> $checkRuns
     */
    private function withVerificationTable(
        string $releaseBody,
        array $componentRows,
        array $checkRuns,
        bool $hasFailures,
        bool $hasPending
    ): string {
        $statusLabel = $hasFailures ? '❌ Failed' : ($hasPending ? '⏳ Pending' : '✅ Verified');
        $lines = [
            self::VERIFY_MARKER_START,
            sprintf('## Release Verification: %s', $statusLabel),
            '',
        ];

        if (!empty($checkRuns)) {
            $checksFailed = false;
            $checksPending = false;
            $checkRows = [];
            foreach ($checkRuns as $run) {
                $runName = $run['name'] ?? 'Unknown';
                $runUrl = $run['html_url'] ?? '';
                $label = $runUrl ? sprintf('[%s](%s)', $runName, $runUrl) : $runName;
                if (($run['status'] ?? '') !== 'completed') {
                    $status = '⏳ PENDING';
                    $checksPending = true;
                } elseif (GitHub::isCheckRunFailed($run)) {
                    $status = '❌ FAILED';
                    $checksFailed = true;
                } else {
                    $status = '✅ OK';
                }
                $checkRows[] = sprintf('| %s | %s |', $label, $status);
            }

            $checksIcon = $checksFailed ? '❌' : ($checksPending ? '⏳' : '✅');
            $lines[] = sprintf('<details><summary>%s Post-Submit Checks</summary>', $checksIcon);
            $lines[] = '';
            $lines[] = '| Check | Status |';
            $lines[] = '| --- | --- |';
            array_push($lines, ...$checkRows);
            $lines[] = '';
            $lines[] = '</details>';
            $lines[] = '';
        }

        $componentsFailed = false;
        $componentsPending = false;
        foreach ($componentRows as $row) {
            $rowText = implode(' ', $row);
            if (str_contains($rowText, 'NOT FOUND')) {
                $componentsFailed = true;
            } elseif (str_contains($rowText, 'PENDING')) {
                $componentsPending = true;
            }
        }
        $componentsIcon = $componentsFailed ? '❌' : ($componentsPending ? '⏳' : '✅');

        $lines[] = sprintf('<details><summary>%s Component Releases</summary>', $componentsIcon);
        $lines[] = '';
        $lines[] = '| ' . implode(' | ', self::TABLE_HEADERS) . ' |';
        $lines[] = '| ' . implode(' | ', array_fill(0, count(self::TABLE_HEADERS), '---')) . ' |';
        foreach ($componentRows as $row) {
            $lines[] = '| ' . implode(' | ', $row) . ' |';
        }
        $lines[] = '';
        $lines[] = '</details>';
        $lines[] = self::VERIFY_MARKER_END;

        $verifyMarkdown = implode("\n", $lines);
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
}
