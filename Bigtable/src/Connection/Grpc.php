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
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;

/**
 * Connection to Cloud Bigtable over GRPC
 */
class Grpc implements ConnectionInterface
{
    use GrpcTrait;
    use OperationResponseTrait;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var BigtableClient
     */
    private $bigtableClient;

    /**
     * @var BigtableTableAdminClient
     */
    private $bigtableTableAdminClient;

    /**
     * @var BigtableInstanceAdminClient
     */
    private $bigtableInstanceAdminClient;

    /**
     * @var array
     */
    private $lroResponseMappers = [
        [
            'method' => 'createInstance',
            'typeUrl' => 'type.googleapis.com/google.bigtable.admin.v2.CreateInstanceMetadata',
            'message' => Instance::class
        ]
    ];

    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer();
        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $this->bigtableClient = new BigtableClient();
        $this->bigtableTableAdminClient = new BigtableTableAdminClient();
        $this->bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
    }

    /**
     * @param array $args
     * @return array
     */
    public function createInstance(array $args)
    {
        $parent = $this->pluck('parent', $args);
        $instance = $this->pluck('instance', $args);
        $clusters = $this->pluck('clusters', $args);
        $response = $this->send([$this->bigtableInstanceAdminClient, 'createInstance'], [
            $parent,
            $this->pluck('instanceId', $args),
            $this->instanceObject($instance),
            array_map([$this, 'clusterObject'], $clusters),
            $this->addResourcePrefixHeader($args, $parent)
        ]);

        return $this->operationToArray(
            $response,
            $this->serializer,
            $this->lroResponseMappers
        );
    }

    /**
     * @param array $instance
     * @return Instance
     */
    private function instanceObject(array $instance)
    {
        return $this->serializer->decodeMessage(
            new Instance(),
            $this->pluckArray([
                'displayName',
                'type',
                'labels'
            ], $instance)
        );
    }

    /**
     * @param array $cluster
     * @return Cluster
     */
    private function clusterObject(array $cluster)
    {
        return $this->serializer->decodeMessage(
            new Cluster(),
            $this->pluckArray([
                'location',
                'serveNodes',
                'defaultStorageType'
            ], $cluster)
        );
    }

    /**
     * @param array $args
     */
    public function getInstance(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function listInstances(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function updateInstance(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
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
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function getCluster(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function listClusters(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function updateCluster(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function deleteCluster(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function createAppProfile(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function getAppProfile(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function listAppProfiles(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function updateAppProfile(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function deleteAppProfile(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
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
        return $this->send([$this->bigtableInstanceAdminClient, 'setIamPolicy'], [
            $resource,
            $this->pluck('policy', $args),
            $this->addResourcePrefixHeader($args, $resource)
        ]);
    }

    /**
     * @param array $args
     */
    public function testIamPermissions(array $args)
    {
        $resource = $this->pluck('resource', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'testIamPermissions'], [
            $resource,
            $this->pluck('permissions', $args),
            $this->addResourcePrefixHeader($args, $resource)
        ]);
    }

    /**
     * @todo add options to create ColumnFamilies.
     * @param array $args
     */
    public function createTable(array $args)
    {
        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableTableAdminClient, 'createTable'], [
            $parent,
            $this->pluck('tableId', $args),
            new Table(),
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function createTableFromSnapshot(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function listTables(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function getTable(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function deleteTable(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminClient, 'deleteTable'], [
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
        return $this->send([$this->bigtableTableAdminClient, 'modifyColumnFamilies'], [
            $name,
            array_map([$this,'columnFamilyModificationObject'], $modifications),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $modification
     * @return ModifyColumnFamiliesRequest_Modification
     */
    private function columnFamilyModificationObject(array $modification)
    {
        if (isset($modification['create'])) {
            $modification['create'] = $this->columnFamilyObject($modification['create']);
        } elseif (isset($modification['update'])) {
            $modification['update'] = $this->columnFamilyObject($modification['update']);
        } elseif (isset($modification['drop'])) {
            $modification['drop'] = true;
        }
        return $this->serializer->decodeMessage(
            new ModifyColumnFamiliesRequest_Modification(),
            $modification
        );
    }

    /**
     *
     * @todo add GCRule
     *
     * @param array $columnFamily
     * @return ColumnFamily
     */
    private function columnFamilyObject(array $columnFamily)
    {
        return $this->serializer->decodeMessage(
            new ColumnFamily(),
            []
        );
    }

    /**
     * @param array $args
     */
    public function dropRowRange(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function checkConsistency(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminClient, 'checkConsistency'], [
            $name,
            $this->pluck('consistencyToken', $args),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function generateConsistencyToken(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminClient, 'generateConsistencyToken'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function snapshotTable(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function getSnapshot(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function listSnapshots(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function deleteSnapshot(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function readRow(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function readRows(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function sampleRowKeys(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function mutateRow(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function mutateRows(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function checkAndMutateRow(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function readModifyWriteRow(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function getOperation(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function cancelOperation(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function deleteOperation(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function listOperations(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
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
