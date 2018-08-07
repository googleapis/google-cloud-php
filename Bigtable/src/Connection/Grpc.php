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

namespace Google\Cloud\Bigtable\Connection;

use Google\ApiCore\Serializer;
use Google\Cloud\Bigtable\Admin\V2\AppProfile;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\CreateTableRequest_Split;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRule;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;

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
        ],
        [
            'method' => 'createTableFromSnapshot',
            'typeUrl' => 'type.googleapis.com/google.bigtable.admin.v2.CreateTableFromSnapshotMetadata',
            'message' => Table::class
        ],
        [
            'method' => 'createCluster',
            'typeUrl' => 'type.googleapis.com/google.bigtable.admin.v2.CreateClusterMetadata',
            'message' => Cluster::class
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
        return $this->send([$this->bigtableInstanceAdminClient, 'updateInstance'], [
            $name,
            $this->pluck('displayName', $args),
            $this->pluck('type', $args),
            $this->pluck('labels', $args),
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
        $response = $this->send([$this->bigtableInstanceAdminClient, 'createCluster'], [
            $parent,
            $this->pluck('clusterId', $args),
            $this->clusterObject(
                $this->pluck('cluster', $args)
            ),
            $this->addResourcePrefixHeader($args, $parent)
        ]);

        return $this->operationToArray(
            $response,
            $this->serializer,
            $this->lroResponseMappers
        );
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
        return $this->send([$this->bigtableInstanceAdminClient, 'updateCluster'], [
            $name,
            $this->pluck('location', $args),
            $this->pluck('serveNodes', $args),
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
        return $this->send([$this->bigtableInstanceAdminClient, 'createAppProfile'], [
            $parent,
            $this->pluck('appProfileId', $args),
            $this->appProfileObject(
                $this->pluck('appProfile', $args)
            ),
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
        $appProfile = $this->appProfileObject(
            $this->pluck('appProfile', $args)
        );
        return $this->send([$this->bigtableInstanceAdminClient, 'updateAppProfile'], [
            $appProfile,
            $this->fieldMaskObject(
                $this->pluck('updateMask', $args)
            ),
            $this->addResourcePrefixHeader($args, $appProfile->getName())
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteAppProfile(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableInstanceAdminClient, 'deleteAppProfile'], [
            $name,
            $this->pluck('ignoreWarnings', $args),
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
     * @param array $args
     */
    public function createTable(array $args)
    {
        if (isset($args['initialSplits'])) {
            $args['initialSplits'] = array_map(
                [$this, 'createTableRequestSplitObject'],
                $args['initialSplits']
            );
        }

        $parent = $this->pluck('parent', $args);
        return $this->send([$this->bigtableTableAdminClient, 'createTable'], [
            $parent,
            $this->pluck('tableId', $args),
            $this->tableObject(
                $this->pluck('table', $args)
            ),
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function createTableFromSnapshot(array $args)
    {
        $parent = $this->pluck('parent', $args);
        $response = $this->send([$this->bigtableTableAdminClient, 'createTableFromSnapshot'], [
            $parent,
            $this->pluck('tableId', $args),
            $this->pluck('sourceSnapshot', $args),
            $this->addResourcePrefixHeader($args, $parent)
        ]);

        return $this->operationToArray(
            $response,
            $this->serializer,
            $this->lroResponseMappers
        );
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
        $modifications = $this->pluck('modifications', $args);
        return $this->send([$this->bigtableTableAdminClient, 'modifyColumnFamilies'], [
            $name,
            array_map([$this,'columnFamilyModificationObject'], $modifications),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function dropRowRange(array $args)
    {
        $name = $this->pluck('name', $args);
        return $this->send([$this->bigtableTableAdminClient, 'dropRowRange'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
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
        if (isset($args['ttl'])) {
            $args['ttl'] = $this->serializer->decodeMessage(
                new Duration,
                $args['ttl']
            );
        }

        $name = $this->pluck('name', $args);
        $response = $this->send([$this->bigtableTableAdminClient, 'snapshotTable'], [
            $name,
            $this->pluck('cluster', $args),
            $this->pluck('snapshotId', $args),
            $this->pluck('description', $args),
            $this->addResourcePrefixHeader($args, $name)
        ]);

        return $this->operationToArray(
            $response,
            $this->serializer,
            $this->lroResponseMappers
        );
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
    public function readRows(array $args)
    {
        if (isset($args['rows'])) {
            $args['rows'] = $this->rowSetObject($args['rows']);
        }

        if (isset($args['filter'])) {
            $args['filter'] = $this->rowFilterObject($args['filter']);
        }

        $name = $this->pluck('tableName', $args);
        return $this->send([$this->bigtableClient, 'readRows'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function sampleRowKeys(array $args)
    {
        $name = $this->pluck('tableName', $args);
        return $this->send([$this->bigtableClient, 'sampleRowKeys'], [
            $name,
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function mutateRow(array $args)
    {
        $name = $this->pluck('tableName', $args);
        $mutations = $this->pluck('mutations', $args);
        return $this->send([$this->bigtableClient, 'mutateRow'], [
            $name,
            $this->pluck('rowKey', $args),
            array_map([$this, 'mutationObject'], $mutations),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function mutateRows(array $args)
    {
        $name = $this->pluck('tableName', $args);
        $entries = $this->pluck('entries', $args);
        return $this->send([$this->bigtableClient, 'mutateRows'], [
            $name,
            array_map([$this, 'entryObject'], $entries),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function checkAndMutateRow(array $args)
    {
        if (isset($args['predicateFilter'])) {
            $args['predicateFilter'] = $this->rowFilterObject($args['predicateFilter']);
        }

        if (isset($args['trueMutations'])) {
            $args['trueMutations'] = array_map([$this, 'mutationObject'], $args['trueMutations']);
        }

        if (isset($args['falseMutations'])) {
            $args['falseMutations'] = array_map([$this, 'mutationObject'], $args['falseMutations']);
        }

        $name = $this->pluck('tableName', $args);
        return $this->send([$this->bigtableClient, 'checkAndMutateRow'], [
            $name,
            $this->pluck('rowKey', $args),
            $this->addResourcePrefixHeader($args, $name)
        ]);
    }

    /**
     * @param array $args
     */
    public function readModifyWriteRow(array $args)
    {
        $name = $this->pluck('tableName', $args);
        $rules = $this->pluck('rules', $args);
        return $this->send([$this->bigtableClient, 'readModifyWriteRow'], [
            $name,
            $this->pluck('rowKey', $args),
            array_map([$this, 'readModifyWriteRuleObject'], $rules),
            $this->addResourcePrefixHeader($args, $name)
        ]);
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

    /**
     * @param array $instance
     * @return Instance
     */
    private function instanceObject(array $instance)
    {
        return $this->serializer->decodeMessage(
            new Instance(),
            $instance
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
            $cluster
        );
    }

    /**
     * @param array $columnFamily
     * @return ColumnFamily
     */
    private function columnFamilyObject(array $columnFamily)
    {
        return $this->serializer->decodeMessage(
            new ColumnFamily(),
            $columnFamily
        );
    }

    /**
     * @param array $rowSet
     * @return RowSet
     */
    private function rowSetObject(array $rowSet)
    {
        return $this->serializer->decodeMessage(
            new RowSet(),
            $rowSet
        );
    }

    /**
     * @param array $filter
     * @return RowFilter
     */
    private function rowFilterObject(array $filter)
    {
        return $this->serializer->decodeMessage(
            new RowFilter,
            $filter
        );
    }

    /**
     * @param array $mutation
     * @return Mutation
     */
    private function mutationObject(array $mutation)
    {
        return $this->serializer->decodeMessage(
            new Mutation,
            $mutation
        );
    }

    /**
     * @param array $entry
     * @return MutateRowsRequest_Entry
     */
    private function entryObject(array $entry)
    {
        return $this->serializer->decodeMessage(
            new MutateRowsRequest_Entry,
            $entry
        );
    }

    /**
     * @param array $rule
     * @return ReadModifyWriteRule
     */
    private function readModifyWriteRuleObject(array $rule)
    {
        return $this->serializer->decodeMessage(
            new ReadModifyWriteRule,
            $rule
        );
    }

    /**
     * @param array $table
     * @return Table
     */
    private function tableObject(array $table)
    {
        return $this->serializer->decodeMessage(
            new Table,
            $table
        );
    }

    /**
     * @param array $split
     * @return CreateTableRequest_Split
     */
    private function createTableRequestSplitObject(array $split)
    {
        return $this->serializer->decodeMessage(
            new CreateTableRequest_Split,
            $split
        );
    }

    /**
     * @param array $appProfile
     * @return AppProfile
     */
    private function appProfileObject(array $appProfile)
    {
        return $this->serializer->decodeMessage(
            new AppProfile,
            $appProfile
        );
    }

    /**
     * @param array $fieldMask
     * @return FieldMask
     */
    private function fieldMaskObject(array $fieldMask)
    {
        return $this->serializer->decodeMessage(
            new FieldMask,
            $fieldMask
        );
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
}
