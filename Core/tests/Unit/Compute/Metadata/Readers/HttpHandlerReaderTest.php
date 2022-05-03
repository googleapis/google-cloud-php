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

namespace Google\Cloud\Core\Tests\Unit\Compute\Metadata\Readers;

use Google\Auth\Credentials\GCECredentials;
use Google\Cloud\Core\Compute\Metadata\Readers\HttpHandlerReader;
use Google\Cloud\Core\Testing\TestHelpers;
use GuzzleHttp\Psr7\Response;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @group core
 * @group core-compute
 */
class HttpHandlerReaderTest extends TestCase
{
    private $reader;
    private $handler;

    public function set_up()
    {
        $this->reader = TestHelpers::stub(HttpHandlerReader::class, [], [
            'httpHandler'
        ]);
    }

    public function testRead()
    {
        $path = 'foo/bar';
        $expectedResponse = 'hello world';

        $httpHandler = function (RequestInterface $request) use ($path, $expectedResponse) {
            $expectedUrl = sprintf(
                'http://%s/computeMetadata/v1/%s',
                GCECredentials::METADATA_IP,
                $path
            );

            $this->assertEquals($expectedUrl, (string) $request->getUri());
            $this->assertEquals('Google', $request->getHeaderLine(GCECredentials::FLAVOR_HEADER));

            return new Response(200, [], $expectedResponse);
        };

        $this->reader->___setProperty('httpHandler', $httpHandler);

        $this->assertEquals($expectedResponse, $this->reader->read($path));
    }
}
