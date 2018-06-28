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
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation_SetCell;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRule;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Bigtable\V2\RowRange;
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
        throw new \BadMethodCallException('This method is not implemented yet');
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
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * @param array $args
     */
    public function modifyColumnFamilies(array $args)
    {
        throw new \BadMethodCallException('This method is not implemented yet');
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
        $tableName = $this->pluck('tableName', $args);
        if (isset($args['rows'])) {
            $args['rows'] = $this->rowSetObject($this->pluck('rows', $args));
        }
        if (isset($args['filter'])) {
            $args['filter'] = $this->rowFilterObject($this->pluck('filter', $args));
        }
        return $this->send([$this->bigtableClient, 'readRows'], [
            $tableName,
            $args,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $rows
     * @return RowSet
     */
    private function rowSetObject(array $rows)
    {
        if (isset($rows['rowRanges'])) {
            $rows['rowRanges'] = array_map([$this, 'rowRangesObject'], $this->pluck('rowRanges', $rows));
        }
        return $this->serializer->decodeMessage(
            new RowSet(),
            $this->pluckArray([
                'rowkeys',
                'rowRanges'
            ], $rows)
        );
    }

    /**
     * @param array $rowRange
     * @return RowRange
     */
    private function rowRangesObject(array $rowRange)
    {
        return $this->serializer->decodeMessage(
            new RowRange(),
            $this->pluckArray([
                'startKeyClosed',
                'startKeyOpen',
                'endKeyOpen',
                'endKeyClosed'
            ], $rowRange)
        );
    }

    /**
     * @param array $filter
     * @return RowFilter
     */
    private function rowFilterObject(array $filter)
    {
        return $this->serializer->decodeMessage(
            new RowFilter(),
            $this->pluckArray([
                'cellsPerRowLimitFilter'
            ], $filter)
        );
    }
    
    /**
     * @param array $args
     */
    public function sampleRowKeys(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        return $this->send([$this->bigtableClient, 'sampleRowKeys'], [
            $tableName,
            $args,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     */
    public function mutateRow(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $cells = $this->pluck('cells', $args);
        return $this->send([$this->bigtableClient, 'mutateRow'], [
            $tableName,
            $this->pluck('rowKey', $args),
            array_map([$this, 'mutationObject'], $cells),
            $args,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $cell
     * @return Mutation
     */
    private function mutationObject(array $cell)
    {
        $cellObject = [];
        $cellObject['setCell'] = $this->serializer->decodeMessage(
            new Mutation_SetCell(),
            $this->pluckArray([
                'familyName',
                'columnQualifier',
                'value',
                'timestampMicros'
            ], $cell)
        );

        return $this->serializer->decodeMessage(
            new Mutation(),
            $this->pluckArray([
                'setCell'
            ], $cellObject)
        );
    }

    /**
     * @param array $args
     */
    public function mutateRows(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $entries = array_map([$this, 'mutationsArray'], $this->pluck('cells', $args));
        return $this->send([$this->bigtableClient, 'mutateRows'], [
            $tableName,
            array_map([$this, 'mutateRowsRequestEntryObject'], $entries),
            $args,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $mutateRow
     * @return MutateRowsRequest_Entry
     */
    private function mutateRowsRequestEntryObject(array $mutateRow)
    {
        return $this->serializer->decodeMessage(
            new MutateRowsRequest_Entry(),
            $this->pluckArray([
                'rowKey',
                'mutations'
            ], $mutateRow)
        );
    }

    /**
     * @param array $row
     * @return array
     */
    private function mutationsArray(array $row)
    {
        return([
            'rowKey' => $this->pluck('rowKey', $row),
            'mutations' => array_map([$this, 'mutationObject'], $this->pluck('cell', $row))
        ]);
    }

    /**
     * @param array $args
     */
    public function checkAndMutateRow(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        if (isset($args['predicateFilter'])) {
            $args['predicateFilter'] = $this->rowFilterObject($this->pluck('predicateFilter', $args));
        }
        if (isset($args['trueMutations'])) {
            $args['trueMutations'] = array_map([$this, 'mutationObject'], $this->pluck('trueMutations', $args));
        }
        if (isset($args['falseMutations'])) {
            $args['falseMutations'] = array_map([$this, 'mutationObject'], $this->pluck('falseMutations', $args));
        }
        return $this->send([$this->bigtableClient, 'checkAndMutateRow'], [
            $tableName,
            $this->pluck('rowKey', $args),
            $args,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     */
    public function readModifyWriteRow(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $cells = $this->pluck('cells', $args);
        return $this->send([$this->bigtableClient, 'readModifyWriteRow'], [
            $tableName,
            $this->pluck('rowKey', $args),
            array_map([$this, 'readModifyWriteRuleObject'], $cells),
            $args,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $cell
     * @return ReadModifyWriteRule
     */
    private function readModifyWriteRuleObject(array $cell)
    {
        return $this->serializer->decodeMessage(
            new ReadModifyWriteRule(),
            $this->pluckArray([
                'familyName',
                'columnQualifier',
                'appendValue'
            ], $cell)
        );
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
