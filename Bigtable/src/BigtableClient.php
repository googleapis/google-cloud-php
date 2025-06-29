<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable;

use Google\ApiCore\ArrayTrait;
use Google\ApiCore\ClientOptionsTrait;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Serializer;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\RestTransport;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Bigtable\V2\Client\BigtableClient as GapicClient;
use Google\Cloud\Bigtable\V2\PingAndWarmRequest;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\DetectProjectIdTrait;

/**
 * Google Cloud Bigtable is Google's NoSQL Big Data database service.
 * Find more information at the
 * [Google Cloud Bigtable Docs](https://cloud.google.com/bigtable/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\BigtableClient;
 *
 * $bigtable = new BigtableClient();
 * ```
 */
class BigtableClient
{
    use ArrayTrait;
    use DetectProjectIdTrait;
    use ClientOptionsTrait;
    use ApiHelperTrait;

    // The name of the service. Used in debug logging.
    private const SERVICE_NAME = 'google.bigtable.v2.Bigtable';

    /**
     * @var GapicClient
     */
    private $gapicClient;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * Invoke {@see GapicClient::pingAndWarm()} when {@see self::table()} is called
     * in order to establish a persistent gRPC channel before making an RPC call.
     *
     * @experimental
     * @var bool
     */
    private $pingAndWarm;

    /**
     * An in-memory array to ensure pingAndWarm is only called once per instance.
     *
     * @experimental
     * @var array
     */
    private $pingAndWarmCalled = [];

    /**
     * Create a Bigtable client.
     *
     * @param array $config [optional] {
     *     Configuration options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type string $apiEndpoint The address of the API remote host. May
     *           optionally include the port, formatted as "<uri>:<port>".
     *           **Defaults to** 'bigtable.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls.
     *           This option accepts either a path to a credentials file, or a
     *           decoded credentials file as a PHP array.
     *           *Advanced usage*: In addition, this option can also accept a
     *           pre-constructed {@see FetchAuthTokenInterface} object
     *           or {@see CredentialsWrapper} object. Note that when one of
     *           these objects are provided, any settings in
     *           `$config['credentialsConfig']` will be ignored.
     *     @type array $credentialsConfig Options used to configure credentials,
     *           including auth token caching, for the client. For a full list of
     *           supporting configuration options, see {@see CredentialsWrapper}.
     *     @type bool $disableRetries Determines whether or not retries defined by
     *           the client configuration should be disabled. **Defaults to**
     *           `false`.
     *     @type string|array $clientConfig Client method configuration, including
     *           retry settings. This option can be either a path to a JSON file, or
     *           a PHP array containing the decoded JSON data.
     *     @type string|TransportInterface $transport The transport used for
     *           executing network requests. May be either the string `rest` or
     *           `grpc`. **Defaults to** `grpc` if gRPC support is detected on
     *           the system. *Advanced usage*: Additionally, it is possible to
     *           pass in an already instantiated {@see TransportInterface}
     *           object. Note that when this object is provided, any settings in
     *           $config['transportConfig'] and the $config['apiEndpoint']
     *           setting will be ignored.
     *     @type array $transportConfig Configuration options that will be used to
     *           construct the transport. Options for each supported transport type
     *           should be passed in a key for that transport. For example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the `build` method on {@see GrpcTransport} and
     *           {@see RestTransport} for the supported options.
     *     @type string $quotaProject Specifies a user project to bill for
     *           access charges associated with the request.
     *     @type bool $pingAndWarm EXPERIMENTAL When true, calls the
     *           {@see GapicClient::pingAndWarm()} RPC to establish a persistent
     *           gRPC channel before making an RPC call.
     * }
     * @throws ValidationException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['transportConfig']['grpc']['stubOpts'])) {
            $config['transportConfig']['grpc']['stubOpts'] = [];
        }

        // Workaround for large messages.
        $config['transportConfig']['grpc']['stubOpts'] += [
            'grpc.max_send_message_length' => -1,
            'grpc.max_receive_message_length' => -1,
            // Sets 30s as Google Frontends allows keepalive pings at 30s
            'grpc.keepalive_time_ms' => 30000,
            // Conservative timeout at 10s
            'grpc.keepalive_timeout_ms' => 10000
        ];

        // Configure GAPIC client options
        $detectProjectIdConfig = $this->buildClientOptions($config);
        $detectProjectIdConfig['credentials'] = $this->createCredentialsWrapper(
            $detectProjectIdConfig['credentials'],
            $detectProjectIdConfig['credentialsConfig'],
            $detectProjectIdConfig['universeDomain']
        );

        $this->projectId = $this->detectProjectId($detectProjectIdConfig);
        $this->serializer = new Serializer();
        $this->pingAndWarm = $config['pingAndWarm'] ?? false;
        $this->gapicClient = new GapicClient($config);
    }

    /**
     * Returns a table instance which can be used to read rows and to perform
     * insert, update, and delete operations.
     *
     * Example:
     * ```
     * $table = $bigtable->table('my-instance', 'my-table');
     * ```
     *
     * @param string $instanceId The instance ID.
     * @param string $tableId The table ID.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $appProfileId This value specifies routing for
     *           replication. **Defaults to** the "default" application profile.
     *     @type array $headers Headers to be passed with each request.
     * }
     * @return Table
     */
    public function table($instanceId, $tableId, array $options = [])
    {
        if ($this->pingAndWarm && !($this->pingAndWarmCalled[$instanceId] ?? false)) {
            // The default deadline is configured by the "clientConfig" option, which uses
            // `src/V2/resources/bigtable_client_config.json`.
            // This default deadline should be high enough to absorb cold connection latencies.
            list($data, $callOptions) = $this->splitOptionalArgs($options);
            $data['name'] = GapicClient::instanceName($this->projectId, $instanceId);
            $request = $this->serializer->decodeMessage(new PingAndWarmRequest(), $data);
            $this->gapicClient->pingAndWarm($request, $callOptions);
            $this->pingAndWarmCalled[$instanceId] = true;
        }

        return new Table(
            $this->gapicClient,
            $this->serializer,
            GapicClient::tableName($this->projectId, $instanceId, $tableId),
            $options
        );
    }
}
