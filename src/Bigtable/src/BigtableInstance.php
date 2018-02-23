<?php
/*
 * Copyright 2017, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\src;

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Cloud\Bigtable\Admin\V2\StorageType;
use Google\Protobuf\Internal\MapField;
use Google\Protobuf\Internal\GPBType;

use Google\Protobuf\FieldMask;

/**
*
*/
class BigtableInstance
{
    private $InstanceAdmin;
    private $projectId;
    private $instanceId;

    /**
     * Constructor.
     * @param array $args {
     *
     *     @param string $projectId
     *
     *     @param string $instanceId
     *
     */
    public function __construct($args)
    {
        $this->projectId = $args['projectId'];
        $this->instanceId = $args['instanceId'];
        $this->InstanceAdmin = new BigtableInstanceAdminClient();
    }
    
    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @return string The formatted project resource.
     */
    private function projectName()
    {
        $formattedParent = BigtableInstanceAdminClient::projectName($this->projectId);
        return $formattedParent;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a instance resource.
     *
     * @param string $instanceId    Optional.
     *
     * @return string The formatted instance resource.
     */
    private function instanceName($instanceId = '')
    {
        if ($instanceId == '') {
            $instanceId = $this->instanceId;
        }
        $formattedParent = BigtableInstanceAdminClient::instanceName($this->projectId, $instanceId);
        return $formattedParent;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location resource.
     *
     * @param string $locationId
     *
     * @return string The formatted location resource.
     */
    private function locationName($locationId)
    {
        return BigtableInstanceAdminClient::locationName($this->projectId, $locationId);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a cluster resource.
     *
     * @param string $clusterId
     *
     * @return string The formatted cluster resource.
     */
    private function clusterName($clusterId)
    {
        return BigtableInstanceAdminClient::clusterName($this->projectId, $this->instanceId, $clusterId);
    }

    /**
     * Gets information about an instance.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Instance
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getInstance($optionalArgs = [])
    {
        $formattedName = $this->instanceName();
        $response = $this->InstanceAdmin->getInstance($formattedName);
        return $response;
    }

    /**
     * Create an instance within a project.
     * @param string   $instanceId   The ID to be used when referring to the new instance within its project,
     *                               e.g., just `myinstance` rather than
     *                               `projects/myproject/instances/myinstance`.
     *
     * @param string   $locationId   The unique location id.
     *
     * @param string   $clusterId    The unique id of the cluster to be create.
     *
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\GAX\OperationResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function createInstance($instanceId, $locationId, $clusterId, $optionalArgs = [])
    {
        $parent = $this->projectName();
        $formattedLocation = $this->locationName($locationId);

        $instance = new Instance();
        $instance->setDisplayName($instanceId);
        $instance->setType(Instance_Type::PRODUCTION);

        $clusters = new Cluster();
        $clusters->setName($clusterId);
        $clusters->setDefaultStorageType(2);
        $clusters->setLocation($formattedLocation);
        $MapField = new MapField(GPBType::STRING, GPBType::MESSAGE, Cluster::class);
        $MapField[$clusterId] = $clusters;

        $instanceId = str_replace(' ', '-', $instanceId);
        $Instance = $this->InstanceAdmin->createInstance($parent, $instanceId, $instance, $MapField, $optionalArgs);
        return $Instance;
    }

    /**
     * Updates an instance within a project.
     *
     * @param string $displayName  The descriptive name for this instance as it appears in UIs.
     *                             Can be changed at any time, but should be kept globally unique
     *                             to avoid confusion.
     * @param int    $type         The type of the instance. Defaults to `PRODUCTION`.
     *                             For allowed values, use constants defined on
     *                             {@see \Google\Bigtable\Admin\V2\Instance_Type}
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $state
     *          (`OutputOnly`)
     *          The current state of the instance.
     *          For allowed values, use constants defined on {@see \Google\Bigtable\Admin\V2\Instance_State}
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Bigtable\Admin\V2\Instance
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function updateInstance($displayName, $type, $optionalArgs = [])
    {
        $name = $this->instanceName();
        $Instance = $this->InstanceAdmin->updateInstance($name, $displayName, $type, $optionalArgs);
        return $Instance;
    }

    /**
     * Lists information about instances in a project.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $pageToken
     *          The value of `next_page_token` returned by a previous call.
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Bigtable\Admin\V2\ListInstancesResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function listInstances($optionalArgs = [])
    {
        $parent = $this->projectName();
        $ListInstances = $this->InstanceAdmin->listInstances($parent, $optionalArgs);
        return $ListInstances;
    }

    /**
     * Delete an instance from a project.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Protobuf\GPBEmpty
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function deleteInstance($optionalArgs = [])
    {
        $formattedParent = $this->instanceName();
        $response = $this->InstanceAdmin->deleteInstance($formattedParent, $optionalArgs);
        return $response;
    }

    /**
     * Creates a cluster within an instance.
     *
     * @param string  $locationId
     *
     * @param string  $clusterId    The ID to be used when referring to the new cluster within its instance,
     *                              e.g., just `mycluster` rather than
     *                              `projects/myproject/instances/myinstance/clusters/mycluster`.
     *
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function createCluster($locationId, $clusterId, $optionalArgs = [])
    {
        $formattedParent = $this->instanceName();
        $cluster = new Cluster();
        $cluster->setLocation($this->locationName($locationId));
        $cluster->setDefaultStorageType(StorageType::HDD);

        $clusterId = str_replace(' ', '-', $clusterId);
        $operationResponse = $this->InstanceAdmin->createCluster($formattedParent, $clusterId, $cluster, $optionalArgs);
        return $operationResponse;
    }

    /**
     * Gets information about a cluster.
     *
     * @param string $clusterId
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Cluster
     *
     * @throws ApiException if the remote call fails
     */
    public function getCluster($clusterId, $optionalArgs = [])
    {
        $formattedName = $this->clusterName($clusterId);
        $cluster = $this->InstanceAdmin->getCluster($formattedName, $optionalArgs);
        return $cluster;
    }

    /**
     * Lists information about clusters in an instance.
     *
     * @param string $Instanceid      {
     *                              Optional.   Instanceid
     *                             Use `<instance> = '-'` to list Clusters for all Instances in a project,
     *                             e.g., `projects/myproject/instances/-`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $pageToken
     *          The value of `next_page_token` returned by a previous call.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\ListClustersResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function listClusters($Instanceid = '', $optionalArgs = [])
    {
        $instanceName = $this->instanceName($Instanceid);
        $clusters = $this->InstanceAdmin->listClusters($instanceName, $optionalArgs);
        return $clusters;
    }

    /**
     * Updates a cluster within an instance.
     *
     * @param string $clusterId    (`OutputOnly`)
     *                             The unique id of the cluster. Ex. us-central1-c
     * @param string $location     (`CreationOnly`)
     *                             The location where this cluster's nodes and storage reside. For best
     *                             performance, clients should be located as close as possible to this
     *                             cluster. Currently only zones are supported. Ex. cluster1
     * @param int    $serveNodes   The number of nodes allocated to this cluster. More nodes enable higher
     *                             throughput and more consistent performance.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $state
     *          (`OutputOnly`)
     *          The current state of the cluster.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Cluster_State}
     *     @type int $defaultStorageType
     *          (`CreationOnly`)
     *          The type of storage used by this cluster to serve its
     *          parent instance's tables, unless explicitly overridden.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\StorageType}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function updateCluster($clusterId, $location, $serveNodes, $optionalArgs = [])
    {
        $formattedName = $this->clusterName($clusterId);
        $location = $this->locationName($location);
        $operationResponse = $this->InstanceAdmin->updateCluster($formattedName, $location, $serveNodes, $optionalArgs);
        return $operationResponse;
    }

    /**
     * Deletes a cluster from an instance.
     *
     * @param string $clusterId         The unique id of the cluster to be deleted.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     */
    public function deleteCluster($clusterId, $optionalArgs = [])
    {
        $formattedName = $this->clusterName($clusterId);
        $this->InstanceAdmin->deleteCluster($formattedName);
    }
}
