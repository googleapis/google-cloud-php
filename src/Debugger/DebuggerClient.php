<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Debugger;

use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Debugger\Connection\ConnectionInterface;
use Google\Cloud\Debugger\Connection\Rest;

/**
 * Google Stackdriver Debugger allows you to collect variable data from a live application
 * and display it in the Google Cloud Platform Console. Find more information at
 * [Stackdriver Debugger API docs](https://cloud.google.com/debugger/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\DebuggerClient;
 *
 * $debugger = new DebuggerClient();
 * ```
 */
class DebuggerClient
{
    use ArrayTrait;
    use ClientTrait;

    const VERSION = '0.1.0';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';
    const READ_ONLY_SCOPE = 'https://www.googleapis.com/auth/debugger.readonly';

    /**
     * @var ConnectionInterface $connection Represents a connection to Debugger
     */
    protected $connection;

    /**
     * Create a Debugger client.
     *
     * @param array $config [optional] {
     *     Configuration options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache used storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     * }
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }
}
