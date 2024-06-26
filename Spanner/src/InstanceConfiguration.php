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

use Google\ApiCore\ArrayTrait;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\LongRunning\OperationResponse;
use Google\Cloud\Core\LongRunning\LongRunningOperationTrait;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig\Type;
use Google\Cloud\Spanner\Admin\Instance\V1\ReplicaInfo;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceConfigRequest;
use Google\ApiCore\ValidationException;

/**
 * Represents a Cloud Spanner Instance Configuration.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => $projectId]);
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
    use ApiHelperTrait;
    use ArrayTrait;
    use OperationResponseTrait;
    use RequestTrait;

    /**
     * @var RequestHiuandler
     */
    private $requestHandler;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

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
     * @param RequestHandler The request handler that is responsible for sending a request
     *        and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $projectId The current project ID.
     * @param string $name The configuration name or ID.
     * @param array $info [optional] A service representation of the
     *        configuration.
     */
    public function __construct(
        RequestHandler $requestHandler,
        Serializer $serializer,
        $projectId,
        $name,
        array $info = []
    ) {
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedConfigName($name, $projectId);
        $this->info = $info;
        $instanceConfigFactoryFn = function ($instanceConfig) use (
            $requestHandler,
            $serializer,
            $projectId,
            $name
        ) {
            $name = InstanceAdminClient::parseName($instanceConfig['name'])['instance_config'];
            return new self(
                $requestHandler,
                $serializer,
                $projectId,
                $name,
                $instanceConfig
            );
        };
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data += ['name' => $this->name];

        return $this->info = $this->createAndSendRequest(
            InstanceAdminClient::class,
            'getInstanceConfig',
            $data,
            $optionalArgs,
            GetInstanceConfigRequest::class,
            InstanceAdminClient::projectName($this->projectId)
        );
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
     * @return OperationResponse
     * @throws ValidationException
     * @codingStandardsIgnoreEnd
     */
    public function create(InstanceConfiguration $baseConfig, array $replicas, array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);

        $leaderOptions = $baseConfig->__debugInfo()['info']['leaderOptions'] ?? [];
        $validateOnly = $this->pluck('validateOnly', $data, false) ?: false;
        $data += [
            'replicas' => $replicas,
            'baseConfig' => $baseConfig->name(),
            'leaderOptions' => $leaderOptions
        ];
        $instanceConfig = $this->instanceConfigArray($data);
        $requestArray = [
            'parent' => InstanceAdminClient::projectName($this->projectId),
            'instanceConfigId' => InstanceAdminClient::parseName(
                $this->name
            )['instance_config'],
            'instanceConfig' => $instanceConfig,
            'validateOnly' => $validateOnly
        ];

        return $this->createAndSendRequest(
            InstanceAdminClient::class,
            'createInstanceConfig',
            $requestArray,
            $optionalArgs,
            CreateInstanceConfigRequest::class,
            $this->name
        );
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
     * @return OperationResponse
     * @throws \InvalidArgumentException
     */
    public function update(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $validateOnly = $this->pluck('validateOnly', $data, false) ?: false;
        $fieldMask = $this->fieldMask($data);
        $data += [
            'name' => $this->name,
        ];

        $requestArray = [
            'instanceConfig' => $data,
            'updateMask' => $fieldMask,
            'validateOnly' => $validateOnly
        ];

        return $this->createAndSendRequest(
            InstanceAdminClient::class,
            'updateInstanceConfig',
            $requestArray,
            $optionalArgs,
            UpdateInstanceConfigRequest::class,
            $this->name
        );
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data += ['name' => $this->name];

        $this->createAndSendRequest(
            InstanceAdminClient::class,
            'deleteInstanceConfig',
            $data,
            $optionalArgs,
            DeleteInstanceConfigRequest::class,
            $this->name
        );
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

    /**
     * @param array $args
     *
     * @return array
     */
    private function instanceConfigArray(array $args)
    {
        $configId = InstanceAdminClient::parseName($this->name)['instance_config'];

        return $args += [
            'name' => $this->name,
            'displayName' => $configId,
            'configType' => Type::USER_MANAGED
        ];
    }

    /**
     * @param array $instanceArray
     * @return array
     */
    private function fieldMask(array $instanceArray)
    {
        $mask = [];
        foreach (array_keys($instanceArray) as $key) {
            $mask[] = $this->serializer::toSnakeCase($key);
        }
        return ['paths' => $mask];
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
            'requestHandler' => get_class($this->requestHandler),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info,
        ];
    }
}
