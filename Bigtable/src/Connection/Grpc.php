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

use Google\ApiCore\Call;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Gapic\BigtableTableAdminGapicClient;
use Google\Cloud\Bigtable\V2\Gapic\BigtableGapicClient;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Protobuf;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\ListValue;
use Google\Protobuf\Struct;
use Google\Protobuf\Value;
use Grpc\UnaryCall;
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
     * @var InstanceAdminClient
     */
    private $instanceAdminClient;

    /**
     * @var bigtableClient
     */
    private $bigtableClient;

    /**
     * @var tableAdminClient
     */
    private $tableAdminClient;

    /**
     * @var array
     */
    private $lroResponseMappers = [
        [
            'method' => 'createInstance',
            'typeUrl' => 'type.googleapis.com/google.bigtable.admin.instance.v2.CreateInstanceMetadata',
            'message' => Instance::class
        ], [
            'method' => 'updateInstance',
            'typeUrl' => 'type.googleapis.com/google.bigtable.admin.instance.v2.UpdateInstanceMetadata',
            'message' => Instance::class
        ]
    ];
    
    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer([
            'commit_timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'read_timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.ListValue' => function ($v) {
                return $this->flattenListValue($v);
            },
            'google.protobuf.Struct' => function ($v) {
                return $this->flattenStruct($v);
            },
        ]);

        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));

        $this->instanceAdminClient = new BigtableInstanceAdminClient();
        $this->bigtableClient = new BigtableGapicClient();
        $this->tableAdminClient = new BigtableTableAdminGapicClient();
    }

    /**
     * @param array $args
     */
    public function listInstances(array $args)
    {
        $projectId = $this->pluck('projectId', $args);
        return $this->send([$this->instanceAdminClient, 'listInstances'], [
            $projectId,
            $this->addResourcePrefixHeader($args, $projectId)
        ]);
    }

    /**
     * @param array $args
     */
    public function listTables(array $args)
    {
        $parent = $this->pluck('name', $args);
        return $this->send([$this->tableAdminClient, 'listTables'], [
            $parent,
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteTable(array $args)
    {
        $tableName = $this->pluck('name', $args);
        return $this->send([$this->tableAdminClient, 'deleteTable'], [
            $tableName,
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
