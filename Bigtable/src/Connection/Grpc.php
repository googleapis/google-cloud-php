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
use Google\Cloud\Bigtable\Admin\V2\GcRule;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification as Modification;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation_SetCell;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;

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
            'typeUrl' => 'type.googleapis.com/google.bigtable.admin.instance.v2.CreateInstanceMetadata',
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
        throw new \BadMethodCallException('This method is not implemented yet');
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
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function setIamPolicy(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function testIamPermissions(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function createTable(array $args)
    {
        $parent = $this->pluck('parent', $args);
        $columnFamilies = $this->pluck('columnFamilies', $args);
        $mapField['column_families'] = $this->mapFieldObject($columnFamilies);
        return $this->send([$this->bigtableTableAdminClient, 'createTable'], [
            $parent,
            $this->pluck('tableId', $args),
            $this->tableObject($mapField),
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     * @return Table
     */
    private function tableObject(array $args)
    {
        return $this->serializer->decodeMessage(
            new Table(),
            $this->pluckArray([
                'column_families'
            ], $args)
        );
    }

    /**
     * @param array $args
     * @return MapField
     */
    private function mapFieldObject(array $args)
    {
        $mapField = new MapField(GPBType::STRING, GPBType::MESSAGE, ColumnFamily::class);
        foreach ($args as $key => $value) {
            $id = $this->pluck('id', $value);
            $mapField[$id] = $this->columnFamilyObject($value);
        }
        return $mapField;
    }

    /**
     * @param array $args
     * @return ColumnFamily
     */
    private function columnFamilyObject(array $args)
    {
        $gcRule['gc_rule'] = $this->serializer->decodeMessage(
            new GcRule(),
            $this->pluckArray([
                'max_num_versions'
            ], $args)
        );

        return $this->serializer->decodeMessage(
            new ColumnFamily(),
            $this->pluckArray([
                'gc_rule'
            ], $gcRule)
        );
    }

    /**
     * @param array $args
     */
    public function createTableFromSnapshot(array $args)
    {
        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableTableAdminClient, 'createTableFromSnapshot'], [
            $parent,
            $this->pluck('tableId', $args),
            $this->pluck('sourceSnapshot', $args),
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function listTables(array $args)
    {
        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableTableAdminClient, 'listTables'], [
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
        return $this->send([$this->bigtableTableAdminClient, 'getTable'], [
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
        $columnFamilies = $this->pluck('columnFamilies', $args);
        return $this->send([$this->bigtableTableAdminClient, 'modifyColumnFamilies'], [
            $name,
            array_map([$this, 'modifications'], $columnFamilies),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     * @return ModifyColumnFamiliesRequest_Modification
     */
    private function modifications($args)
    {
        $action = $this->pluck('action', $args);
        $columnFamily['id'] = $this->pluck('id', $args);
        if ($action == 'drop') {
            $columnFamily['drop'] = true;
            return $this->serializer->decodeMessage(
                new Modification(),
                $this->pluckArray([
                    'id',
                    'drop'
                ], $columnFamily)
            );
        } else {
            $columnFamily['create'] = $this->columnFamilyObject($args);
            return $this->serializer->decodeMessage(
                new Modification(),
                $this->pluckArray([
                    'id',
                    'create'
                ], $columnFamily)
            );
        }
    }

    /**
     * @param array $args
     */
    public function dropRowRange(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminClient, 'dropRowRange'], [
            $name,
            $this->pluck('optionalArgs', $args),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function checkConsistency(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function generateConsistencyToken(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function snapshotTable(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminClient, 'snapshotTable'], [
            $name,
            $this->pluck('cluster', $args),
            $this->pluck('snapshotId', $args),
            $this->pluck('description', $args),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function getSnapshot(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminClient, 'getSnapshot'], [
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
        return $this->send([$this->bigtableTableAdminClient, 'listSnapshots'], [
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
        return $this->send([$this->bigtableTableAdminClient, 'deleteSnapshot'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
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
