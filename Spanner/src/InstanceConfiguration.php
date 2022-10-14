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
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LROTrait;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig\State;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig\Type;
use Google\Cloud\Spanner\Admin\Instance\V1\ReplicaInfo;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Connection\LongRunningConnection;
use Google\ApiCore\ValidationException;

/**
 * Represents a Cloud Spanner Instance Configuration.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $configuration = $spanner->instanceConfiguration('regional-europe-west');
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#instanceconfig InstanceConfig
 * @codingStandardsIgnoreEnd
 */
class InstanceConfiguration
{
    use ArrayTrait;
    use LROTrait;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $info;

    /**
     * Create an instance configuration object.
     *
     * @param ConnectionInterface $connection A service connection for the
     *        Spanner API.
     * @param string $projectId The current project ID.
     * @param string $name The configuration name or ID.
     * @param array $info [optional] A service representation of the
     *        configuration.
     * @param LongRunningConnectionInterface $lroConnection An implementation
     *        mapping to methods which handle LRO resolution in the service.
     */
    public function __construct(
        ConnectionInterface $connection,
        $projectId,
        $name,
        array $info = [],
        LongRunningConnectionInterface $lroConnection = null
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedConfigName($name, $projectId);
        $this->info = $info;
        $lroConnection = $lroConnection ?: new LongRunningConnection($this->connection);
        $instanceConfigFactoryFn = function ($instanceConfig) use ($connection, $projectId, $name, $lroConnection) {
            $name = InstanceAdminClient::parseName($instanceConfig['name'])['instance_config'];
            return new self(
                $connection,
                $projectId,
                $name,
                $instanceConfig,
                $lroConnection
            );
        };
        $this->setLroProperties(
            $lroConnection,
            [
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.CreateInstanceConfigMetadata',
                    'callable' => $instanceConfigFactoryFn
                ],
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.UpdateInstanceConfigMetadata',
                    'callable' => $instanceConfigFactoryFn
                ]
            ]
        );
    }

    /**
     * Return the configuration name.
     *
     * Example:
     * ```
     * $name = $configuration->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Return the service representation of the configuration.
     *
     * This method may require a service call.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/spanner.admin` scope.
     *
     * Example:
     * ```
     * $info = $configuration->info();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] Configuration options.
     * @return array [InstanceConfig](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#instanceconfig)
     * @codingStandardsIgnoreEnd
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Check if the configuration exists.
     *
     * This method requires a service call.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/spanner.admin` scope.
     *
     * Example:
     * ```
     * if ($configuration->exists()) {
     *    echo 'Configuration exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->reload($options = []);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Fetch a fresh representation of the configuration from the service.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/spanner.admin` scope.
     *
     * Example:
     * ```
     * $info = $configuration->reload();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] Configuration options.
     * @return array [InstanceConfig](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#instanceconfig)
     * @codingStandardsIgnoreEnd
     */
    public function reload(array $options = [])
    {
        $this->info = $this->connection->getInstanceConfig($options + [
            'name' => $this->name,
            'projectName' => InstanceAdminClient::projectName($this->projectId),
        ]);

        return $this->info;
    }

    /**
     * Create a new instance configuration.
     *
     * Example:
     * ```
     * $operation = $instanceConfig->create($baseConfig, $options);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#createinstanceconfigrequest CreateInstanceConfigRequest
     *
     * @param InstanceConfiguration $baseConfig The base configuration to extend for this custom instance configuration.
     * @param ReplicaInfo[]|array $replicas The replica information for the new instance configuration. This array must
     *           contain all the replicas from the base configuration, plus at least one from list of optional replicas
     *           of the base configuration. One of the replicas must be set as the default leader location.
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $displayName **Defaults to** the name of this instance configuration.
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
     * @return LongRunningOperation<InstanceConfiguration>
     * @throws ValidationException
     * @codingStandardsIgnoreEnd
     */
    public function create(InstanceConfiguration $baseConfig, array $replicas, array $options = [])
    {
        $configId = InstanceAdminClient::parseName($this->name)['instance_config'];
        $leaderOptions = isset($baseConfig->__debugInfo()['info']['leaderOptions'])
            ? $baseConfig->__debugInfo()['info']['leaderOptions']
            : [];
        $options += [
            'displayName' => $configId,
            'labels' => [],
            'replicas' => $replicas,
            'leaderOptions' => $leaderOptions,
        ];

        // Set output parameters to their default values.
        $options['state'] = State::CREATING;
        $options['configType'] = Type::USER_MANAGED;
        $options['optionalReplicas'] = [];
        $options['reconciling'] = false;

        $operation = $this->connection->createInstanceConfig([
            'instanceConfigId' => $configId,
            'name' => $this->name,
            'projectName' => InstanceAdminClient::projectName($this->projectId),
            'baseConfig' => $baseConfig->name(),
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Update the instance configuration. This is only possible for customer managed instance configurations.
     *
     * Example:
     * ```
     * $operation = $instanceConfig->update([
     *     'displayName' => 'My Instance config'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.instance.v1#updateinstanceconfigrequest UpdateInstanceConfigRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $displayName The descriptive name for this instance as
     *           it appears in UIs. **Defaults to** the name of this instance configuration.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://goo.gl/xmQnxf).
     *     @type bool $validateOnly An option to validate, but not actually execute, the request, and provide the same
     *           response. **Defaults to** `false`.
     * }
     * @return LongRunningOperation<InstanceConfiguration>
     * @throws InvalidArgumentException
     */
    public function update(array $options = [])
    {
        $operation = $this->connection->updateInstanceConfig([
            'name' => $this->name,
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Delete the instance configuration. This is only possible for customer managed instance configurations that are
     * currently not in use by any instances.
     *
     * Example:
     * ```
     * $instanceConfig->delete();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.instance.v1#deleteinstanceconfigrequest DeleteInstanceConfigRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteInstanceConfig([
            'name' => $this->name
        ] + $options);
    }

    /**
     * A more readable representation of the object.
     *
     * @codeCoverageIgnore
     * @access private
     */
    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info,
        ];
    }

    /**
     * Get the fully qualified instance config name.
     *
     * @param string $name The configuration name.
     * @param string $projectId The project ID.
     * @return string
     */
    private function fullyQualifiedConfigName($name, $projectId)
    {
        try {
            return InstanceAdminClient::instanceConfigName(
                $projectId,
                $name
            );
        } catch (ValidationException $e) {
            return $name;
        }
    }
}
