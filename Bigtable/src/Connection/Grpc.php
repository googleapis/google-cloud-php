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
    public function waitForReplication(array $args)
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
        $optionalArgs = [];
        if (isset($args['options'])) {
            $options = $this->pluck('options', $args);
            if (isset($options['appProfileId'])) {
                $optionalArgs['appProfileId'] = $this->pluck('appProfileId', $options);
            }
            if (isset($options['rows'])) {
                $optionalArgs['rows'] = $this->rowSetObject($this->pluck('rows', $options));
            }
            if (isset($options['filter'])) {
                $optionalArgs['filter'] = $this->rowFilterObject($this->pluck('filter', $options));
            }
            if (isset($options['rowsLimit'])) {
                $optionalArgs['rowsLimit'] = $this->pluck('rowsLimit', $options);
            }
        }
        return $this->send([$this->bigtableClient, 'readRows'], [
            $tableName,
            $optionalArgs,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     * @return RowSet
     */
    private function rowSetObject(array $args)
    {
        $rowSet = [];
        if (isset($args['rowkeys'])) {
            $rowSet['row_keys'] = $this->pluck('rowkeys', $args);
        }
        if (isset($args['rowRanges'])) {
            $rowSet['row_ranges'] = array_map([$this, 'rowRangesObject'], $this->pluck('rowRanges', $args));
        }
        return $this->serializer->decodeMessage(
            new RowSet(),
            $this->pluckArray([
                'row_keys',
                'row_ranges'
            ], $args)
        );
    }

    /**
     * @param array $args
     * @return RowRange
     */
    private function rowRangesObject(array $args)
    {
        return $this->serializer->decodeMessage(
            new RowRange(),
            $this->pluckArray([
                'start_key_closed',
                'start_key_open',
                'end_key_open',
                'end_key_closed'
            ], $args)
        );
    }

    /**
     * @param array $args
     * @return RowFilter
     */
    private function rowFilterObject(array $args)
    {
        return $this->serializer->decodeMessage(
            new RowFilter(),
            $this->pluckArray([
                'cells_per_row_limit_filter'
            ], $args)
        );
    }
    
    /**
     * @param array $args
     */
    public function sampleRowKeys(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $optionalArgs = [];
        if (isset($args['options'])) {
            $options = $this->pluck('options', $args);
            if (isset($options['appProfileId'])) {
                $optionalArgs['appProfileId'] = $this->pluck('appProfileId', $options);
            }
        }
        return $this->send([$this->bigtableClient, 'sampleRowKeys'], [
            $tableName,
            $optionalArgs,
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
        $optionalArgs = [];
        if (isset($args['options'])) {
            $options = $this->pluck('options', $args);
            if (isset($options['appProfileId'])) {
                $optionalArgs['appProfileId'] = $this->pluck('appProfileId', $options);
            }
        }
        return $this->send([$this->bigtableClient, 'mutateRow'], [
            $tableName,
            $this->pluck('rowKey', $args),
            array_map([$this, 'mutationObject'], $cells),
            $optionalArgs,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     * @return Mutation
     */
    private function mutationObject(array $args)
    {
        $cellObject['set_cell'] = $this->serializer->decodeMessage(
            new Mutation_SetCell(),
            $this->pluckArray([
                'family_name',
                'column_qualifier',
                'value',
                'timestamp_micros'
            ], $args)
        );

        return $this->serializer->decodeMessage(
            new Mutation(),
            $this->pluckArray([
                'set_cell'
            ], $cellObject)
        );
    }

    /**
     * @param array $args
     */
    public function mutateRows(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $cells = $this->pluck('cells', $args);
        $entries = array_map([$this, 'mutationsArray'], $cells);
        $optionalArgs = [];
        if (isset($args['options'])) {
            $options = $this->pluck('options', $args);
            if (isset($options['appProfileId'])) {
                $optionalArgs['appProfileId'] = $this->pluck('appProfileId', $options);
            }
        }
        return $this->send([$this->bigtableClient, 'mutateRows'], [
            $tableName,
            array_map([$this, 'mutateRowsRequestEntryObject'], $entries),
            $optionalArgs,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     * @return MutateRowsRequest_Entry
     */
    private function mutateRowsRequestEntryObject(array $args)
    {
        return $this->serializer->decodeMessage(
            new MutateRowsRequest_Entry(),
            $this->pluckArray([
                'row_key',
                'mutations'
            ], $args)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    private function mutationsArray(array $args)
    {
        $cell = $this->pluck('cell', $args);
        return([
            'row_key' => $this->pluck('rowKey', $args),
            'mutations' => array_map([$this, 'mutationObject'], $cell)
        ]);
    }

    /**
     * @param array $args
     */
    public function checkAndMutateRow(array $args)
    {
        $tableName = $this->pluck('tableName', $args);
        $optionalArgs =[];
        if (isset($args['options'])) {
            $options =  $this->pluck('options', $args);
            if (isset($options['appProfileId'])) {
                $optionalArgs['appProfileId'] = $this->pluck('appProfileId', $options);
            }
            if (isset($options['predicateFilter'])) {
                $optionalArgs['predicateFilter'] = $this->rowFilterObject($this->pluck('predicateFilter', $options));
            }
            if (isset($options['trueMutations'])) {
                $cell = $this->pluck('trueMutations', $options);
                $optionalArgs['trueMutations'] = array_map([$this, 'mutationObject'], $cell);
            }
            if (isset($options['falseMutations'])) {
                $cell = $this->pluck('falseMutations', $options);
                $optionalArgs['falseMutations'] = array_map([$this, 'mutationObject'], $cell);
            }
        }
        return $this->send([$this->bigtableClient, 'checkAndMutateRow'], [
            $tableName,
            $this->pluck('rowKey', $args),
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
        $rules = $this->pluck('rules', $args);
        $optionalArgs =[];
        if (isset($args['options'])) {
            $options =  $this->pluck('options', $args);
            if (isset($options['appProfileId'])) {
                $optionalArgs['appProfileId'] = $this->pluck('appProfileId', $options);
            }
        }
        return $this->send([$this->bigtableClient, 'readModifyWriteRow'], [
            $tableName,
            $this->pluck('rowKey', $args),
            array_map([$this, 'readModifyWriteRuleObject'], $rules),
            $optionalArgs,
            $this->addResourcePrefixHeader($args, $tableName)
        ]);
    }

    /**
     * @param array $args
     * @return ReadModifyWriteRule
     */
    private function readModifyWriteRuleObject(array $args)
    {
        return $this->serializer->decodeMessage(
            new ReadModifyWriteRule(),
            $this->pluckArray([
                'family_name',
                'column_qualifier',
                'append_value'
            ], $args)
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
