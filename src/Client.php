<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
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

namespace Google\Cloud;

use Google\Cloud\Storage\Connection\REST;
use Google\Cloud\Storage\StorageClient;

class Client
{
    const VERSION = '0.0.0';

    /**
     * @var array Configuration details to be used between clients.
     */
    private $config;

    /**
     * Pass in an array of configuration parameters to construct your client.
     *
     * Example:
     * ```
     * $client = new Client([
     *     'keyFilePath' => '/path/to/key/file.json',
     *     'projectId' => 'myAwesomeProject'
     * ]);
     * ```
     *
     * @param array $config Configuration options. {
     *     @type callable $httpHandler Override the default http handler.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developers Console.
     *     @type string $projectId The project ID created in the Google
     *           Developers Console.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @return StorageClient
     */
    public function storage()
    {
        // @todo should projectId be required?
        if (!array_key_exists('projectId', $this->config)) {
            return \InvalidArgumentException('projectId is required.');
        }

        $connection = new REST($this->config);
        return new StorageClient($connection, $this->config['projectId']);
    }
}
