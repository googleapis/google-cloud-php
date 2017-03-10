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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;

/**
 * @group core
 */
class RestTraitTest extends \PHPUnit_Framework_TestCase
{
    private $implementation;
    private $requestBuilder;
    private $requestWrapper;

    public function setUp()
    {
        $this->implementation = $this->getObjectForTrait(RestTrait::class);
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->requestBuilder = $this->prophesize(RequestBuilder::class);
        $this->requestBuilder->build(Argument::cetera())
            ->willReturn(new Request('GET', '/someplace'));
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
        $httpOptions = [
            'httpOptions' => ['debug' => true],
            'retries' => 5
        ];
        $responseBody = '{"whatAWonderful": "response"}';
        $this->requestWrapper->send(Argument::any(), $httpOptions)
            ->willReturn(new Response(200, [], $responseBody));

        $this->implementation->setRequestBuilder($this->requestBuilder->reveal());
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send('resource', 'method', $httpOptions);

        $this->assertEquals(json_decode($responseBody, true), $actualResponse);
    }
}
