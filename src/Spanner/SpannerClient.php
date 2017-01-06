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

use Google\Cloud\ClientTrait;
use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Int64;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\Session\SessionClient;
use Google\Cloud\Spanner\Session\SimpleSessionPool;
use Google\Cloud\ValidateTrait;
use google\spanner\admin\instance\v1\Instance\State;

/**
 * Google Cloud Spanner is a highly scalable, transactional, managed, NewSQL
 * database service. Find more information at
 * [Google Cloud Spanner docs](https://cloud.google.com/spanner/).
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $spanner = $cloud->spanner();
 * ```
 *
 * ```
 * // SpannerClient can be instantiated directly.
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * ```
 */
class SpannerClient
{
    use ClientTrait;
    use ValidateTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/spanner.data';

    const ADMIN_SCOPE = 'https://www.googleapis.com/auth/spanner.admin';

    const DEFAULT_NODE_COUNT = 1;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var SessionClient
     */
    protected $sessionClient;

    /**
     * @var SessionPool
     */
    protected $sessionPool;

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
     *           returned as a {@see Google\Cloud\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     * }
     * @throws Google\Cloud\Exception\GoogleException
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

        $this->sessionClient = new SessionClient($this->connection, $this->projectId);
        $this->sessionPool = new SimpleSessionPool($this->sessionClient);

        $this->returnInt64AsObject = $config['returnInt64AsObject'];
    }

    /**
     * List all available configurations.
     *
     * Example:
     * ```
     * $configurations = $spanner->configurations();
     * ```
     *
     * @see https://cloud.google.com/spanner/reference/rest/v1/projects.instanceConfigs/list List Configs
     *
     * @param array $options [optional] Configuration Options.
     * @return Generator<Configuration>
     */
    public function configurations(array $options = [])
    {
        $pageToken = null;
        do {
            $res = $this->connection->listConfigs([
                'projectId' => InstanceAdminClient::formatProjectName($this->projectId),
                'pageToken' => $pageToken
            ] + $options);

            if (isset($res['instanceConfigs'])) {
                foreach ($res['instanceConfigs'] as $config) {
                    $name = InstanceAdminClient::parseInstanceConfigFromInstanceConfigName($config['name']);
                    yield $this->configuration($name, $config);
                }
            }

            $pageToken = (isset($res['nextPageToken']))
                ? $res['nextPageToken']
                : null;
        } while($pageToken);
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
     * $instance = $spanner->createInstance($configuration, 'my-instance');
     * ```
     *
     * @see https://cloud.google.com/spanner/reference/rest/v1/projects.instances/create Create Instance
     *
     * @codingStandardsIgnoreStart
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
     * @return Instance
     * @codingStandardsIgnoreEnd
     */
    public function createInstance(Configuration $config, $name, array $options = [])
    {
        $options += [
            'displayName' => $name,
            'nodeCount' => self::DEFAULT_NODE_COUNT,
            'labels' => []
        ];

        // This must always be set to CREATING, so overwrite anything else.
        $options['state'] = State::CREATING;

        $res = $this->connection->createInstance([
            'instanceId' => $name,
            'name' => InstanceAdminClient::formatInstanceName($this->projectId, $name),
            'projectId' => InstanceAdminClient::formatProjectName($this->projectId),
            'config' => InstanceAdminClient::formatInstanceConfigName($this->projectId, $config->name())
        ] + $options);

        return $this->instance($name);
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
            $this->sessionPool,
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
     * @todo implement pagination!
     *
     * @see https://cloud.google.com/spanner/reference/rest/v1/projects.instances/list List Instances
     *
     * @param array $options [optional] Configuration options
     * @return Generator<Instance>
     */
    public function instances(array $options = [])
    {
        $options += [
            'filter' => null
        ];

        $res = $this->connection->listInstances($options + [
            'projectId' => InstanceAdminClient::formatProjectName($this->projectId),
        ]);

        if (isset($res['instances'])) {
            foreach ($res['instances'] as $instance) {
                yield $this->instance(
                    InstanceAdminClient::parseInstanceFromInstanceName($instance['name']),
                    $instance
                );
            }
        }
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
     * @return Database
     */
    public function connect($instance, $name)
    {
        if (is_string($instance)) {
            $instance = $this->instance($instance);
        }

        $database = $instance->database($name);

        return $database;
    }

    /**
     * Create a new KeySet object
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
     * Get the session client
     *
     * Example:
     * ```
     * $sessionClient = $spanner->sessionClient();
     * ```
     *
     * @return SessionClient
     */
    public function sessionClient()
    {
        return $this->sessionClient;
    }
}
