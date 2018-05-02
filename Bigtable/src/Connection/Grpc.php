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

namespace Google\Cloud\Bigtable\Connection;

use Google\ApiCore\Serializer;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Gapic\BigtableTableAdminGapicClient;
use Google\Cloud\Bigtable\V2\Gapic\BigtableGapicClient;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;

/**
 * Connection to Cloud Bigtable over GRPC
 */
class Grpc implements ConnectionInterface
{
    use GrpcTrait;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var BigtableInstanceAdminClient
     */
    private $bigtableInstanceAdminClient;

    /**
     * @var bigtableGapicClient
     */
    private $bigtableGapicClient;

    /**
     * @var BigtableTableAdminGapicClient
     */
    private $bigtableTableAdminGapicClient;
    
    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer();
        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $this->bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
        $this->bigtableGapicClient = new BigtableGapicClient();
        $this->bigtableTableAdminGapicClient = new BigtableTableAdminGapicClient();
    }

    /**
     * @param array $args
     */
    public function createInstance(array $args)
    {
        $parent = $this->pluck('parent', $args);
        $instanceId = $this->pluck('instanceId', $args);
        $instance = $this->pluck('instance', $args);
        $clusters = $this->pluck('clusters', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'createInstance'], [
            $parent,
            $instanceId,
            $instance,
            $clusters,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function getInstance(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'getInstance'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function listInstances(array $args)
    {
        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'listInstances'], [
            $parent,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function updateInstance(array $args)
    {
        $name = $this->pluck('name', $args);
        $displayName = $this->pluck('displayName', $args);
        $type = $this->pluck('type', $args);
        $labels = $this->pluck('labels', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'updateInstance'], [
            $name,
            $displayName,
            $type,
            $labels,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteInstance(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'deleteInstance'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function createCluster(array $args)
    {
        $parent = $this->pluck('parent', $args);
        $clusterId = $this->pluck('clusterId', $args);
        $cluster = $this->pluck('cluster', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'createCluster'], [
            $parent,
            $clusterId,
            $cluster,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function getCluster(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'getCluster'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function listClusters(array $args)
    {
        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'listClusters'], [
            $parent,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function updateCluster(array $args)
    {
        $name = $this->pluck('name', $args);
        $location = $this->pluck('location', $args);
        $serveNodes = $this->pluck('serveNodes', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'updateCluster'], [
            $name,
            $location,
            $serveNodes,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteCluster(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'deleteCluster'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function createAppProfile(array $args)
    {
        $parent = $this->pluck('parent', $args);
        $appProfileId = $this->pluck('appProfileId', $args);
        $appProfile = $this->pluck('appProfile', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'createAppProfile'], [
            $parent,
            $appProfileId,
            $appProfile,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function getAppProfile(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'getAppProfile'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function listAppProfiles(array $args)
    {
        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'listAppProfiles'], [
            $parent,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function updateAppProfile(array $args)
    {
        $name = $this->pluck('name', $args);
        $appProfile = $this->pluck('appProfile', $args);
        $updateMask = $this->pluck('updateMask', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'updateAppProfile'], [
            $appProfile,
            $updateMask,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteAppProfile(array $args)
    {
        $name = $this->pluck('name', $args);
        $ignoreWarnings = $this->pluck('ignoreWarnings', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'deleteAppProfile'], [
            $name,
            $ignoreWarnings,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function getIamPolicy(array $args)
    {
        $resource = $this->pluck('resource', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'getIamPolicy'], [
            $resource,
            $this->addResourcePrefixHeader($args, $resource)
        ]);
    }

    /**
     * @param array $args
     */
    public function setIamPolicy(array $args)
    {
        $resource = $this->pluck('resource', $args);
        $policy = $this->pluck('policy', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'setIamPolicy'], [
            $resource,
            $policy,
            $this->addResourcePrefixHeader($args, $resource)
        ]);
    }

    /**
     * @param array $args
     */
    public function createTable(array $args)
    {
        $parent = $this->pluck('parent', $args);
        $tableId = $this->pluck('tableId', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'createTable'], [
            $parent,
            $tableId,
            new Table(),
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function createTableFromSnapshot(array $args)
    {
        $parent = $this->pluck('parent', $args);
        $tableId = $this->pluck('tableId', $args);
        $sourceSnapshot = $this->pluck('sourceSnapshot', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'createTableFromSnapshot'], [
            $parent,
            $tableId,
            $sourceSnapshot,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function listTables(array $args)
    {
        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'listTables'], [
            $parent,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function getTable(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'getTable'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteTable(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'deleteTable'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function modifyColumnFamilies(array $args)
    {
        $name = $this->pluck('name', $args);
        $modifications = $this->pluck('modifications', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'modifyColumnFamilies'], [
            $name,
            $modifications,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function dropRowRange(array $args)
    {
        $name = $this->pluck('name', $args);
        $optionalArgs = $this->pluck('optionalArgs', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'dropRowRange'], [
            $name,
            $optionalArgs,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function snapshotTable(array $args)
    {
        $name = $this->pluck('name', $args);
        $cluster = $this->pluck('cluster', $args);
        $snapshotId = $this->pluck('snapshotId', $args);
        $description = $this->pluck('description', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'snapshotTable'], [
            $name,
            $cluster,
            $snapshotId,
            $description,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function getSnapshot(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'getSnapshot'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function listSnapshots(array $args)
    {
        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'listSnapshots'], [
            $parent,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteSnapshot(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminGapicClient, 'deleteSnapshot'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function readRows(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        return $this->send([$this->bigtableGapicClient, 'readRows'], [
            $tableName,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     */
    public function sampleRowKeys(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        return $this->send([$this->bigtableGapicClient, 'sampleRowKeys'], [
            $tableName,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     */
    public function mutateRow(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $rowKey = $this->pluck('rowKey', $args);
        $mutations = $this->pluck('mutations', $args);
        return $this->send([$this->bigtableGapicClient, 'mutateRow'], [
            $tableName,
            $rowKey,
            $mutations,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     */
    public function mutateRows(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $entries = $this->pluck('entries', $args);
        return $this->send([$this->bigtableGapicClient, 'mutateRows'], [
            $tableName,
            $entries,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     */
    public function checkAndMutateRow(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $rowKey = $this->pluck('rowKey', $args);
        $optionalArgs = $this->pluck('optionalArgs', $args);
        return $this->send([$this->bigtableGapicClient, 'checkAndMutateRow'], [
            $tableName,
            $rowKey,
            $optionalArgs,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     */
    public function readModifyWriteRow(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $rowKey = $this->pluck('rowKey', $args);
        $rules = $this->pluck('rules', $args);
        return $this->send([$this->bigtableGapicClient, 'readModifyWriteRow'], [
            $tableName,
            $rowKey,
            $rules,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * Add the `google-cloud-resource-prefix` header value to the request.
     *
     * @param array $args
     * @param string $value
     * @return array
     */
    private function addResourcePrefixHeader(array $args, $value)
    {
        $args['headers'] = [
            'google-cloud-resource-prefix' => [$value]
        ];
        return $args;
    }
}
