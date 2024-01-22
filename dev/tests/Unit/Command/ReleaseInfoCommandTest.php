<?php
/**
 * Copyright 2023 Google LLC
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

use Google\Cloud\Dev\Command\ReleaseInfoCommand;
use Google\Cloud\Dev\Composer;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group dev
 */
class ReleaseInfoCommandTest extends TestCase
{
    use ProphecyTrait;

    private static array $mockResponse = [
        'body' => '<details><summary>google\/cloud-billing-budgets: 1.2.0<\/summary>' .
            '### Features\r\n\r\n* Add resource_ancestors field to support filtering by folders & organizations ' .
            '([#6320](https:\/\/github.com\/googleapis\/google-cloud-php\/issues\/6320))<\/details>' .
            '<details><summary>google\/cloud-build: 0.7.2<\/summary><\/details>' .
            '\r\n\r\n---\r\nThis PR was generated with Release Please.',
    ];

    public function testReleaseInfo()
    {
        $tag = 'v0.1000.0';
        $body = $this->prophesize(StreamInterface::class);
        $body->__toString()
            ->shouldBeCalledOnce()
            ->willReturn(json_encode(self::$mockResponse));
        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()
            ->shouldBeCalledOnce()
            ->willReturn($body->reveal());
        $response->getStatusCode()
            ->shouldBeCalledOnce()
            ->willReturn(200);
        $http = $this->prophesize(Client::class);
        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases/tags/' . $tag,
            ['auth' => [null, null]]
        )
            ->shouldBeCalledTimes(2)
            ->willReturn($response->reveal());

        $commandTester = new CommandTester(new ReleaseInfoCommand($http->reveal()));
        $commandTester->execute(['tag' => $tag, '--format' => 'json']);

        $display = $commandTester->getDisplay();
        $json = json_decode($display, true);

        $this->assertArrayHasKey('version', $json);
        $this->assertEquals($tag, $json['version']);
        $this->assertArrayHasKey('releases', $json);
        $this->assertCount(2, $json['releases']);
        $this->assertEquals([
            'component' => 'BillingBudgets',
            'id' => 'cloud-billing-budgets',
            'version' => '1.2.0'
        ], $json['releases'][0]);
        $this->assertEquals([
            'component' => 'Build',
            'id' => 'cloud-build',
            'version' => '0.7.2'
        ], $json['releases'][1]);
    }

    public function testReleaseInfoFromAndSqlFormat()
    {
        $tag = 'v0.2000.0';
        $tagBody = $this->prophesize(StreamInterface::class);
        $tagBody->__toString()
            ->shouldBeCalledOnce()
            ->willReturn(json_encode(self::$mockResponse));
        $tagResponse = $this->prophesize(ResponseInterface::class);
        $tagResponse->getBody()
            ->shouldBeCalledOnce()
            ->willReturn($tagBody->reveal());
        $tagResponse->getStatusCode()
            ->shouldBeCalledOnce()
            ->willReturn(200);
        $releaseBody = $this->prophesize(StreamInterface::class);
        $releaseBody->__toString()
            ->shouldBeCalledOnce()
            ->willReturn(json_encode([
                ['tag_name' => 'v0.2000.0', 'published_at' => '2024-01-21T19:35:32Z'],
                ['tag_name' => 'v0.1000.0', 'published_at' => "2013-02-27T19:35:32Z"]
            ]));
        $releaseResponse = $this->prophesize(ResponseInterface::class);
        $releaseResponse->getBody()
            ->shouldBeCalledOnce()
            ->willReturn($releaseBody->reveal());
        $http = $this->prophesize(Client::class);
        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases',
            ['auth' => [null, null]]
        )
            ->shouldBeCalledOnce()
            ->willReturn($releaseResponse->reveal());
        $http->get(
            'https://api.github.com/repos/googleapis/google-cloud-php/releases/tags/' . $tag,
            ['auth' => [null, null]]
        )
            ->shouldBeCalledTimes(2)
            ->willReturn($tagResponse->reveal());

        $commandTester = new CommandTester(new ReleaseInfoCommand($http->reveal()));
        $commandTester->execute(['--from' => '2024-01-01', '--format' => 'sql']);

        $display = $commandTester->getDisplay();
        $lines = explode("\n", trim($display));

        $this->assertCount(2, $lines);
        $this->assertEquals(
            '(service_name = "billingbudgets" and client_library_version = "1.2.0")',
            $lines[0]
        );
        $this->assertEquals(
            'OR (service_name = "cloudbuild" and client_library_version = "0.7.2")',
            $lines[1]
        );
    }
}
