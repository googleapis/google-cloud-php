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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LROTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\Connection\LongRunningConnection;
use google\spanner\admin\instance\v1\Instance\State;
use Psr\Http\StreamInterface;

/**
 * Google Cloud Spanner is a highly scalable, transactional, managed, NewSQL
 * database service. Find more information at
 * [Google Cloud Spanner docs](https://cloud.google.com/spanner/).
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * ```
 */
class SpannerClient
{
    use ArrayTrait;
    use ClientTrait;
    use LROTrait;
    use ValidateTrait;

    const VERSION = 'master';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/spanner.data';
    const ADMIN_SCOPE = 'https://www.googleapis.com/auth/spanner.admin';
    const DEFAULT_NODE_COUNT = 1;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var LongRunningConnectionInterface
     */
    private $lroConnection;

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * Create a Spanner client.
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     * }
     * @throws Google\Cloud\Core\Exception\GoogleException
     */
    public function __construct(array $config = [])
    {
        $config += [
            'scopes' => [
                self::FULL_CONTROL_SCOPE,
                self::ADMIN_SCOPE
            ],
            'returnInt64AsObject' => false
        ];

        $this->connection = new Grpc($this->configureAuthentication($config));
        $this->lroConnection = new LongRunningConnection($this->connection);
        $this->returnInt64AsObject = $config['returnInt64AsObject'];
        $this->lroCallables = [
            [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.UpdateInstanceMetadata',
                'callable' => function ($instance) {
                    $name = InstanceAdminClient::parseInstanceFromInstanceName($instance['name']);
                    return $this->instance($name, $instance);
                }
            ], [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.CreateDatabaseMetadata',
                'callable' => function ($database) {
                    $instanceName = DatabaseAdminClient::parseInstanceFromDatabaseName($database['name']);
                    $databaseName = DatabaseAdminClient::parseDatabaseFromDatabaseName($database['name']);

                    $instance = $this->instance($instanceName);
                    return $instance->database($databaseName);
                }
            ], [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.CreateInstanceMetadata',
                'callable' => function ($instance) {
                    $name = InstanceAdminClient::parseInstanceFromInstanceName($instance['name']);
                    return $this->instance($name, $instance);
                }
            ]
        ];
    }

    /**
     * List all available configurations.
     *
     * Example:
     * ```
     * $configurations = $spanner->configurations();
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
     * @return ItemIterator<Configuration>
     */
    public function configurations(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false) ?: 0;

        return new ItemIterator(
            new PageIterator(
                function (array $config) {
                    $name = InstanceAdminClient::parseInstanceConfigFromInstanceConfigName($config['name']);
                    return $this->configuration($name, $config);
                },
                [$this->connection, 'listConfigs'],
                ['projectId' => InstanceAdminClient::formatProjectName($this->projectId)] + $options,
                [
                    'itemsKey' => 'instanceConfigs',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Get a configuration by its name.
     *
     * NOTE: This method does not execute a service request and does not verify
     * the existence of the given configuration. Unless you know with certainty
     * that the configuration exists, it is advised that you use
     * {@see Google\Cloud\Spanner\Configuration::exists()} to verify existence
     * before attempting to use the configuration.
     *
     * Example:
     * ```
     * $configuration = $spanner->configuration($configurationName);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#getinstanceconfigrequest GetInstanceConfigRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $name The Configuration name.
     * @param array $config [optional] The configuration details.
     * @return Configuration
     */
    public function configuration($name, array $config = [])
    {
        return new Configuration($this->connection, $this->projectId, $name, $config);
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
     * @param Configuration $config The configuration to use
     * @param string $name The instance name
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $displayName **Defaults to** the value of $name.
     *     @type int $nodeCount **Defaults to** `1`.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://cloudplatform.googleblog.com/2015/10/using-labels-to-organize-Google-Cloud-Platform-resources.html).
     * }
     * @return LongRunningOperation<Instance>
     * @codingStandardsIgnoreEnd
     */
    public function createInstance(Configuration $config, $name, array $options = [])
    {
        $options += [
            'displayName' => $name,
            'nodeCount' => self::DEFAULT_NODE_COUNT,
            'labels' => [],
            'operationName' => null,
        ];

        // This must always be set to CREATING, so overwrite anything else.
        $options['state'] = State::CREATING;

        $operation = $this->connection->createInstance([
            'instanceId' => $name,
            'name' => InstanceAdminClient::formatInstanceName($this->projectId, $name),
            'projectId' => InstanceAdminClient::formatProjectName($this->projectId),
            'config' => InstanceAdminClient::formatInstanceConfigName($this->projectId, $config->name())
        ] + $options);

        return $this->lro($this->lroConnection, $operation['name'], $this->lroCallables);
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
    public function instance($name, array $instance = [])
    {
        return new Instance(
            $this->connection,
            $this->lroConnection,
            $this->lroCallables,
            $this->projectId,
            $name,
            $this->returnInt64AsObject,
            $instance
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
    public function instances(array $options = [])
    {
        $options += [
            'filter' => null
        ];

        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $instance) {
                    $name = InstanceAdminClient::parseInstanceFromInstanceName($instance['name']);
                    return $this->instance($name, $instance);
                },
                [$this->connection, 'listInstances'],
                ['projectId' => InstanceAdminClient::formatProjectName($this->projectId)] + $options,
                [
                    'itemsKey' => 'instances',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Connect to a database to run queries or mutations.
     *
     * Example:
     * ```
     * $database = $spanner->connect('my-instance', 'my-application-database');
     * ```
     *
     * @param Instance|string $instance The instance object or instance name.
     * @param string $name The database name.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type SessionPoolInterface $sessionPool A pool used to manage
     *           sessions.
     * }
     * @return Database
     */
    public function connect($instance, $name, array $options = [])
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
    public function keySet(array $options = [])
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
    public function keyRange(array $options = [])
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
     * @param string|resource|StreamInterface $value The bytes value.
     * @return Bytes
     */
    public function bytes($bytes)
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
     * @param \DateTimeInterface $value The date value.
     * @return Date
     */
    public function date(\DateTimeInterface $date)
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
     * @param \DateTimeInterface $value The timestamp value.
     * @param int $nanoSeconds [optional] The number of nanoseconds in the timestamp.
     * @return Timestamp
     */
    public function timestamp(\DateTimeInterface $timestamp, $nanoSeconds = null)
    {
        return new Timestamp($timestamp, $nanoSeconds);
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
    public function int64($value)
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
    public function duration($seconds, $nanos = 0)
    {
        return new Duration($seconds, $nanos);
    }

    /**
     * Resume a Long Running Operation
     *
     * Example:
     * ```
     * $operation = $spanner->resumeOperation($operationName);
     * ```
     *
     * @param string $operationName The Long Running Operation name.
     * @return LongRunningOperation
     */
    public function resumeOperation($operationName)
    {
        return $this->lro($this->lroConnection, $operationName, $this->lroCallables);
    }
}
