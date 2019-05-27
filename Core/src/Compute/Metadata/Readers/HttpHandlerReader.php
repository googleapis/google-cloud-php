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

namespace Google\Cloud\Core\Compute\Metadata\Readers;

use Google\Auth\Credentials\GCECredentials;
use Google\Auth\HttpHandler\HttpClientCache;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\Psr7\Request;

/**
 * Read Compute Metadata using the HTTP Handler utility.
 */
class HttpHandlerReader implements ReaderInterface
{
    /**
     * @var callable
     */
    private $httpHandler;

    /**
     * @param callable $httpHandler [optional] An HTTP Handler capable of
     *        accepting PSR7 requests and returning PSR7 responses.
     */
    public function __construct(callable $httpHandler = null)
    {
        $this->httpHandler = $httpHandler
            ?: HttpHandlerFactory::build(HttpClientCache::getHttpClient());
    }

    /**
     * Read the metadata for a given path.
     *
     * @param string $path The metadata path, relative to `/computeMetadata/v1/`.
     * @return string
     */
    public function read($path)
    {
        $url = sprintf(
            'http://%s/computeMetadata/v1/%s',
            GCECredentials::METADATA_IP,
            $path
        );

        $request = new Request('GET', $url, [
            GCECredentials::FLAVOR_HEADER => 'Google'
        ]);

        $handler = $this->httpHandler;
        $res = $handler($request);

        return (string) $res->getBody();
    }
}
