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

namespace Google\Gcloud\Tests;

use Google\Gcloud\HttpRequestWrapper;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;

class HttpRequestWrapperTest extends \PHPUnit_Framework_TestCase
{
    public function testSignRequestCanCheckTheExistingCredentialsExpiry()
    {
        $request = $this->getMock(RequestInterface::class);
        $request->method('getUri')->willReturn('/');
        $request->method('getHeaders')->willReturn([]);

        $wrapper = new HttpRequestWrapper();
        $refl = new \ReflectionClass($wrapper);

        $token = 'some_generated_token';
        $credentials = $refl->getProperty('credentials');
        $credentials->setAccessible(true);
        $credentials->setValue($wrapper, [
            'expiry' => strtotime('+300 seconds'),
            'access_token' => $token
        ]);

        $signedRequest = $wrapper->signRequest($request);

        $header = $signedRequest->getHeader('Authorization')[0];

        $this->assertEquals("Bearer $token", $header);
    }
}
