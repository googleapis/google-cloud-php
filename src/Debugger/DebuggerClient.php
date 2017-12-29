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
    use ClientTrait;

    const VERSION = '0.1.0';
    const DEFAULT_AGENT_VERSION = 'google.com/gcp-php/v0.1';

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

    /**
     * Lazily instantiate a debuggee. There are no network requests made at this
     * point. To see the operations that can be performed on a debuggee, please
     * see {@see Google\Cloud\Debugger\Debuggee}.
     *
     * Example:
     * ```
     * $debuggee = $client->debuggee();
     * $debuggee->register();
     * ```
     *
     * ```
     * $debuggee = $client->debuggee('debuggee-id');
     * ```
     *
     * @param string $id The debuggee identifier
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $uniquifier Debuggee uniquifier within the project. Any
     *            string that identifies the application within the project can
     *            be used. Including environment and version or build IDs is
     *            recommended.
     *      @type string $description Human readable description of the
     *            debuggee. Including a human-readable project name, environment
     *            name and version information is recommended.
     *      @type string $isInactive If set to true, indicates that the debuggee
     *            is considered as inactive by the Controller service.
     *      @type string $status Human readable message to be displayed to the
     *            user about this debuggee. Absence of this field indicates no
     *            status. The message can be either informational or an error
     *            status.
     *      @type ExtendedSourceContext[] $extSourceContexts References to the locations and
     *            revisions of the source code used in the deployed application.
     * }
     * @return Debuggee
     */
    public function debuggee($id = null, array $options = [])
    {
        return new Debuggee($this->connection, [
            'id' => $id,
            'project' => $this->projectId,
            'agentVersion' => self::DEFAULT_AGENT_VERSION
        ] + $options);
    }

    /**
     * Fetches all the debuggees in the project.
     *
     * Example:
     * ```
     * $debuggees = $client->debuggees();
     * ```
     *
     * @return Debuggee[]
     */
    public function debuggees(array $extras = [])
    {
        $res = $this->connection->listDebuggees(['projectId' => $this->projectId] + $extras);
        if (is_array($res) && array_key_exists('debuggees', $res)) {
            return array_map(function ($info) {
                return new Debuggee($this->connection, $info);
            }, $res['debuggees']);
        }
        return [];
    }
}
