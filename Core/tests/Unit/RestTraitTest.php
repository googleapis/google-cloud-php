<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group core
 */
class RestTraitTest extends TestCase
{
    use AssertStringContains;

    private $implementation;
    private $requestBuilder;
    private $requestWrapper;

    public function set_up()
    {
        $this->implementation = $this->getObjectForTrait(RestTrait::class);
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->requestBuilder = $this->prophesize(RequestBuilder::class);
        $this->requestBuilder->build(Argument::cetera())
            ->willReturn(new Request('GET', '/someplace'));
    }

    public function testSetGetRequestWrapper()
    {
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $this->assertInstanceOf(RequestWrapper::class, $this->implementation->requestWrapper());
    }

    public function testSendsRequest()
    {
        $responseBody = '{"whatAWonderful": "response"}';
        $this->requestWrapper->send(Argument::cetera())
            ->willReturn(new Response(200, [], $responseBody));

        $this->implementation->setRequestBuilder($this->requestBuilder->reveal());
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send('resource', 'method');

        $this->assertEquals(json_decode($responseBody, true), $actualResponse);
    }

    public function testSendsRequestWithOptions()
    {
        $restOptions = [
            'restOptions' => ['debug' => true],
            'retries' => 5,
            'requestTimeout' => 3.5
        ];
        $responseBody = '{"whatAWonderful": "response"}';
        $this->requestWrapper->send(Argument::any(), $restOptions)
            ->willReturn(new Response(200, [], $responseBody));

        $this->implementation->setRequestBuilder($this->requestBuilder->reveal());
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send('resource', 'method', $restOptions);

        $this->assertEquals(json_decode($responseBody, true), $actualResponse);
    }

    public function testSendsRequestNotFoundWhitelisted()
    {
        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willThrow(new NotFoundException('uh oh'));

        $this->implementation->setRequestBuilder($this->requestBuilder->reveal());
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());

        $msg = null;
        try {
            $this->implementation->send('foo', 'bar', [], true);
        } catch (NotFoundException $e) {
            $msg = $e->getMessage();
        }

        $this->assertStringContainsString('NOTE: Error may be due to Whitelist Restriction.', $msg);
    }

    public function testSendsRequestNotFoundNotWhitelisted()
    {
        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willThrow(new NotFoundException('uh oh'));

        $this->implementation->setRequestBuilder($this->requestBuilder->reveal());
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());

        $msg = null;
        try {
            $this->implementation->send('foo', 'bar', [], false);
        } catch (NotFoundException $e) {
            $msg = $e->getMessage();
        }

        $this->assertStringNotContainsString('NOTE: Error may be due to Whitelist Restriction.', $msg);
    }

    /**
     * @dataProvider endpoints
     */
    public function testGetApiEndpoint($input = null, $expected = null)
    {
        $default = 'https://foobar.com/';

        $config = [];
        if ($input) {
            $config['apiEndpoint'] = $input;
        }

        $this->assertEquals(
            $expected ?: $input ?: $default,
            TestHelpers::impl(RestTrait::class)->call('getApiEndpoint', [$default, $config])
        );
    }

    public function testAppendsPrettyPrintParameter()
    {
        $requestBuilder = $this->prophesize(RequestBuilder::class);
        $requestBuilder->build(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('array')
        )->will(function ($args) {
            $query = isset($args[2]['prettyPrint'])
                ? '?prettyPrint=' . ($args[2]['prettyPrint'] ? 'true' : 'false')
                : '';
            return new Request('GET', "/someplace$query");
        });
        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->will(function ($args) {
            return new Response(200, [], '"' . $args[0]->getUri()->getQuery() . '"');
        });
        $this->implementation->setRequestBuilder($requestBuilder->reveal());
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $this->assertEquals('prettyPrint=false', $this->implementation->send('foo', 'bar', []));
    }

    public function endpoints()
    {
        return [
            [], // use default.
            ['helloworld.com', 'https://helloworld.com/'],
            ['https://helloworld.com', 'https://helloworld.com/'],
            ['https://helloworld.com/'],
            ['helloworld.com:443', 'https://helloworld.com:443/'],
            ['hello.world.com', 'https://hello.world.com/'],
            ['hello.world.com:443', 'https://hello.world.com:443/'],
        ];
    }
}
