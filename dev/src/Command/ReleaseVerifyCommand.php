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
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $docsOnly = (bool) $input->getOption('docs-only');
        $skipDocs = (bool) $input->getOption('skip-docs');
        if ($docsOnly && $skipDocs) {
            throw new \InvalidArgumentException('Cannot specify both --docs-only and --skip-docs');
        }

        $tag = $input->getArgument('tag');
        $from = $input->getOption('from');
        if ($from && $tag) {
            throw new \InvalidArgumentException('cannot specify both a tag and a from date');
        }

        $token = $input->getOption('token') ?: (getenv('GH_OAUTH_TOKEN') ?: (getenv('GITHUB_TOKEN') ?: ''));
        $github = new GitHub(new RunShell(), $this->httpClient, $token, $output);
        $packagist = new Packagist($this->httpClient, '', '', null, $output);

        $componentOption = $input->getOption('component');
        $overrideVersion = $input->getOption('package-version');

        $batches = $this->resolveBatches($github, $tag, $from, $componentOption, $overrideVersion);

        $checkSplit = !$docsOnly;
        $checkPackagist = !$docsOnly;
        $checkDocs = !$skipDocs;

        $headers = ['Component', 'Version'];
        if ($checkSplit) {
            $headers[] = 'Split Repo';
        }
        if ($checkPackagist) {
            $headers[] = 'Packagist';
        }
        if ($checkDocs) {
            $headers[] = 'Docs';
        }

        $notFound = [];
        $pending = [];

        foreach ($batches as $batch) {
            $batchTag = $batch['tag'];
            /** @var ?DateTime $publishedAt */
            $publishedAt = $batch['publishedAt'];
            $ageInSeconds = $publishedAt ? (time() - $publishedAt->getTimestamp()) : null;
            $ageInDays = $ageInSeconds !== null ? max(0, (int) floor($ageInSeconds / 86400)) : null;
            $isDocsWithinGracePeriod = $ageInSeconds !== null
                && $ageInSeconds < (self::DOCS_GRACE_PERIOD_DAYS * 86400);

            $rows = [];
            foreach ($batch['items'] as $item) {
                /** @var Component $component */
                $component = $item['component'];
                $version = $item['version'];
                $tagVersion = 'v' . $version;
                $packageName = $component->getPackageName();

                $row = [$packageName, $version];

                if ($checkSplit) {
                    if ($github->doesTagExist($component->getRepoName(), $tagVersion)) {
                        $row[] = '<info>OK</info>';
                    } else {
                        $row[] = '<error>NOT FOUND</error>';
                        $notFound[] = sprintf('%s:%s (Split Repo)', $packageName, $tagVersion);
                    }
                }

                if ($checkPackagist) {
                    if ($packagist->versionExists($packageName, $tagVersion)) {
                        $row[] = '<info>OK</info>';
                    } else {
                        $row[] = '<error>NOT FOUND</error>';
                        $notFound[] = sprintf('%s:%s (Packagist)', $packageName, $tagVersion);
                    }
                }

                if ($checkDocs) {
                    if ($this->docsVersionExists($component->getId(), $version)) {
                        $row[] = '<info>OK</info>';
                    } elseif ($isDocsWithinGracePeriod) {
                        $row[] = sprintf('<comment>PENDING (%dd old)</comment>', $ageInDays);
                        $pending[] = sprintf('%s:%s (Docs)', $packageName, $tagVersion);
                    } else {
                        $row[] = '<error>NOT FOUND</error>';
                        $notFound[] = sprintf('%s:%s (Docs)', $packageName, $tagVersion);
                    }
                }

                $rows[] = $row;
            }

            $tableHeaders = $batchTag
                ? [
                    [
                        new TableCell($batchTag, [
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
        }

        if (count($pending) > 0) {
            $output->writeln(sprintf(
                '<comment>%d documentation version(s) PENDING (within %d-day grace period)</comment>',
                count($pending),
                self::DOCS_GRACE_PERIOD_DAYS
            ));
        }

        if (count($notFound) > 0) {
            $output->writeln(sprintf('<error>%s package version(s) NOT FOUND</error>', count($notFound)));
            foreach ($notFound as $notFoundPackageName) {
                $output->writeln(sprintf('<error>%s</error>', $notFoundPackageName));
            }
            return 1;
        }

        return 0;
    }

    /**
     * @return array<int, array{tag: ?string, publishedAt: ?DateTime, items: array<int, array{component: Component, version: string}>}>
     */
    private function resolveBatches(
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
            $batches = [];
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
                    $batches[] = [
                        'tag' => $releaseTag,
                        'publishedAt' => $publishedAt,
                        'items' => $items,
                    ];
                }
            }
            return $batches;
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
                    'publishedAt' => $publishedAt,
                    'items' => $this->getReleaseItemsFromChangelog($release['body'], $components, $overrideVersion),
                ],
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

        return [
            [
                'tag' => null,
                'publishedAt' => null,
                'items' => $items,
            ],
        ];
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
