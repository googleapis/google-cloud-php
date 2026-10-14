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

use Google\Cloud\Dev\Command\ReleaseVerifyCommand;
use Google\Cloud\Dev\ReleaseNotes;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group dev
 */
class ReleaseVerifyCommandTest extends TestCase
{
    use ProphecyTrait;

    private static string $changelogBody =
        '<details><summary>google/cloud-billing-budgets: 1.2.0</summary>' .
        '### Features' . "\r\n\r\n" . '* Add resource_ancestors field</details>' .
        '<details><summary>google/cloud-build: 0.7.2</summary></details>';

    public function testVerifyTagSuccess()
    {
        $tag = 'v0.349.0';
        $http = $this->prophesize(Client::class);

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases/tags/' . $tag,
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'tag_name' => $tag,
            'published_at' => (new \DateTime('-10 days'))->format(\DateTime::ATOM),
            'body' => self::$changelogBody,
        ])));

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/commits/' . $tag . '/check-runs',
            [
                'auth' => ['', 'test-token'],
                'query' => ['filter' => 'latest', 'per_page' => 100],
            ]
        )->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'check_runs' => [
                [
                    'name' => 'Coding Standards',
                    'status' => 'completed',
                    'conclusion' => 'success',
                    'html_url' => 'https://github.com/googleapis/google-cloud-php/actions/runs/1/job/1',
                ],
            ],
        ])));

        // BillingBudgets (1.2.0)
        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php-billing-budgets/releases/tags/v1.2.0',
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledOnce()->willReturn(new Response(200));

        $http->get(Argument::that(
            fn ($url) => str_starts_with($url, 'https://packagist.org/packages/google/cloud-billing-budgets.json')
        ))->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'package' => ['versions' => ['v1.2.0' => []]],
        ])));

        $http->get(
            'https://docs.cloud.google.com/php/docs/reference/cloud-billing-budgets/latest',
            ['allow_redirects' => false, 'http_errors' => false]
        )->shouldBeCalledOnce()->willReturn(new Response(
            200,
            [],
            '<option data-href="/php/docs/reference/cloud-billing-budgets/latest" selected>1.2.0 (latest)</option>'
        ));

        // Build (0.7.2)
        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php-build/releases/tags/v0.7.2',
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledOnce()->willReturn(new Response(200));

        $http->get(Argument::that(
            fn ($url) => str_starts_with($url, 'https://packagist.org/packages/google/cloud-build.json')
        ))->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'package' => ['versions' => ['v0.7.2' => []]],
        ])));

        $http->get(
            'https://docs.cloud.google.com/php/docs/reference/cloud-build/latest',
            ['allow_redirects' => false, 'http_errors' => false]
        )->shouldBeCalledOnce()->willReturn(new Response(
            200,
            [],
            '<option data-href="/php/docs/reference/cloud-build/latest" selected>0.8.0 (latest)</option>'
        ));

        $commandTester = new CommandTester(new ReleaseVerifyCommand($http->reveal()));
        $exitCode = $commandTester->execute(['tag' => $tag, '--token' => 'test-token']);

        $this->assertSame(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertStringContainsString('v0.349.0', $display);
        $this->assertStringContainsString('google/cloud-billing-budgets', $display);
        $this->assertStringContainsString('google/cloud-build', $display);
    }

    public function testVerifyTagWithFailedCheckRunAndUpdateRelease()
    {
        $tag = 'v0.349.0';
        $http = $this->prophesize(Client::class);

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases/tags/' . $tag,
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledTimes(2)->willReturn(new Response(200, [], json_encode([
            'id' => 999,
            'tag_name' => $tag,
            'published_at' => (new \DateTime('-2 days'))->format(\DateTime::ATOM),
            'body' => '<details><summary>google/cloud-billing-budgets: 1.2.0</summary></details>',
        ])));

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/commits/' . $tag . '/check-runs',
            [
                'auth' => ['', 'test-token'],
                'query' => ['filter' => 'latest', 'per_page' => 100],
            ]
        )->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'check_runs' => [
                [
                    'name' => 'Coding Standards',
                    'status' => 'completed',
                    'conclusion' => 'failure',
                    'html_url' => 'https://github.com/googleapis/google-cloud-php/actions/runs/1/job/2',
                ],
            ],
        ])));

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php-billing-budgets/releases/tags/v1.2.0',
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledOnce()->willReturn(new Response(200));

        $http->get(Argument::that(
            fn ($url) => str_starts_with($url, 'https://packagist.org/packages/google/cloud-billing-budgets.json')
        ))->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'package' => ['versions' => ['v1.2.0' => []]],
        ])));

        $http->get(
            'https://docs.cloud.google.com/php/docs/reference/cloud-billing-budgets/latest',
            ['allow_redirects' => false, 'http_errors' => false]
        )->shouldBeCalledOnce()->willReturn(new Response(
            200,
            [],
            '<option data-href="/php/docs/reference/cloud-billing-budgets/latest" selected>1.2.0 (latest)</option>'
        ));

        $capturedBody = null;
        $http->post(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases/999',
            Argument::that(function (array $options) use (&$capturedBody) {
                $capturedBody = $options['json']['body'] ?? null;
                return $options['auth'] === ['', 'test-token'] && is_string($capturedBody);
            })
        )->shouldBeCalledOnce()->willReturn(new Response(200));

        $commandTester = new CommandTester(new ReleaseVerifyCommand($http->reveal()));
        $exitCode = $commandTester->execute([
            'tag' => $tag,
            '--token' => 'test-token',
            '--update-release' => true,
        ]);

        $this->assertSame(1, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertStringContainsString(
            '- [Coding Standards (Check Run)](https://github.com/googleapis/google-cloud-php/actions/runs/1/job/2)',
            $display
        );
        $this->assertStringContainsString('Updated release verification table for v0.349.0', $display);

        $this->assertNotNull($capturedBody);
        $this->assertStringContainsString('<!-- RELEASE_VERIFY_START -->', $capturedBody);
        $this->assertStringContainsString('Release Verification (FAILED)', $capturedBody);
        $this->assertStringContainsString(
            '| [Coding Standards](https://github.com/googleapis/google-cloud-php/actions/runs/1/job/2) | FAILED |',
            $capturedBody
        );

        // Verify ReleaseNotes ignores the appended verification section
        $releaseNotes = new ReleaseNotes($capturedBody);
        $this->assertSame('1.2.0', $releaseNotes->getVersion('cloud-billing-budgets'));
    }

    public function testVerifyDocsPendingWithinGracePeriodExitsZero()
    {
        $tag = 'v0.349.0';
        $http = $this->prophesize(Client::class);

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases/tags/' . $tag,
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'tag_name' => $tag,
            'published_at' => (new \DateTime('-2 days'))->format(\DateTime::ATOM),
            'body' => '<details><summary>google/cloud-billing-budgets: 1.2.0</summary></details>',
        ])));

        $http->get(
            'https://docs.cloud.google.com/php/docs/reference/cloud-billing-budgets/latest',
            ['allow_redirects' => false, 'http_errors' => false]
        )->shouldBeCalledOnce()->willReturn(new Response(
            200,
            [],
            '<option data-href="/php/docs/reference/cloud-billing-budgets/latest" selected>1.1.0 (latest)</option>'
        ));

        $commandTester = new CommandTester(new ReleaseVerifyCommand($http->reveal()));
        $exitCode = $commandTester->execute([
            'tag' => $tag,
            '--component' => 'BillingBudgets',
            '--token' => 'test-token',
            '--docs-only' => true,
        ]);

        $this->assertSame(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertStringContainsString('PENDING (2d old)', $display);
        $this->assertStringContainsString('1 documentation version(s) PENDING', $display);
    }

    public function testVerifyDocsMissingPastGracePeriodFails()
    {
        $tag = 'v0.348.0';
        $http = $this->prophesize(Client::class);

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases/tags/' . $tag,
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'tag_name' => $tag,
            'published_at' => (new \DateTime('-8 days'))->format(\DateTime::ATOM),
            'body' => '<details><summary>google/cloud-billing-budgets: 1.2.0</summary></details>',
        ])));

        $http->get(
            'https://docs.cloud.google.com/php/docs/reference/cloud-billing-budgets/latest',
            ['allow_redirects' => false, 'http_errors' => false]
        )->shouldBeCalledOnce()->willReturn(new Response(
            200,
            [],
            '<option data-href="/php/docs/reference/cloud-billing-budgets/latest" selected>1.1.0 (latest)</option>'
        ));

        $commandTester = new CommandTester(new ReleaseVerifyCommand($http->reveal()));
        $exitCode = $commandTester->execute([
            'tag' => $tag,
            '--component' => 'BillingBudgets',
            '--token' => 'test-token',
            '--docs-only' => true,
        ]);

        $this->assertSame(1, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertStringContainsString('NOT FOUND', $display);
        $this->assertStringContainsString('google/cloud-billing-budgets:v1.2.0 (Docs)', $display);
    }

    public function testVerifyComponentWithoutTagAndSkipDocs()
    {
        $http = $this->prophesize(Client::class);

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php-billing-budgets/releases/tags/v1.2.0',
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledOnce()->willReturn(new Response(200));

        $http->get(Argument::that(
            fn ($url) => str_starts_with($url, 'https://packagist.org/packages/google/cloud-billing-budgets.json')
        ))->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            'package' => ['versions' => []],
        ])));

        $commandTester = new CommandTester(new ReleaseVerifyCommand($http->reveal()));
        $exitCode = $commandTester->execute([
            '--component' => 'BillingBudgets',
            '--package-version' => '1.2.0',
            '--skip-docs' => true,
            '--token' => 'test-token',
        ]);

        $this->assertSame(1, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertStringContainsString('google/cloud-billing-budgets:v1.2.0 (Packagist)', $display);
    }

    public function testVerifyFromOption()
    {
        $http = $this->prophesize(Client::class);

        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases',
            ['auth' => ['', 'test-token']]
        )->shouldBeCalledOnce()->willReturn(new Response(200, [], json_encode([
            [
                'tag_name' => 'v0.349.0',
                'published_at' => (new \DateTime('-3 days'))->format(\DateTime::ATOM),
                'body' => '<details><summary>google/cloud-billing-budgets: 1.2.0</summary></details>',
            ],
            [
                'tag_name' => 'v0.340.0',
                'published_at' => (new \DateTime('-60 days'))->format(\DateTime::ATOM),
                'body' => '<details><summary>google/cloud-build: 0.7.2</summary></details>',
            ],
        ])));

        $http->get(
            'https://docs.cloud.google.com/php/docs/reference/cloud-billing-budgets/latest',
            ['allow_redirects' => false, 'http_errors' => false]
        )->shouldBeCalledOnce()->willReturn(new Response(
            200,
            [],
            '<option data-href="/php/docs/reference/cloud-billing-budgets/latest" selected>1.2.0 (latest)</option>'
        ));

        $commandTester = new CommandTester(new ReleaseVerifyCommand($http->reveal()));
        $exitCode = $commandTester->execute([
            '--from' => '-14 days',
            '--component' => 'BillingBudgets',
            '--docs-only' => true,
            '--token' => 'test-token',
        ]);

        $this->assertSame(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertStringContainsString('v0.349.0', $display);
        $this->assertStringNotContainsString('v0.340.0', $display);
    }

    public function testMutuallyExclusiveOptionsThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot specify both --docs-only and --skip-docs');

        $commandTester = new CommandTester(new ReleaseVerifyCommand());
        $commandTester->execute([
            '--docs-only' => true,
            '--skip-docs' => true,
        ]);
    }
}
