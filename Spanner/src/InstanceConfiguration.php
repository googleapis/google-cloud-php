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

use Closure;
use Google\ApiCore\ApiException;
use Google\ApiCore\Options\CallOptions;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\LongRunning\LongRunningClientConnection;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\OptionsValidator;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig\Type;
use Google\Cloud\Spanner\Admin\Instance\V1\ReplicaInfo;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceConfigRequest;
use Google\Rpc\Code;

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
    use RequestTrait;

    private array $info;

    /**
     * Create an instance configuration object.
     *
     * @internal InstanceConfiguration is constructed by the {@see SpannerClient} class.
     *
     * @param InstanceAdminClient $instanceAdminClient The client library to use for the request
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $projectId The current project ID.
     * @param string $name The configuration name or ID.
     * @param array $options [Optional] {
     *     Instance Configuration options.

     *     @type array $instanceConfig The instance configuration info.
     * }
     */
    public function __construct(
        private InstanceAdminClient $instanceAdminClient,
        private Serializer $serializer,
        private string $projectId,
        private string $name,
        private array $options = [],
    ) {
        $this->name = $this->fullyQualifiedConfigName($name, $projectId);
        $this->info = $options['instanceConfig'] ?? [];
        $this->optionsValidator = new OptionsValidator($serializer);
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
    public function name(): string
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
    public function info(array $options = []): array
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
    public function exists(array $options = []): bool
    {
        try {
            $this->reload($options);
        } catch (ApiException $e) {
            if ($e->getCode() === Code::NOT_FOUND) {
                return false;
            }
            throw $e;
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
    public function reload(array $options = []): array
    {
        $options += ['name' => $this->name];
        /**
         * @var GetInstanceConfigRequest $getInstanceConfig
         * @var array $callOptions
         */
        [$getInstanceConfig, $callOptions] = $this->validateOptions(
            $options,
            new GetInstanceConfigRequest(),
            CallOptions::class
        );

        $response = $this->instanceAdminClient->getInstanceConfig($getInstanceConfig, $callOptions + [
            'resource-prefix' => InstanceAdminClient::projectName($this->projectId),
        ]);

        return $this->info = $this->handleResponse($response);
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
     * @return LongRunningOperation
     * @throws ValidationException
     * @codingStandardsIgnoreEnd
     */
    public function create(
        InstanceConfiguration $baseConfig,
        array $replicas,
        array $options = []
    ): LongRunningOperation {
        $leaderOptions = $baseConfig->info()['leaderOptions'] ?? [];
        $options['leaderOptions'] = $leaderOptions;
        $options['replicas'] = $replicas;
        $options['baseConfig'] = $baseConfig->name();

        [$instanceConfig, $callOptions] = $this->validateOptions(
            $options,
            new InstanceConfig(),
            CallOptions::class
        );

        $instanceConfig->setName($this->name);
        if (!$instanceConfig->getDisplayName()) {
            $instanceConfig->setDisplayName(InstanceAdminClient::parseName($this->name)['instance_config']);
        }
        $instanceConfig->setConfigType(InstanceConfig\Type::USER_MANAGED);

        $request = new CreateInstanceConfigRequest([
            'parent' => InstanceAdminClient::projectName($this->projectId),
            'instance_config_id' => InstanceAdminClient::parseName($this->name)['instance_config'],
            'instance_config' => $instanceConfig,
            'validate_only' => $options['validateOnly'] ?? false
        ]);

        $operation = $this->instanceAdminClient->createInstanceConfig(
            $request,
            $callOptions + ['resource-prefix' => $this->name]
        );

        return $this->operationFromOperationResponse($operation);
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
     * @return LongRunningOperation
     * @throws \InvalidArgumentException
     */
    public function update(array $options = []): LongRunningOperation
    {
        $validateOnly = $options['validateOnly'] ?? false;
        unset($options['validateOnly']);

        [$request, $callOptions] = $this->validateOptions(
            [
                'instanceConfig' => $options + ['name' => $this->name],
                'updateMask' => $this->fieldMask($options),
                'validateOnly' => $validateOnly,
            ],
            new UpdateInstanceConfigRequest(),
            CallOptions::class
        );

        $operation = $this->instanceAdminClient->updateInstanceConfig(
            $request,
            $callOptions + ['resource-prefix' => $this->name]
        );

        return $this->operationFromOperationResponse($operation);
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
    public function delete(array $options = []): void
    {
        $options += ['name' => $this->name];

        /**
         * @var DeleteInstanceConfigRequest $deleteInstanceConfigs
         * @var array $callOptions
         */
        [$deleteInstanceConfigs, $callOptions] = $this->validateOptions(
            $options,
            new DeleteInstanceConfigRequest(),
            CallOptions::class
        );

        $this->instanceAdminClient->deleteInstanceConfig($deleteInstanceConfigs, $callOptions + [
            'resource-prefix' => $this->name
        ]);
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
    public function resumeOperation(string $operationName, array $options = []): LongRunningOperation
    {
        return new LongRunningOperation(
            new LongRunningClientConnection($this->instanceAdminClient, $this->serializer),
            $operationName,
            [
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.CreateInstanceConfigMetadata',
                    'callable' => $this->instanceConfigResultFunction(),
                ],
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.UpdateInstanceConfigMetadata',
                    'callable' => $this->instanceConfigResultFunction(),
                ]
            ],
            $options
        );
    }

    /**
     * Get the fully qualified instance config name.
     *
     * @param string $name The configuration name.
     * @param string $projectId The project ID.
     * @return string
     */
    private function fullyQualifiedConfigName($name, $projectId): string
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

    private function instanceConfigResultFunction(): Closure
    {
        return function (array $result) {
            $name = InstanceAdminClient::parseName($result['name']);
            return new self(
                $this->instanceAdminClient,
                $this->serializer,
                $this->projectId,
                $name['instance_config'],
                ['instanceConfig' => $result],
            );
        };
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
            'instanceAdminClient' => get_class($this->instanceAdminClient),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info,
        ];
    }
}
