<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable;

use Google\ApiCore\ValidationException;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LROTrait;

/**
 * Represents a Cloud Bigtable instance
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\BigtableClient;
 *
 * $bigtable = new BigtableClient();
 *
 * $instance = $bigtable->instance('my-instance');
 * ```
 *
 * @method resumeOperation() {
 *     Resume a Long Running Operation
 *
 *     Example:
 *     ```
 *     $operation = $instance->resumeOperation($operationName);
 *     ```
 *
 *     @param string $operationName The Long Running Operation name.
 *     @param array $info [optional] The operation data.
 *     @return LongRunningOperation
 * }
 * @method longRunningOperations() {
 *     List long running operations.
 *
 *     Example:
 *     ```
 *     $operations = $instance->longRunningOperations();
 *     ```
 *
 *     @param array $options [optional] {
 *         Configuration Options.
 *
 *         @type string $name The name of the operation collection.
 *         @type string $filter The standard list filter.
 *         @type int $pageSize Maximum number of results to return per
 *               request.
 *         @type int $resultLimit Limit the number of results returned in total.
 *               **Defaults to** `0` (return all results).
 *         @type string $pageToken A previously-returned page token used to
 *               resume the loading of results from a specific point.
 *     }
 *     @return ItemIterator<InstanceConfiguration>
 * }
 */
class Instance
{
    use LROTrait;

    const DEFAULT_NODE_COUNT = 1;

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
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * @var array
     */
    private $info;

    /**
     * Create an object representing a Cloud Bigtable instance.
     *
     * @param ConnectionInterface $connection The connection to the
     *        Cloud Bigtable Admin API.
     * @param LongRunningConnectionInterface $lroConnection An implementation
     *        mapping to methods which handle LRO resolution in the service.
     * @param array $lroCallables
     * @param string $projectId The project ID.
     * @param string $name The instance name or ID.
     * @param bool $returnInt64AsObject [optional] If true, 64 bit integers will be
     *        returned as a {@see Google\Cloud\Core\Int64} object for 32 bit platform
     *        compatibility. **Defaults to** false.
     * @param array $info [optional] A representation of the instance object.
     */
    public function __construct(
        ConnectionInterface $connection,
        LongRunningConnectionInterface $lroConnection,
        array $lroCallables,
        $projectId,
        $name,
        $returnInt64AsObject = false,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedInstanceName($name, $projectId);
        $this->returnInt64AsObject = $returnInt64AsObject;
        $this->info = $info;
        $this->setLroProperties($lroConnection, $lroCallables, $this->name);
    }

    /**
     * Return the instance name.
     *
     * Example:
     * ```
     * $name = $instance->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Return the service representation of the instance.
     *
     * This method may require a service call.
     *
     * Example:
     * ```
     * $info = $instance->info();
     * echo $info['nodeCount'];
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Check if the instance exists.
     *
     * This method requires a service call.
     *
     * Example:
     * ```
     * if ($instance->exists()) {
     *    echo 'Instance exists!';
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
     * Fetch a fresh representation of the instance from the service.
     *
     * Example:
     * ```
     * $info = $instance->reload();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#google.bigtable.admin.v2.GetInstanceRequest GetInstanceRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        $this->info = $this->connection->getInstance($options + [
            'name' => $this->name,
            'projectId' => $this->projectId
        ]);

        return $this->info;
    }

    /**
     * Create a new instance.
     *
     * Example:
     * ```
     * $operation = $instance->create($configuration);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#CreateInstanceRequest CreateInstanceRequest
     *
     * @param InstanceConfiguration $config The configuration to use
     * @param string $name The instance name
     * @param string $cluster The cluster ID.
     * @param string $location The location ID.
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
    public function create(InstanceConfiguration $config, $cluster, $location, array $options = [])
    {
        $instanceId = InstanceAdminClient::parseName($this->name)['instance'];
        $projectName = InstanceAdminClient::projectName($this->projectId);
        $locationName = InstanceAdminClient::locationName($this->projectId, $location);
        $serverNodes = isset($options['nodeCount']) ? $options['nodeCount'] : 1;

        $operation = $this->connection->createInstance([
            'parent' => $projectName,
            'instanceId' => $instanceId,
            'instance' => [
                'displayName' => $instanceId,
                'type' => Instance_Type::PRODUCTION,
                'labels' => []
            ],
            'clusters' => [
                $cluster => [
                    'location' => $locationName,
                    'serveNodes' => $serverNodes
                ]
            ]
        ]+ $options);
        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Convert the simple instance name to a fully qualified name.
     *
     * @param string $name The instance name.
     * @param string $project The project ID.
     * @return string
     */
    private function fullyQualifiedInstanceName($name, $project)
    {
        try {
            return InstanceAdminClient::instanceName(
                $project,
                $name
            );
        } catch (ValidationException $e) {
            return $name;
        }
    }

    /**
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info
        ];
    }
}
