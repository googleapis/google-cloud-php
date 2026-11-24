<?php
/**
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit\Command;

use Google\Cloud\Dev\Command\RepoSplitCommand;
use Google\Cloud\Dev\Component;
use Google\Cloud\Dev\GitHub;
use Google\Cloud\Dev\ReleaseNotes;
use Google\Cloud\Dev\RunShell;
use Google\Cloud\Dev\Split;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @group dev
 * @group dev-split
 */
class RepoSplitCommandTest extends TestCase
{
    use ProphecyTrait;

    private const PARENT_REPO = 'googleapis/google-cloud-php';
    private const PARENT_TAG = 'v0.350.0';
    private const COMPONENT_NAME = 'Foo';
    private const COMPONENT_ID = 'cloud-foo';
    private const PACKAGE_NAME = 'google/cloud-foo';
    private const REPO_NAME = 'googleapis/google-cloud-php-foo';
    private const SPLITSH_PATH = '/usr/local/bin/splitsh-lite';
    private const SPLIT_SHA = 'abc1234';
    private const PACKAGIST_USER = 'test-packagist-user';
    private const PACKAGIST_TOKEN = 'test-packagist-token';
    private const PACKAGIST_SAFE_TOKEN = 'test-packagist-safe-token';

    private string $tmpDir;

    protected function setUp(): void
    {
        $this->tmpDir = sys_get_temp_dir() . '/repo-split-test-' . uniqid('', true);
        mkdir($this->tmpDir, 0777, true);
    }

    protected function tearDown(): void
    {
        if (is_dir($this->tmpDir)) {
            (new Filesystem())->remove($this->tmpDir);
        }
    }

    public function testFirstReleasePausesRepoSettingsAndTeamPermissions()
    {
        $version = '0.1.0';
        $tagName = 'v' . $version;
        $component = $this->createComponentProphecy($version);
        $split = $this->prophesize(Split::class);
        $github = $this->prophesize(GitHub::class);
        $guzzle = $this->prophesize(Client::class);

        $github->getChangelog(self::PARENT_REPO, self::PARENT_TAG)
            ->shouldBeCalledOnce()
            ->willReturn(sprintf('<details><summary>%s: %s</summary></details>', self::PACKAGE_NAME, $version));
        $github->doesTagExist(self::REPO_NAME, $tagName)
            ->shouldBeCalledOnce()
            ->willReturn(false);
        $github->getDefaultBranch(self::REPO_NAME)
            ->shouldBeCalledOnce()
            ->willReturn('main');
        $github->isTargetEmpty(self::REPO_NAME)
            ->shouldBeCalledOnce()
            ->willReturn(true);

        $split->execute(self::SPLITSH_PATH, realpath($this->tmpDir), self::COMPONENT_NAME)
            ->shouldBeCalledOnce()
            ->willReturn(self::SPLIT_SHA);

        $github->push(self::REPO_NAME, self::SPLIT_SHA, 'main', true)
            ->shouldBeCalledOnce()
            ->willReturn([true, '']);
        $github->createRelease(
            self::REPO_NAME,
            $tagName,
            self::PACKAGE_NAME . ' ' . $tagName,
            '### Miscellaneous Chores'
        )->shouldBeCalledOnce()->willReturn(true);

        $github->updateRepoDetails(self::REPO_NAME, ['has_pull_requests' => false])
            ->shouldBeCalledOnce()
            ->willReturn(true);

        $guzzle->post('https://packagist.org/api/create-package', [
            'query' => [
                'apiToken' => self::PACKAGIST_TOKEN,
                'username' => self::PACKAGIST_USER,
            ],
            'json' => [
                'repository' => ['url' => 'https://github.com/' . self::REPO_NAME],
            ],
        ])->shouldBeCalledOnce()->willReturn(new Response(202));

        $github->addWebhook(
            self::REPO_NAME,
            'https://packagist.org/api/update-package?username=' . self::PACKAGIST_USER,
            self::PACKAGIST_SAFE_TOKEN
        )->shouldBeCalledOnce()->willReturn(true);

        $github->updateTeamPermission(Argument::cetera())->shouldNotBeCalled();

        $command = $this->createCommand(
            [$component->reveal()],
            $split->reveal(),
            $github->reveal(),
            $guzzle->reveal()
        );
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute($this->defaultInput());

        $this->assertSame(0, $exitCode);
        $this->assertStringContainsString(
            'Disabled pull requests for first release.',
            $commandTester->getDisplay()
        );
    }

