<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit\Split;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Dev\Split\GitHub;
use Google\Cloud\Dev\Split\RunShell;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;

/**
 * @group dev
 * @group dev-split
 */
class GitHubTest extends TestCase
{
    const TOKEN = 'test-token';
    const TARGET = 'foo/bar.git';
    const TARGET_CLEAN = 'foo/bar';
    const TAG = 'v0.0.0';

    private $shell;
    private $guzzle;
    private $github;
    private $exception;

    public function set_up()
    {
        if (PHP_VERSION_ID < 50600) {
            $this->markTestSkipped("This test only runs on PHP 5.6+");
        }

        $this->shell = $this->prophesize(RunShell::class);
        $this->guzzle = $this->prophesize(Client::class);
        $this->github = TestHelpers::stub(GitHub::class, [
            $this->shell->reveal(),
            $this->guzzle->reveal(),
            self::TOKEN
        ], ['shell', 'client']);
        $this->exception = $this->prophesize(BadResponseException::class);
    }

    public function testGetDefaultBranch()
    {
        $resp = new Response(200, [], file_get_contents(__DIR__ . '/../../fixtures/split/get-repo.json'));
        $uri = sprintf(GitHub::GITHUB_REPO_ENDPOINT, self::TARGET_CLEAN);
        $this->guzzle->get($uri, [
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->shouldBeCalledOnce()->willReturn($resp);

        $this->assertEquals('main', $this->github->getDefaultBranch(self::TARGET_CLEAN));

        // call again to test the cache.
        $this->github->getDefaultBranch(self::TARGET_CLEAN);
    }

    public function testGetDefaultBranchHttpError()
    {
        $this->guzzle->get(Argument::any(), Argument::any())->willThrow($this->exception->reveal());
        $this->assertNull($this->github->getDefaultBranch(self::TARGET_CLEAN));
    }

    public function testIsTargetEmpty()
    {
        $body = file_get_contents(__DIR__ . '/../../fixtures/split/get-repo.json');
        $resp = new Response(200, [], $body);
        $uri = sprintf(GitHub::GITHUB_REPO_ENDPOINT, self::TARGET_CLEAN);
        $this->guzzle->get($uri, [
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->shouldBeCalledOnce()->willReturn($resp);

        $this->assertFalse($this->github->isTargetEmpty(self::TARGET_CLEAN));

        // call again to test the cache.
        $this->github->isTargetEmpty(self::TARGET_CLEAN);
    }

    public function testIsTargetEmptyReturnsTrue()
    {
        $body = file_get_contents(__DIR__ . '/../../fixtures/split/get-repo.json');
        $json = json_decode($body, true);
        $json['size'] = 0;

        $resp = new Response(200, [], json_encode($json));
        $uri = sprintf(GitHub::GITHUB_REPO_ENDPOINT, self::TARGET_CLEAN);
        $this->guzzle->get($uri, [
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->shouldBeCalledOnce()->willReturn($resp);

        $this->assertTrue($this->github->isTargetEmpty(self::TARGET_CLEAN));
    }

    public function testIsTargetEmptyHttpError()
    {
        $this->guzzle->get(Argument::any(), Argument::any())->willThrow($this->exception->reveal());
        $this->assertNull($this->github->isTargetEmpty(self::TARGET_CLEAN));
    }

    public function testDoesTagExist()
    {
        $uri = sprintf(GitHub::GITHUB_RELEASE_ENDPOINT, self::TARGET_CLEAN, self::TAG);
        $this->guzzle->get($uri, [
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->willReturn(new Response);

        $this->github->___setProperty('client', $this->guzzle->reveal());

        $this->assertTrue($this->github->doesTagExist(self::TARGET, self::TAG));
    }

    public function testDoesTagExistReturnFalse()
    {
        $uri = sprintf(GitHub::GITHUB_RELEASE_ENDPOINT, self::TARGET_CLEAN, self::TAG);
        $this->guzzle->get($uri, [
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->willReturn(new Response(404));

        $this->github->___setProperty('client', $this->guzzle->reveal());

        $this->assertFalse($this->github->doesTagExist(self::TARGET, self::TAG));
    }

    public function testDoesTagExistHttpError()
    {
        $this->guzzle->get(Argument::any(), Argument::any())->willThrow($this->exception->reveal());
        $this->assertNull($this->github->doesTagExist(self::TARGET_CLEAN, self::TAG));
    }

    public function testCreateRelease()
    {
        $uri = sprintf(GitHub::GITHUB_RELEASE_CREATE_ENDPOINT, self::TARGET_CLEAN);
        $this->guzzle->post($uri, [
            'json' => [
                'tag_name' => self::TAG,
                'name' => 'foo',
                'body' => 'bar'
            ],
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->willReturn(new Response(201));

        $this->github->___setProperty('client', $this->guzzle->reveal());

        $this->assertTrue($this->github->createRelease(self::TARGET, self::TAG, 'foo', 'bar'));
    }

    public function testCreateReleaseFails()
    {
        $uri = sprintf(GitHub::GITHUB_RELEASE_CREATE_ENDPOINT, self::TARGET_CLEAN);
        $this->guzzle->post($uri, [
            'json' => [
                'tag_name' => self::TAG,
                'name' => 'foo',
                'body' => 'bar'
            ],
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->willReturn(new Response(500));

        $this->github->___setProperty('client', $this->guzzle->reveal());

        $this->assertFalse($this->github->createRelease(self::TARGET, self::TAG, 'foo', 'bar'));
    }

    public function testCreateReleaseHttpError()
    {
        $this->guzzle->post(Argument::any(), Argument::any())->willThrow($this->exception->reveal());
        $this->assertFalse($this->github->createRelease(self::TARGET, self::TAG, 'foo', 'bar'));
    }

    public function testGetChangelog()
    {
        $resp = file_get_contents(__DIR__ . '/../../fixtures/split/get-release.json');
        $this->guzzle->get(
            sprintf(GitHub::GITHUB_RELEASE_ENDPOINT, self::TARGET, self::TAG),
            ['auth' => [null, self::TOKEN]]
        )->shouldBeCalled()->willReturn(new Response(200, [], $resp));

        $this->assertEquals(json_decode($resp, true)['body'], $this->github->getChangelog(self::TARGET, self::TAG));
    }

    public function testGetChangelogHttpError()
    {
        $this->guzzle->get(Argument::any(), Argument::any())->willThrow($this->exception->reveal());
        $this->assertNull($this->github->getChangelog(self::TARGET_CLEAN, self::TAG));
    }

    public function testPush()
    {
        $cmd = sprintf(
            'git push -q https://%s@github.com/%s %s:%s --force',
            self::TOKEN,
            self::TARGET,
            'foo',
            'main'
        );

        $this->shell->execute($cmd)->shouldBeCalled()->willReturn([true]);

        $this->github->___setProperty('shell', $this->shell->reveal());

        $this->github->push(self::TARGET, 'foo');
    }

    public function testPushToBranch()
    {
        $cmd = sprintf(
            'git push -q https://%s@github.com/%s %s:%s --force',
            self::TOKEN,
            self::TARGET,
            'foo',
            'bar'
        );

        $this->shell->execute($cmd)->shouldBeCalled()->willReturn([true]);

        $this->github->___setProperty('shell', $this->shell->reveal());

        $this->github->push(self::TARGET, 'foo', 'bar');
    }

    public function testPushInitialCommit()
    {
        $cmd = sprintf(
            'git push -q https://%s@github.com/%s %s:%s',
            self::TOKEN,
            self::TARGET,
            'foo',
            'refs/heads/main'
        );

        $this->shell->execute($cmd)->shouldBeCalled()->willReturn([true]);

        $this->github->___setProperty('shell', $this->shell->reveal());

        $this->github->push(self::TARGET, 'foo', 'main', true);
    }
}
