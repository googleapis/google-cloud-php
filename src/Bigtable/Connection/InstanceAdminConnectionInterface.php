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

use Google\Cloud\Bigtable\ConnectionInterface;

/**
 * Connection to Bigtable InstanceAdmin API.
 */
interface InstanceAdminConnectionInterface extends ConnectionInterface
{

    /**
     * Create an instance within a project.
     *
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
     * @return TBD
     *
     */
    public function createInstance($instanceId, $locationId, $clusterId, array $optionalArgs = []);

    /**
     * Gets information about an instance.
     *
     * @param string $instanceId   The unique name of the requested instance.
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
     * @return TBD
     *
     */
    public function getInstance($instanceId, array $optionalArgs = []);

    /**
     * Updates an instance within a project.
     *
     * @param string $displayName  The descriptive name for this instance as it appears in UIs.
     *                             Can be changed at any time, but should be kept globally unique
     *                             to avoid confusion.
     * @param int    $type         The type of the instance. Defaults to `PRODUCTION`.
     *                             For allowed values, use constants defined on
     *                             {@see \Google\Bigtable\Admin\V2\Instance_Type}
     * @param array  $labels      Labels are a flexible and lightweight mechanism for organizing cloud
     *                            resources into groups that reflect a customer's organizational needs and
     *                            deployment strategies. They can be used to filter resources and aggregate
     *                            metrics.
     *
     * * Label keys must be between 1 and 63 characters long and must conform to
     *   the regular expression: `[\p{Ll}\p{Lo}][\p{Ll}\p{Lo}\p{N}_-]{0,62}`.
     * * Label values must be between 0 and 63 characters long and must conform to
     *   the regular expression: `[\p{Ll}\p{Lo}\p{N}_-]{0,63}`.
     * * No more than 64 labels can be associated with a given resource.
     * * Keys and values must both be under 128 bytes.
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
     * @return TBD
     *
     */
    public function updateInstance($displayName, $type, $labels, array $optionalArgs = []);

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
     * @return TBD
     *
     */
    public function listInstances(array $optionalArgs = []);

    /**
     * Delete an instance from a project.
     *
     * @param string $instanceId   The unique name of the requested instance.
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
     * @return TBD
     *
     */
    public function deleteInstance($instanceId, array $optionalArgs = []);

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
     * @return TBD
     *
     */
    public function createCluster($locationId, $clusterId, array $optionalArgs = []);

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
     * @return TBD
     *
     */
    public function getCluster($clusterId, array $optionalArgs = []);

    /**
     * Lists information about clusters in an instance.
     *
     * @param string $instanceid      {
     *                              Optional.   instanceid
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
     * @return TBD
     *
     */
    public function listClusters($instanceid = '', array $optionalArgs = []);

    /**
     * Updates a cluster within an instance.
     *
     * @param string $clusterId    (`OutputOnly`)
     *                             The unique id of the cluster. Ex. us-central1-c
     * @param string $locationId   (`CreationOnly`)
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
     * @return TBD
     *
     */
    public function updateCluster($clusterId, $locationId, $serveNodes, array $optionalArgs = []);

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
     * @return TBD
     *
     */
    public function deleteCluster($clusterId, array $optionalArgs = []);
}
