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
use Google\Cloud\Core\Exception\GoogleException;
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
use Psr\Http\StreamInterface;

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
 * $spanner = new SpannerClient();
 * ```
 *
 * @method resumeOperation() {
 *     Resume a Long Running Operation
 *
 *     Example:
 *     ```
 *     $operation = $spanner->resumeOperation($operationName);
 *     ```
 *
 *     @param string $operationName The Long Running Operation name.
 *     @param array $info [optional] The operation data.
 *     @return LongRunningOperation
 * }
 */
class SpannerClient
{
    use ArrayTrait;
    use ClientTrait;
    use LROTrait;
    use ValidateTrait;

    const VERSION = '1.0.1';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/spanner.data';
    const ADMIN_SCOPE = 'https://www.googleapis.com/auth/spanner.admin';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * Create a Spanner client. Please note that this client requires
     * [the gRPC extension](https://cloud.google.com/php/grpc).
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `0` with REST and `60` with gRPC.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     * }
     * @throws GoogleException If the gRPC extension is not enabled.
     */
    public function __construct(array $config = [])
    {
        $this->requireGrpc();
        $config += [
            'scopes' => [
                self::FULL_CONTROL_SCOPE,
                self::ADMIN_SCOPE
            ],
            'returnInt64AsObject' => false,
            'projectIdRequired' => true
        ];

        $this->connection = new Grpc($this->configureAuthentication($config));
        $this->returnInt64AsObject = $config['returnInt64AsObject'];

        $this->setLroProperties(new LongRunningConnection($this->connection), [
            [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.UpdateInstanceMetadata',
                'callable' => function ($instance) {
                    $name = InstanceAdminClient::parseName($instance['name'])['instance'];
                    return $this->instance($name, $instance);
                }
            ], [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.CreateDatabaseMetadata',
                'callable' => function ($database) {
                    $databaseNameComponents = DatabaseAdminClient::parseName($database['name']);
                    $instanceName = $databaseNameComponents['instance'];
                    $databaseName = $databaseNameComponents['database'];

                    $instance = $this->instance($instanceName);
                    return $instance->database($databaseName);
                }
            ], [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.CreateInstanceMetadata',
                'callable' => function ($instance) {
                    $name = InstanceAdminClient::parseName($instance['name'])['instance'];
                    return $this->instance($name, $instance);
                }
            ]
        ]);
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
    public function instanceConfigurations(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false) ?: 0;

        return new ItemIterator(
            new PageIterator(
                function (array $config) {
                    return $this->instanceConfiguration($config['name'], $config);
                },
                [$this->connection, 'listInstanceConfigs'],
                ['projectId' => InstanceAdminClient::projectName($this->projectId)] + $options,
                [
                    'itemsKey' => 'instanceConfigs',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Get an instance configuration by its name.
     *
     * NOTE: This method does not execute a service request and does not verify
     * the existence of the given configuration. Unless you know with certainty
     * that the configuration exists, it is advised that you use
     * {@see Google\Cloud\Spanner\InstanceConfiguration::exists()} to verify
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
     * @param array $config [optional] The configuration details.
     * @return InstanceConfiguration
     */
    public function instanceConfiguration($name, array $config = [])
    {
        return new InstanceConfiguration($this->connection, $this->projectId, $name, $config);
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
     * @return LongRunningOperation<Instance>
     * @codingStandardsIgnoreEnd
     */
    public function createInstance(InstanceConfiguration $config, $name, array $options = [])
    {
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
                    $name = InstanceAdminClient::parseName($instance['name'])['instance'];
                    return $this->instance($name, $instance);
                },
                [$this->connection, 'listInstances'],
                ['projectId' => InstanceAdminClient::projectName($this->projectId)] + $options,
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
}
