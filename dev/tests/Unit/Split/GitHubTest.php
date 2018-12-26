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
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

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

    public function setUp()
    {
        $this->shell = $this->prophesize(RunShell::class);
        $this->guzzle = $this->prophesize(Client::class);
        $this->github = TestHelpers::stub(GitHub::class, [
            $this->shell->reveal(),
            $this->guzzle->reveal(),
            self::TOKEN
        ], ['shell', 'client']);
    }

    public function testDoesTagExist()
    {
        $uri = sprintf(GitHub::GITHUB_RELEASES_ENDPOINT, self::TARGET_CLEAN, self::TAG);
        $this->guzzle->get($uri, [
            'http_errors' => false,
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->willReturn(new Response);

        $this->github->___setProperty('client', $this->guzzle->reveal());

        $this->assertTrue($this->github->doesTagExist(self::TARGET, self::TAG));
    }

    public function testDoesTagExistReturnFalse()
    {
        $uri = sprintf(GitHub::GITHUB_RELEASES_ENDPOINT, self::TARGET_CLEAN, self::TAG);
        $this->guzzle->get($uri, [
            'http_errors' => false,
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->willReturn(new Response(404));

        $this->github->___setProperty('client', $this->guzzle->reveal());

        $this->assertFalse($this->github->doesTagExist(self::TARGET, self::TAG));
    }

    public function testCreateRelease()
    {
        $uri = sprintf(GitHub::GITHUB_RELEASE_CREATE_ENDPOINT, self::TARGET_CLEAN);
        $this->guzzle->post($uri, [
            'http_errors' => false,
            'json' => [
                'tag_name' => self::TAG,
                'name' => 'foo',
                'body' => 'bar'
            ],
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->willReturn(new Response);

        $uri = sprintf(GitHub::GITHUB_RELEASES_ENDPOINT, self::TARGET_CLEAN, self::TAG);
        $this->guzzle->get($uri, [
            'http_errors' => false,
            'auth' => [null, self::TOKEN]
        ])->shouldBeCalled()->willReturn(new Response(200));

        $this->github->___setProperty('client', $this->guzzle->reveal());

        $this->assertTrue($this->github->createRelease(self::TARGET, self::TAG, 'foo', 'bar'));
    }

    public function testPush()
    {
        $cmd = sprintf(
            'git push -q https://%s@github.com/%s %s:%s --force',
            self::TOKEN,
            self::TARGET,
            'foo',
            'master'
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

    public function testPushNoForce()
    {
        $cmd = sprintf(
            'git push -q https://%s@github.com/%s %s:%s',
            self::TOKEN,
            self::TARGET,
            'foo',
            'master'
        );

        $this->shell->execute($cmd)->shouldBeCalled()->willReturn([true]);

        $this->github->___setProperty('shell', $this->shell->reveal());

        $this->github->push(self::TARGET, 'foo', 'master', false);
    }
}
