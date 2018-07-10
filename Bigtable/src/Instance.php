<?php
/**
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

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Cloud\Bigtable\Admin\V2\Instance_State;
use Google\Cloud\Bigtable\Admin\V2\StorageType;
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
 */
class Instance
{
    use LROTrait;

    const STORAGE_TYPE_UNSPECIFIED = StorageType::STORAGE_TYPE_UNSPECIFIED;
    const STORAGE_TYPE_SSD = StorageType::SSD;
    const STORAGE_TYPE_HDD = StorageType::HDD;

    const INSTANCE_TYPE_UNSPECIFIED = Instance_Type::TYPE_UNSPECIFIED;
    const INSTANCE_TYPE_PRODUCTION = Instance_Type::PRODUCTION;
    const INSTANCE_TYPE_DEVELOPMENT = Instance_Type::DEVELOPMENT;

    const STATE_TYPE_STATE_NOT_KNOWN = Instance_State::STATE_NOT_KNOWN;
    const STATE_TYPE_READY = Instance_State::READY;
    const STATE_TYPE_CREATING = Instance_State::CREATING;

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
    private $id;

    /**
     * @var string
     */
    private $name;

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
     * @param array $lroCallables An collection of form [(string) typeUrl, (callable) callable]
     *        providing a function to invoke when an operation completes. The
     *        callable Type should correspond to an expected value of
     *        operation.metadata.typeUrl.
     * @param string $projectId The project ID.
     * @param string $instanceId The instance ID.
     * @param array $info [optional] A representation of the instance object.
     * @throws \InvalidArgumentException if invalid argument
     */
    public function __construct(
        ConnectionInterface $connection,
        LongRunningConnectionInterface $lroConnection,
        array $lroCallables,
        $projectId,
        $instanceId,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        
        $this->validate($instanceId, 'instance');
        $this->name = InstanceAdminClient::instanceName($projectId, $instanceId);
        $this->id = $instanceId;
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
     * Return the instance id.
     *
     * Example:
     * ```
     * $instanceId = $instance->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Return the service representation of the instance.
     *
     * This method may require a service call.
     *
     *
     * @param array $options [optional] Configuration options.
     */
    public function info(array $options = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * Check if the instance exists.
     *
     * This method requires a service call.
     *
     *
     * @param array $options [optional] Configuration options.
     */
    public function exists(array $options = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * Fetch a fresh representation of the instance from the service.
     *
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#google.bigtable.admin.v2.GetInstanceRequest GetInstanceRequest
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#instance Instance
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     */
    public function reload(array $options = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * Return the instance state.
     *
     * When instances are created or updated, they may take some time before
     * they are ready for use. This method allows for checking whether an
     * instance is ready.
     *
     *
     * @param array $options [optional] Configuration options.
     */
    public function state(array $options = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * Example:
     * ```
     * use Google\Cloud\Bigtable\BigtableClient;
     * $bigtable = new BigtableClient();
     * $operation = $instance->create(
     *     [$bigtable->buildClusterMetadata('my-cluster', 'my-location', null, 3)]
     * );
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/
     *     google.bigtable.admin.v2#CreateInstanceRequest CreateInstanceRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array[] $clusterMetadataList Use {@see Google\Cloud\Bigtable\BigtableClient::buildClusterMetadata()}
     *        to create properly formatted cluster configurations.
     * @param array $options [optional] {
     *     Configuration options
     *     @type string $displayName **Defaults to** the value of $instanceId.
     *     @type array $labels as key/value pair ['foo' => 'bar']. For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://cloudplatform.googleblog.com/2015/10/using-labels-to-organize-Google-Cloud-Platform-resources.html).
     *     @type int $type Possible values are represented by the following constants:
     *           `Google\Cloud\Bigtable\Instance::INSTANCE_TYPE_PRODUCTION`,
     *           `Google\Cloud\Bigtable\Instance::INSTANCE_TYPE_DEVELOPMENT` and
     *           `Google\Cloud\Bigtable\Instance::INSTANCE_TYPE_UNSPECIFIED`.
     *           **Defaults to** using `Google\Cloud\Bigtable\Instance::INSTANCE_TYPE_UNSPECIFIED`.
     * }
     * @return LongRunningOperation<Instance>
     * @throws \InvalidArgumentException
     */
    public function create(array $clusterMetadataList, array $options = [])
    {
        if (empty($clusterMetadataList)) {
            throw new \InvalidArgumentException('At least one clusterMetadata must be passed');
        }
        $projectName = InstanceAdminClient::projectName($this->projectId);
        $displayName = isset($optins['displayName']) ? $optins['displayName'] : $this->id;
        $labels = isset($optins['labels']) ? $optins['labels'] : [];
        $type = isset($optins['type']) ? $optins['type'] : self::INSTANCE_TYPE_UNSPECIFIED;

        $clustersArray = [];
        foreach ($clusterMetadataList as $value) {
            if (!isset($value['clusterId'])) {
                throw new \InvalidArgumentException('Cluster id must be set');
            }
            $this->validate($value['clusterId'], 'cluster');
            $clusterId = $value['clusterId'];

            if (!isset($value['locationId'])) {
                throw new \InvalidArgumentException('Location id must be set');
            }
            $this->validate($value['locationId'], 'location');
            $locationId = $value['locationId'];

            $value['location'] = InstanceAdminClient::locationName($this->projectId, $locationId);

            $value['defaultStorageType'] = isset($value['storageType'])
                ? $value['storageType']
                : self::STORAGE_TYPE_UNSPECIFIED;

            if ($type == self::INSTANCE_TYPE_DEVELOPMENT) {
                unset($value['serveNodes']);
            } elseif (!isset($value['serveNodes']) || $value['serveNodes'] <= 0) {
                throw new \InvalidArgumentException('When creating Production instance, serveNodes must be > 0');
            }
            // `$clustersArray` must be keyed by the cluster ID.
            $clustersArray[$clusterId] = $value;
        }

        $operation = $this->connection->createInstance($options + [
            'parent' => $projectName,
            'instanceId' => $this->id,
            'instance' => [
                'displayName' => $displayName,
                'type' => $type,
                'labels' => $labels
            ],
            'clusters' => $clustersArray
        ]);

        return $this->resumeOperation($operation['name'], $operation);
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
            'instanceId' => $this->id,
            'name' => $this->name,
            'info' => $this->info
        ];
    }

    /**
     * Check invalid exception
     *
     * @param string $value value to be validated for emptiness or containing '/' character.
     * @param string $text type of value to be validated.
     * @throws \InvalidArgumentException
     */
    private function validate($value, $text)
    {
        if (empty($value) || strpos($value, '/') !== false) {
            throw new \InvalidArgumentException("Please pass just {$text}Id as '{$text}-id'");
        }
    }
}