    public function testSubsequentReleaseSkipsFirstReleaseSetup()
    {
        $version = '0.2.0';
        $tagName = 'v' . $version;
        $component = $this->createComponentProphecy($version);
        $split = $this->prophesize(Split::class);
        $github = $this->prophesize(GitHub::class);
        $guzzle = $this->prophesize(Client::class);

        $github->getChangelog(self::PARENT_REPO, self::PARENT_TAG)
            ->shouldBeCalledOnce()
            ->willReturn(sprintf('<details><summary>%s: %s</summary></details>', self::PACKAGE_NAME, $version));
        $github->doesTagExist(self::REPO_NAME, $tagName)
            ->shouldBeCalledOnce()
            ->willReturn(false);
        $github->getDefaultBranch(self::REPO_NAME)
            ->shouldBeCalledOnce()
            ->willReturn('main');
        $github->isTargetEmpty(self::REPO_NAME)
            ->shouldBeCalledOnce()
            ->willReturn(false);

        $split->execute(self::SPLITSH_PATH, realpath($this->tmpDir), self::COMPONENT_NAME)
            ->shouldBeCalledOnce()
            ->willReturn(self::SPLIT_SHA);

        $github->push(self::REPO_NAME, self::SPLIT_SHA, 'main', false)
            ->shouldBeCalledOnce()
            ->willReturn([true, '']);
        $github->createRelease(
            self::REPO_NAME,
            $tagName,
            self::PACKAGE_NAME . ' ' . $tagName,
            '### Miscellaneous Chores'
        )->shouldBeCalledOnce()->willReturn(true);

        $github->updateRepoDetails(Argument::cetera())->shouldNotBeCalled();
        $guzzle->post(Argument::cetera())->shouldNotBeCalled();
        $github->addWebhook(Argument::cetera())->shouldNotBeCalled();
        $github->updateTeamPermission(Argument::cetera())->shouldNotBeCalled();

        $command = $this->createCommand(
            [$component->reveal()],
            $split->reveal(),
            $github->reveal(),
            $guzzle->reveal()
        );
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute($this->defaultInput());

        $this->assertSame(0, $exitCode);
    }

    private function createComponentProphecy(string $version)
    {
        $component = $this->prophesize(Component::class);
        $component->getPackageVersion()->willReturn($version);
        $component->getRepoName()->willReturn(self::REPO_NAME);
        $component->getId()->willReturn(self::COMPONENT_ID);
        $component->getName()->willReturn(self::COMPONENT_NAME);
        $component->getPackageName()->willReturn(self::PACKAGE_NAME);

        return $component;
    }

    /**
     * @return array<string, string>
     */
    private function defaultInput(): array
    {
        return [
            'repo' => self::PARENT_REPO,
            'parent' => self::PARENT_TAG,
            '--token' => 'test-gh-token',
            '--splitsh' => self::SPLITSH_PATH,
            '--packagist-username' => self::PACKAGIST_USER,
            '--packagist-token' => self::PACKAGIST_TOKEN,
            '--packagist-safe-token' => self::PACKAGIST_SAFE_TOKEN,
        ];
    }

    /**
     * @param Component[] $components
     */
    private function createCommand(
        array $components,
        Split $split,
        GitHub $github,
        Client $guzzle
    ): RepoSplitCommand {
        return new class ($this->tmpDir, $components, $split, $github, $guzzle) extends RepoSplitCommand {
            /**
             * @param Component[] $components
             */
            public function __construct(
                string $rootPath,
                private array $components,
                private Split $split,
                private GitHub $github,
                private Client $guzzle
            ) {
                parent::__construct($rootPath);
            }

            protected function getComponents(ReleaseNotes $releaseNotes, ?string $componentId): array
            {
                return $this->components;
            }

            protected function splitWrapper(OutputInterface $output, RunShell $shell)
            {
                return $this->split;
            }

            protected function githubClient(OutputInterface $output, RunShell $shell, Client $guzzle, $token)
            {
                return $this->github;
            }

            protected function guzzleClient()
            {
                return $this->guzzle;
            }
        };
    }
}
