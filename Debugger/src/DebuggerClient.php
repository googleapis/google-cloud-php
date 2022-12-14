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
use Google\Cloud\Debugger\Connection\Grpc;
use Google\Cloud\Debugger\Connection\Rest;
use Psr\Cache\CacheItemPoolInterface;

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

    const VERSION = '1.4.12';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';
    const READ_ONLY_SCOPE = 'https://www.googleapis.com/auth/debugger.readonly';

    /**
     * @var ConnectionInterface $connection Represents a connection to Debugger
     */
    protected $connection;

    /**
     * Returns the default Agent version string
     *
     * @return string
     */
    public static function getDefaultAgentVersion()
    {
        return 'google.com/gcp-php/' . self::VERSION;
    }

    /**
     * Create a Debugger client.
     *
     * @param array $config [optional] {
     *     Configuration options.
     *
     *     @type string $apiEndpoint A hostname with optional port to use in
     *           place of the service's default endpoint.
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
     *     @type string $quotaProject Specifies a user project to bill for
     *           access charges associated with the request.
     * }
     */
    public function __construct(array $config = [])
    {
        $connectionType = $this->getConnectionType($config);
        $config += [
            'scopes' => [self::FULL_CONTROL_SCOPE],
            'projectIdRequired' => true,
            'preferNumericProjectId' => true
        ];
        $this->connection = $connectionType === 'grpc'
            ? new Grpc($this->configureAuthentication($config))
            : new Rest($this->configureAuthentication($config));
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
     *      @type ExtendedSourceContext[] $extSourceContexts References to the
     *            locations and revisions of the source code used in the
     *            deployed application.
     * }
     * @return Debuggee
     */
    public function debuggee($id = null, array $options = [])
    {
        return new Debuggee($this->connection, [
            'id' => $id,
            'project' => $this->projectId,
            'agentVersion' => self::getDefaultAgentVersion()
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
     * @see https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees/list debugger.debuggees.list
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $includeInactive When set to `true`, the result includes
     *           all debuggees. Otherwise, the result includes only debuggees
     *           that are active.
     *     @type string $clientVersion The client version making the call.
     *           Schema: `domain/type/version` (e.g., `google.com/intellij/v1`).
     * }
     * @return Debuggee[]
     */
    public function debuggees(array $options = [])
    {
        $options += [
            'clientVersion' => self::getDefaultAgentVersion()
        ];

        $res = $this->connection->listDebuggees(['project' => $this->projectId] + $options);

        $debuggees = [];
        if (is_array($res) && isset($res['debuggees'])) {
            foreach ($res['debuggees'] as $debuggee) {
                $debuggees[] = new Debuggee($this->connection, $debuggee);
            }
        }

        return $debuggees;
    }
}
