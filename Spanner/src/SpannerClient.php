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

namespace Google\Cloud\Spanner;

use Google\ApiCore\ClientOptionsTrait;
use Google\ApiCore\Middleware\MiddlewareInterface;
use Google\ApiCore\Options\CallOptions;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\DetectProjectIdTrait;
use Google\Cloud\Core\EmulatorTrait;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningClientConnection;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\OptionsValidator;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\ListInstanceConfigOperationsRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\ListInstanceConfigsRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\ListInstancesRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\ReplicaInfo;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Middleware\SpannerMiddleware;
use Google\Cloud\Spanner\V1\Client\SpannerClient as GapicSpannerClient;
use Google\Cloud\Spanner\V1\TransactionOptions\IsolationLevel;
use Google\LongRunning\Operation as OperationProto;
use Google\Protobuf\Duration;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Cloud Spanner is a highly scalable, transactional, managed, NewSQL
 * database service. Find more information at
 * [Cloud Spanner docs](https://cloud.google.com/spanner/).
 *
 * In production environments, it is highly recommended that you make use of the
 * Protobuf PHP extension for improved performance. Protobuf can be installed
 * via [PECL](https://pecl.php.net).
 *
 * ```
 * $ pecl install protobuf
 * ```
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 * ```
 *
 * ```
 * // Using a Spanner Emulator
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * // Be sure to use the port specified when starting the emulator.
 * // `9010` is used as an example only.
 * putenv('SPANNER_EMULATOR_HOST=localhost:9010');
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 * ```
 *
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 * use Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type as ReplicaType;
 *
 * $config = [
 *     'projectId' => 'my-project',
 *     'directedReadOptions' => [
 *         'includeReplicas' => [
 *             'replicaSelections' => [
 *                 [
 *                     'location' => 'us-central1',
 *                     'type' => ReplicaType::READ_WRITE
 *                 ]
 *             ],
 *             'autoFailoverDisabled' => false
 *         ]
 *     ]
 * ];
 * $spanner = new SpannerClient($config);
 * ```
 *
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $config = ['projectId' => 'my-project', 'routeToLeader' => false];
 * $spanner = new SpannerClient($config);
 * ```
 */
class SpannerClient
{
    use DetectProjectIdTrait;
    use ClientOptionsTrait;
    use EmulatorTrait;
    use ApiHelperTrait;
    use RequestTrait;

    const VERSION = '2.0.0-RC1';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/spanner.data';
    const ADMIN_SCOPE = 'https://www.googleapis.com/auth/spanner.admin';

    private const SERVICE_NAME = 'google.spanner.v1.Spanner';

    private GapicSpannerClient $spannerClient;
    private InstanceAdminClient $instanceAdminClient;
    private DatabaseAdminClient $databaseAdminClient;
    private Serializer $serializer;
    private string $projectName;
    private bool $returnInt64AsObject;
    private array $directedReadOptions;
    private bool $routeToLeader;
    private array $defaultQueryOptions;
    private int $isolationLevel;
    private CacheItemPoolInterface|null $cacheItemPool;

    /**
     * Create a Spanner client. Please note that this client requires
     * [the gRPC extension](https://cloud.google.com/php/grpc).
     *
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $projectId The Google Cloud project ID.
     *     @type string $apiEndpoint A hostname with optional port to use in
     *           place of the service's default endpoint.
     *     @type CacheItemPoolInterface $credentialsConfig.authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $credentialsConfig.authCacheOptions Cache configuration options.
     *     @type callable $credentialsConfig.authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $transportConfig.rest.httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls.
     *     @type array $credentialsConfig.scopes Scopes to be used for the request.
     *     @type string $credentialsConfig.quotaProject Specifies a user project to bill for
     *           access charges associated with the request.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     *     @type array $queryOptions Query optimizer configuration.
     *     @type string $queryOptions.optimizerVersion An option to control the
     *           selection of optimizer version. This parameter allows
     *           all execute queries to use a specific query optimizer version.
     *           Specifying "latest" as a value instructs Cloud Spanner to use
     *           the latest supported query optimizer version.
     *           query-level values will take precedence over any global settings.
     *           If the SPANNER_OPTIMIZER_VERSION environment variable is set,
     *           it will take second priority. This value is used when neither a
     *           query-level value nor the environment variable is set.
     *           Any other positive integer (from the list of supported
     *           optimizer versions) overrides the default optimizer version for
     *           query execution. Executing a SQL statement with an invalid
     *           optimizer version will fail with a syntax error
     *           (`INVALID_ARGUMENT`) status.
     *     @type array $directedReadOptions Directed read options.
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions}
     *           If using the `replicaSelection::type` setting, utilize the constants available in
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type} to set a value.
     *     @type bool $routeToLeader Enable/disable Leader Aware Routing.
     *           **Defaults to** `true` (enabled).
     *     @type string $universeDomain The expected universe of the credentials. Defaults to
     *            "googleapis.com"
     *     @type int $isolationLevel The level of Isolation for the transactions executed by this Client's instance.
     *           **Defaults to** IsolationLevel::ISOLATION_LEVEL_UNSPECIFIED
     *     @type CacheItemPoolInterface $cacheItemPool
     * }
     * @throws GoogleException If the gRPC extension is not enabled.
     */
    public function __construct(array $options = [])
    {
        $emulatorHost = getenv('SPANNER_EMULATOR_HOST');

        $this->requireGrpc();
        $scopes = [self::FULL_CONTROL_SCOPE, self::ADMIN_SCOPE];
        $options += [
            'returnInt64AsObject' => false,
            'projectIdRequired' => true,
            'hasEmulator' => (bool) $emulatorHost,
            'emulatorHost' => $emulatorHost,
            'queryOptions' => [],
            'directedReadOptions' => [],
            'isolationLevel' => IsolationLevel::ISOLATION_LEVEL_UNSPECIFIED,
            'routeToLeader' => true,
            'cacheItemPool' => null,
        ];

        $this->returnInt64AsObject = $options['returnInt64AsObject'];
        $this->directedReadOptions = $options['directedReadOptions'];
        $this->routeToLeader = $options['routeToLeader'];
        $this->defaultQueryOptions = $options['queryOptions'];
        $this->isolationLevel = $options['isolationLevel'];

        // Configure GAPIC client options
        $options = $this->buildClientOptions($options);
        if (isset($options['credentialsConfig']['scopes'])) {
            $options['credentialsConfig']['scopes'] = array_merge(
                $options['credentialsConfig']['scopes'],
                $scopes
            );
        } else {
            $options['credentialsConfig']['scopes'] = $scopes;
        }

        if ($emulatorHost) {
            $emulatorConfig = $this->emulatorGapicConfig($emulatorHost);
            $options = array_merge(
                $options,
                $emulatorConfig
            );
        } else {
            $options['credentials'] = $this->createCredentialsWrapper(
                $options['credentials'],
                $options['credentialsConfig'],
                $options['universeDomain']
            );
        }
        $this->projectId = $this->detectProjectId($options);
        $this->serializer = new Serializer();
        $this->optionsValidator = new OptionsValidator($this->serializer);

        // Adds some defaults
        // gccl needs to be present for handwritten clients
        $clientOptions = $options += [
            'libName' => 'gccl',
            'serializer' => $this->serializer,
        ];
        $this->spannerClient = $options['gapicSpannerClient'] ?? new GapicSpannerClient($clientOptions);
        $this->instanceAdminClient = $options['gapicSpannerInstanceAdminClient']
            ?? new InstanceAdminClient($clientOptions);
        $this->databaseAdminClient = $options['gapicSpannerDatabaseAdminClient']
            ?? new DatabaseAdminClient($clientOptions);

        // Add the SpannerMiddleware, which wraps API Exceptions, and adds
        // Resource Prefix and LAR headers
        $middleware = function (MiddlewareInterface $handler) {
            return new SpannerMiddleware($handler);
        };
        $this->spannerClient->addMiddleware($middleware);
        $this->instanceAdminClient->addMiddleware($middleware);
        $this->databaseAdminClient->addMiddleware($middleware);

        $this->projectName = InstanceAdminClient::projectName($this->projectId);
        $this->cacheItemPool = $options['cacheItemPool'];
    }

    /**
     * Get a Batch Client.
     *
     * Batch Clients allow you to execute reads of very large data sets, spread
     * across multiple partitions.
     *
     * Example:
     * ```
     * $batch = $spanner->batch('instance-id', 'database-id');
     * ```
     *
     * Database role configured in the optional $options array
     * will be applied to the session created by this object.
     * ```
     * $batch = $spanner->batch('instance-id', 'database-id', ['databaseRole' => 'Reader']);
     * ```
     *
     * @param string $instanceId The instance to connect to.
     * @param string $databaseId The database to connect to.
     * @param array $options  [optional] {
     *     Configuration options.
     *
     *     @type string $databaseRole The user created database role which creates the session.
     * }
     * @return BatchClient
     */
    public function batch($instanceId, $databaseId, array $options = []): BatchClient
    {
        $operation = new Operation(
            $this->spannerClient,
            $this->serializer,
            [
                'routeToLeader' => $this->routeToLeader,
                'defaultQueryOptions' => $this->defaultQueryOptions,
                'returnInt64AsObject' => $this->returnInt64AsObject,
            ]
        );

        $database = $this->instance($instanceId)->database($databaseId, $options);

        return new BatchClient(
            $operation,
            $database->session(),
        );
    }

    /**
     * Create a new instance configuration.
     *
     * Example:
     * ```
     * use Google\Cloud\Spanner\Admin\Instance\V1\ReplicaInfo;
     *
     * $operation = $spanner->createInstanceConfiguration(
     *     $baseInstanceConfig,
     *     'custom-instance-config',
     *     // The replicas for the custom instance configuration must include all the replicas of the base
     *     // configuration, in addition to at least one from the list of optional replicas of the base
     *     // configuration.
     *     array_merge(
     *         $baseInstanceConfig->info()['replicas'],
     *         [
     *             new ReplicaInfo([
     *                 'location' => 'us-east1',
     *                 'type' => ReplicaInfo\ReplicaType::READ_ONLY,
     *                 'defaultLeaderLocation' => false
     *             ])
     *         ]
     *     ),
     *     [
     *         'displayName' => 'This is a display name',
     *         'labels' => ['cloud_spanner_samples' => true]
     *     ]
     * );
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#createinstanceconfigrequest CreateInstanceConfigRequest
     *
     * @param InstanceConfiguration $baseConfig The base configuration to extend for this custom instance configuration.
     * @param string $name The configuration name. Should be prefixed with "custom-".
     * @param ReplicaInfo[]|array $replicas The replica information for the new instance configuration. This array must
     *           contain all the replicas from the base configuration, plus at least one from list of optional replicas
     *           of the base configuration. One of the replicas must be set as the default leader location.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $displayName **Defaults to** the value of $name.
     *     @type array $leaderOptions Allowed values of the "default_leader" schema option for databases in
     *           instances that use this instance configuration. **Defaults to** the leader options of the base
     *           configuration. Please note it may be possible for the default value to be an empty array when
     *           lazy loading the base configuration. To ensure the default value matches the upstream values
     *           please make sure to trigger a network request on the base configuration with either
     *           {@see InstanceConfiguration::reload()} or {@see InstanceConfiguration::info()}.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://cloudplatform.googleblog.com/2015/10/using-labels-to-organize-Google-Cloud-Platform-resources.html).
     *     @type bool $validateOnly An option to validate, but not actually execute, the request, and provide the same
     *           response. **Defaults to** `false`.
     * }
     * @return LongRunningOperation
     * @throws ValidationException
     */
    public function createInstanceConfiguration(
        InstanceConfiguration $baseConfig,
        string $name,
        array $replicas,
        array $options = []
    ): LongRunningOperation {
        $config = $this->instanceConfiguration($name);
        return $config->create($baseConfig, $replicas, $options);
    }

    /**
     * List all available instance configurations.
     *
     * Example:
     * ```
     * $configurations = $spanner->instanceConfigurations();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#google.spanner.admin.instance.v1.ListInstanceConfigsRequest ListInstanceConfigsRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<InstanceConfiguration>
     */
    public function instanceConfigurations(array $options = []): ItemIterator
    {
        /**
         * @var ListInstanceConfigsRequest $listInstanceConfigs
         * @var array $callOptions
         */
        [$listInstanceConfigs, $callOptions] = $this->validateOptions(
            $options,
            new ListInstanceConfigsRequest(),
            CallOptions::class
        );
        $listInstanceConfigs->setParent($this->projectName);

        return $this->buildListItemsIterator(
            [$this->instanceAdminClient, 'listInstanceConfigs'],
            $listInstanceConfigs,
            $callOptions + ['resource-prefix' => $this->projectName],
            function (array $config) {
                return $this->instanceConfiguration($config['name'], $config);
            },
            'instanceConfigs',
            $this->pluck('resultLimit', $options, false)
        );
    }

    /**
     * Get an instance configuration by its name.
     *
     * NOTE: This method does not execute a service request and does not verify
     * the existence of the given configuration. Unless you know with certainty
     * that the configuration exists, it is advised that you use
     * {@see \Google\Cloud\Spanner\InstanceConfiguration::exists()} to verify
     * existence before attempting to use the configuration.
     *
     * Example:
     * ```
     * $configuration = $spanner->instanceConfiguration($configurationName);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#getinstanceconfigrequest GetInstanceConfigRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $name The Configuration name.
     * @param array $info [optional] The configuration details.
     * @return InstanceConfiguration
     */
    public function instanceConfiguration($name, array $info = []): InstanceConfiguration
    {
        return new InstanceConfiguration(
            $this->instanceAdminClient,
            $this->serializer,
            $this->projectId,
            $name,
            ['instanceConfig' => $info]
        );
    }

    /**
     * Lists instance configuration operations for the project.
     *
     * Example:
     * ```
     * $instanceConfigOperations = $spanner->instanceConfigOperations();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     * }
     *
     * @return ItemIterator<LongRunningOperation>
     */
    public function instanceConfigOperations(array $options = []): ItemIterator
    {
        /**
         * @var ListInstanceConfigOperationsRequest $listInstanceConfigOperations
         * @var array $callOptions
         */
        [$listInstanceConfigOperations, $callOptions] = $this->validateOptions(
            $options,
            new ListInstanceConfigOperationsRequest(),
            CallOptions::class,
        );
        $listInstanceConfigOperations->setParent($this->projectName);

        return $this->buildLongRunningIterator(
            [$this->instanceAdminClient, 'listInstanceConfigOperations'],
            $listInstanceConfigOperations,
            $callOptions + ['resource-prefix' => $this->projectName],
            function (OperationProto $operation) {
                return new LongRunningOperation(
                    new LongRunningClientConnection($this->databaseAdminClient, $this->serializer),
                    $operation->getName(),
                    [
                        'type.googleapis.com/google.spanner.admin.instance.v1.ListInstanceConfigMetadata' =>
                            fn (InstanceConfig $config) => $this->instanceConfiguration(
                                $config->getName(),
                                $this->handleResponse($config)
                            ),
                    ],
                    $this->handleResponse($operation)
                );
            },
        );
    }

    /**
     * Create a new instance.
     *
     * Example:
     * ```
     * $operation = $spanner->createInstance($configuration, 'my-instance');
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#createinstancerequest CreateInstanceRequest
     *
     * @param InstanceConfiguration $config The configuration to use
     * @param string $name The instance name
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $displayName **Defaults to** the value of $name.
     *     @type int $nodeCount **Defaults to** `1`.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://cloudplatform.googleblog.com/2015/10/using-labels-to-organize-Google-Cloud-Platform-resources.html).
     * }
     * @return LongRunningOperation
     * @codingStandardsIgnoreEnd
     */
    public function createInstance(
        InstanceConfiguration $config,
        string $name,
        array $options = []
    ): LongRunningOperation {
        $instance = $this->instance($name);
        return $instance->create($config, $options);
    }

    /**
     * Lazily instantiate an instance.
     *
     * Example:
     * ```
     * $instance = $spanner->instance('my-instance');
     * ```
     *
     * @param string $name The instance name
     * @return Instance
     */
    public function instance(string $name, array $instance = []): Instance
    {
        return new Instance(
            $this->spannerClient,
            $this->instanceAdminClient,
            $this->databaseAdminClient,
            $this->serializer,
            $this->projectId,
            $name,
            [
                'directedReadOptions' => $this->directedReadOptions,
                'routeToLeader' => $this->routeToLeader,
                'defaultQueryOptions' => $this->defaultQueryOptions,
                'returnInt64AsObject' => $this->returnInt64AsObject,
                'isolationLevel' => $this->isolationLevel,
                'cacheItemPool' => $this->cacheItemPool,
                'instance' => $instance,
            ],
        );
    }

    /**
     * List instances in the project
     *
     * Example:
     * ```
     * $instances = $spanner->instances();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#listinstancesrequest ListInstancesRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $filter An expression for filtering the results of the
     *           request.
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Instance>
     */
    public function instances(array $options = []): ItemIterator
    {
        $options += [
            'filter' => '',
            'parent' => $this->projectName
        ];
        /**
         * @var ListInstancesRequest $listInstances
         * @var array $callOptions
         */
        [$listInstances, $callOptions] = $this->validateOptions(
            $options,
            new ListInstancesRequest(),
            CallOptions::class,
        );

        return $this->buildListItemsIterator(
            [$this->instanceAdminClient, 'listInstances'],
            $listInstances,
            $callOptions + ['resource-prefix' => $this->projectName],
            function (array $instance) {
                $name = InstanceAdminClient::parseName($instance['name'])['instance'];
                return $this->instance($name, $instance);
            },
            'instances',
            $this->pluck('resultLimit', $options, false)
        );
    }

    /**
     * Connect to a database to run queries or mutations.
     *
     * Example:
     * ```
     * $database = $spanner->connect('instance-id', 'database-id');
     * ```
     *
     * Database role configured on the $options parameter
     * will be applied to the session created by this object.
     * Note: When the databseRole and sessionPool both are present in the options,
     * we prioritize the sessionPool.
     * ```
     * $database = $spanner->connect('instance-id', 'database-id', ['databaseRole' => 'Reader']);
     * ```
     *
     * @param Instance|string $instance The instance object or instance name.
     * @param string $name The database name.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $databaseRole The user created database role which creates the session.
     * }
     * @return Database
     */
    public function connect(Instance|string $instance, string $name, array $options = []): Database
    {
        if (is_string($instance)) {
            $instance = $this->instance($instance);
        }

        $database = $instance->database($name, $options);

        return $database;
    }

    /**
     * Create a new KeySet object
     *
     * Example:
     * ```
     * $keySet = $spanner->keySet();
     * ```
     *
     * ```
     * // Create a keyset to return all rows in a table.
     * $keySet = $spanner->keySet(['all' => true]);
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type array $keys A list of keys
     *     @type KeyRange[] $ranges A list of key ranges
     *     @type bool $all Whether to include all keys in a table
     * }
     * @return KeySet
     */
    public function keySet(array $options = []): KeySet
    {
        return new KeySet($options);
    }

    /**
     * Create a new KeyRange object
     *
     * Example:
     * ```
     * $range = $spanner->keyRange();
     * ```
     *
     * ```
     * // Ranges can be created with all data supplied.
     * $range = $spanner->keyRange([
     *     'startType' => KeyRange::TYPE_OPEN,
     *     'start' => ['Bob'],
     *     'endType' => KeyRange::TYPE_OPEN,
     *     'end' => ['Jill']
     * ]);
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $startType Either "open" or "closed". Use constants
     *           `KeyRange::TYPE_OPEN` and `KeyRange::TYPE_CLOSED` for
     *           guaranteed correctness.
     *     @type array $start The key with which to start the range.
     *     @type string $endType Either "open" or "closed". Use constants
     *           `KeyRange::TYPE_OPEN` and `KeyRange::TYPE_CLOSED` for
     *           guaranteed correctness.
     *     @type array $end The key with which to end the range.
     * }
     * @return KeyRange
     */
    public function keyRange(array $options = []): KeyRange
    {
        return new KeyRange($options);
    }

    /**
     * Create a Bytes object.
     *
     * Example:
     * ```
     * $bytes = $spanner->bytes('hello world');
     * ```
     *
     * @param StreamInterface|string|resource $bytes The bytes value.
     * @return Bytes
     */
    public function bytes(mixed $bytes): Bytes
    {
        return new Bytes($bytes);
    }

    /**
     * Create a Date object.
     *
     * Example:
     * ```
     * $date = $spanner->date(new \DateTime('1995-02-04'));
     * ```
     *
     * @param \DateTimeInterface $date The date value.
     * @return Date
     */
    public function date(\DateTimeInterface $date): Date
    {
        return new Date($date);
    }

    /**
     * Create a Timestamp object.
     *
     * Example:
     * ```
     * $timestamp = $spanner->timestamp(new \DateTime('2003-02-05 11:15:02.421827Z'));
     * ```
     *
     * @param \DateTimeInterface $timestamp The timestamp value.
     * @param int|null $nanoSeconds The number of nanoseconds in the timestamp.
     * @return Timestamp
     */
    public function timestamp(\DateTimeInterface $timestamp, int|null $nanoSeconds = null): Timestamp
    {
        return new Timestamp($timestamp, $nanoSeconds);
    }

    /**
     * Create a Numeric object.
     *
     * Numeric represents a value with a data type of
     * [Numeric](https://cloud.google.com/spanner/docs/data-types#numeric-type).
     *
     * It supports a fixed 38 decimal digits of precision and 9 decimal digits of scale, and values
     * are in the range of -99999999999999999999999999999.999999999 to
     * 99999999999999999999999999999.999999999.
     *
     * Example:
     * ```
     * $numeric = $spanner->numeric('99999999999999999999999999999999999999.999999999');
     * ```
     *
     * @param string|int|float $value The Numeric value.
     * @return Numeric
     * @throws \InvalidArgumentException
     */
    public function numeric(string|int|float $value): Numeric
    {
        return new Numeric($value);
    }

    /**
     * Represents a value with a data type of
     * [PG Numeric](https://cloud.google.com/spanner/docs/reference/postgresql/data-types) for the
     * Postgres Dialect database.
     *
     * It supports a value precision of up to 131072 digits before the decimal point
     * and up to 16383 digits after the decimal point.
     *
     * Example:
     * ```
     * $pgNumeric = $spanner->pgNumeric('99999999999999999999999999999999999999.000000999999999');
     * ```
     *
     * @param string|int|float|null $value The PgNumeric value.
     * @return PgNumeric
     */
    public function pgNumeric(string|int|float|null $value): PgNumeric
    {
        return new PgNumeric($value);
    }

    /**
     * Represents a value with a data type of
     * [PG JSONB](https://cloud.google.com/spanner/docs/reference/postgresql/data-types) for the
     * Postgres Dialect database.
     *
     * Example:
     * ```
     * $pgJsonb = $spanner->pgJsonb('{}');
     * ```
     */
    public function pgJsonb(string|array|\JsonSerializable|null $value): PgJsonb
    {
        return new PgJsonb($value);
    }

    /**
     * Represents a value with a data type of
     * [PG OID](https://cloud.google.com/spanner/docs/reference/postgresql/data-types) for the
     * Postgres Dialect database.
     *
     * Example:
     * ```
     * $pgOid = $spanner->pgOid('123');
     * ```
     */
    public function pgOid(string|null $value): PgOid
    {
        return new PgOid($value);
    }

    /**
     * Create an Int64 object. This can be used to work with 64 bit integers as
     * a string value while on a 32 bit platform.
     *
     * Example:
     * ```
     * $int64 = $spanner->int64('9223372036854775807');
     * ```
     *
     * @param string $value
     * @return Int64
     */
    public function int64(string $value): Int64
    {
        return new Int64($value);
    }

    /**
     * Create a Duration object.
     *
     * Example:
     * ```
     * $duration = $spanner->duration(100, 00001);
     * ```
     *
     * @param int $seconds The number of seconds in the duration.
     * @param int $nanos [optional] The number of nanoseconds in the duration.
     *        **Defaults to** `0`.
     * @return Duration
     */
    public function duration(int $seconds, int $nanos = 0): Duration
    {
        return new Duration(['seconds' => $seconds, 'nanos' => $nanos]);
    }

    /**
     * Create a CommitTimestamp object.
     *
     * Commit Timestamps may be used to implement server-side commit timestamp
     * tracking in tables. Refer to {@see \Google\Cloud\Spanner\CommitTimestamp}
     * for usage details.
     *
     * Example:
     * ```
     * $commitTimestamp = $spanner->commitTimestamp();
     * ```
     *
     * @return CommitTimestamp
     */
    public function commitTimestamp(): CommitTimestamp
    {
        return new CommitTimestamp();
    }

    /**
     * Throw an exception if the gRPC extension is not loaded.
     *
     * @throws GoogleException
     */
    private function requireGrpc()
    {
        if (!$this->isGrpcLoaded()) {
            throw new GoogleException(
                'The requested client requires the gRPC extension. '
                . 'Please see https://cloud.google.com/php/grpc for installation '
                . 'instructions.'
            );
        }
    }

    /**
     * Abstract the checking of the grpc extension for unit testing.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    private function isGrpcLoaded()
    {
        return extension_loaded('grpc');
    }
}
