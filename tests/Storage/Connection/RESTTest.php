<?php

/**
 * Copyright 2015 Google Inc.
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

namespace Google\Gcloud\Tests\Storage\Connection;

use Google\Gcloud\HttpRequestWrapper;
use Google\Gcloud\Storage\Connection\REST;
use Psr\Http\Message\ResponseInterface;

class RESTTest extends \PHPUnit_Framework_TestCase
{
    public function testGetObjectReturnsResponseArray()
    {
        $response = $this->getMock(ResponseInterface::class);
        $response->method('getBody')->willReturn('{"name": "foo.txt"}');

        $wrapper = $this->getMock(HttpRequestWrapper::class);
        $wrapper->method('send')->willReturn($response);

        $object = (new REST($wrapper))->getObject();

        $this->assertEquals(['name' => 'foo.txt'], $object);
    }
}
