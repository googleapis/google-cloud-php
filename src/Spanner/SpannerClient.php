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
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\Session\SessionClient;
use Google\Cloud\Spanner\Session\SimpleSessionPool;
use Google\Cloud\ValidateTrait;
use google\spanner\admin\instance\v1\Instance\State;

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
     * }
     * @throws Google\Cloud\Exception\GoogleException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [
                self::FULL_CONTROL_SCOPE,
                self::ADMIN_SCOPE
            ];
        }

        $this->connection = new Grpc($this->configureAuthentication($config));

        $this->sessionClient = new SessionClient($this->connection, $this->projectId);
        $this->sessionPool = new SimpleSessionPool($this->sessionClient);
    }

    /**
     * List all available configurations
     *
     * Example:
     * ```
     * $configurations = $spanner->configurations();
     * ```
     *
     * @todo implement pagination!
     *
     * @see https://cloud.google.com/spanner/reference/rest/v1/projects.instanceConfigs/list List Configs
     *
     * @return Generator<Configuration>
     */
    public function configurations()
    {
        $res = $this->connection->listConfigs([
            'projectId' => InstanceAdminClient::formatProjectName($this->projectId)
        ]);

        if (isset($res['instanceConfigs'])) {
            foreach ($res['instanceConfigs'] as $config) {
                $name = InstanceAdminClient::parseInstanceConfigFromInstanceConfigName($config['name']);
                yield $this->configuration($name, $config);
            }
        }
    }

    /**
     * Get a configuration by its name
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
     * Create an instance
     *
     * Example:
     * ```
     * $instance = $spanner->createInstance($configuration, 'my-application-instance');
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
     *     @type int $state **Defaults to** <val>
     *     @type array $labels [Using labels to organize Google Cloud Platform resources](https://cloudplatform.googleblog.com/2015/10/using-labels-to-organize-Google-Cloud-Platform-resources.html).
     * }
     * @return Instance
     * @codingStandardsIgnoreEnd
     */
    public function createInstance(Configuration $config, $name, array $options = [])
    {
        $options += [
            'displayName' => $name,
            'nodeCount' => self::DEFAULT_NODE_COUNT,
            'state' => State::CREATING,
            'labels' => []
        ];

        $res = $this->connection->createInstance($options + [
            'name' => InstanceAdminClient::formatInstanceName($this->projectId, $name),
            'config' => InstanceAdminClient::formatInstanceConfigName($this->projectId, $config->name())
        ]);

        return $this->instance($name);
    }

    /**
     * Lazily instantiate an instance
     *
     * Example:
     * ```
     * $instance = $spanner->instance('my-application-instance');
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
            $instance
        );
    }

    /**
     * Connect to a database to run queries or mutations.
     *
     * Example:
     * ```
     * $database = $spanner->connect('my-application-instance', 'my-application-database');
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
            'projectId' => $this->projectId,
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
     * @param array $range [optional] The key range data.
     * @return KeyRange
     */
    public function keyRange(array $range = [])
    {
        return new KeyRange($range);
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
