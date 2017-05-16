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
use Prophecy\Argument;

/**
 * @group core
 */
class RequestBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->builder = new RequestBuilder(
            __DIR__ . '/../fixtures/service-fixture.json',
            'http://www.example.com/'
        );
    }

    public function testBuildsRequest()
    {
        $parameters = [
            'queryParam' => 'query',
            'pathParam' => 'path',
            'referenceProp' => 'reference',
            'repeatedParam' => ['foo','bar']
        ];

        $request = $this->builder->build('myResource', 'myMethod', $parameters);
        $uri = $request->getUri();

        $this->assertEquals('/path', $uri->getPath());
        $this->assertEquals('queryParam=query&repeatedParam=foo&repeatedParam=bar', $uri->getQuery());
        $this->assertEquals('{"referenceProp":"reference"}', (string) $request->getBody());
    }

    public function testBuildsNestedRequest()
    {
        $builder = new RequestBuilder(
            __DIR__ . '/../fixtures/service-fixture.json',
            'http://www.example.com/',
            ['resources', 'projects', 'otherThing']
        );

        $parameters = [
            'queryParam' => 'query',
            'pathParam' => 'path',
            'referenceProp' => 'reference'
        ];

        $request = $builder->build('myOtherResource', 'myOtherMethod', $parameters);
        $uri = $request->getUri();

        $this->assertEquals('/path', $uri->getPath());
        $this->assertEquals('queryParam=query', $uri->getQuery());
        $this->assertEquals('{"referenceProp":"reference"}', (string) $request->getBody());
    }

    public function testBuildsNestedRequestWithStringSplitting()
    {
        $builder = new RequestBuilder(
            __DIR__ . '/../fixtures/service-fixture.json',
            'http://www.example.com/',
            ['resources', 'projects', 'otherThing']
        );

        $parameters = [
            'queryParam' => 'query',
            'pathParam' => 'path',
            'referenceProp' => 'reference'
        ];

        $request = $builder->build('myOtherResource.resources.evenMoreNestedThing', 'evenMoreNestedResource', $parameters);
        $uri = $request->getUri();

        $this->assertEquals('/path', $uri->getPath());
        $this->assertEquals('queryParam=query', $uri->getQuery());
        $this->assertEquals('{"referenceProp":"reference"}', (string) $request->getBody());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionWithNonExistantMethod()
    {
        $this->builder->build('myResource', 'doesntExist');
    }
}
