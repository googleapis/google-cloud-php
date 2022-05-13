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

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 */
class RequestBuilderTest extends TestCase
{
    use ExpectException;

    public function set_up()
    {
        $this->builder = new RequestBuilder(
            Fixtures::SERVICE_FIXTURE(),
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
            Fixtures::SERVICE_FIXTURE(),
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
            Fixtures::SERVICE_FIXTURE(),
            'http://www.example.com/',
            ['resources', 'projects', 'otherThing']
        );

        $parameters = [
            'queryParam' => 'query',
            'pathParam' => 'path',
            'referenceProp' => 'reference'
        ];

        $request = $builder->build(
            'myOtherResource.resources.evenMoreNestedThing',
            'evenMoreNestedResource',
            $parameters
        );
        $uri = $request->getUri();

        $this->assertEquals('/path', $uri->getPath());
        $this->assertEquals('queryParam=query', $uri->getQuery());
        $this->assertEquals('{"referenceProp":"reference"}', (string) $request->getBody());
    }

    /**
     * @dataProvider basePaths
     */
    public function testAppendsBasePathToApiEndpoint($basePath, $baseUri, $expectedBaseUri)
    {
        $builder = TestHelpers::stub(RequestBuilder::class, [
            $basePath ? Fixtures::SERVICE_FIXTURE_BASEPATH() : Fixtures::SERVICE_FIXTURE(),
            $baseUri
        ], ['service']);

        if ($basePath) {
            $service = $builder->___getProperty('service');
            $service['basePath'] = $basePath;
            $builder->___setProperty('service', $service);
        }

        $request = $builder->build(
            'myResource',
            'myMethod',
            ['pathParam' => 'path']
        );
        $uri = $request->getUri();

        $this->assertEquals($expectedBaseUri . 'path', (string) $request->getUri());
    }

    public function basePaths()
    {
        return [
            [false, 'http://example.com', 'http://example.com/'],
            [true, 'http://example.com', 'http://example.com/basepath/v1/'],
            [true, 'http://example.com/', 'http://example.com/basepath/v1/'],
            [true, 'http://example.com/otherbase/v1/', 'http://example.com/otherbase/v1/'],
            [false, 'http://example.com/otherbase/v1/', 'http://example.com/otherbase/v1/'],
        ];
    }

    public function testThrowsExceptionWithNonExistantMethod()
    {
        $this->expectException('InvalidArgumentException');

        $this->builder->build('myResource', 'doesntExist');
    }
}
