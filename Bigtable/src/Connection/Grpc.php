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
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
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
        $this->bigtableClient = new BigtableClient();
        $this->bigtableTableAdminClient = new BigtableTableAdminClient();
        $this->bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
    }

    /**
     * @param array $args
     */
    public function createInstance(array $args)
    {
        $parent = $args['parent'];
        $instance = $this->pluck('instance', $args);
        $clusters = $this->pluck('clusters', $args); 
        return $this->send([$this->bigtableInstanceAdminClient, 'createInstance'], [
            $parent,
            $this->pluck('instanceId', $args),
            $this->instanceObject($instance),
            $this->mapOfClusterObject($clusters),
            $this->addResourcePrefixHeader($args, $parent)
        ]);
    }

    /**
     * @param array $args
     * @param bool $required
     */
    private function instanceObject(array &$args, $required = false)
    {
        return $this->serializer->decodeMessage(
            new Instance(),
            $this->instanceArray($args, $required)
        );
    }

    /**
     * @param array $args
     * @param bool $required
     * @return array
     */
    private function instanceArray(array &$args, $required = false)
    {
        $argsCopy = $args;
        return array_intersect_key([
            'displayName' => $this->pluck('displayName', $args, $required),
            'type' => $this->pluck('type', $args, $required),
            'labels' => $this->pluck('labels', $args, $required),
        ], $argsCopy);
    }

    /**
     * @param array $args
     * @param bool $required
     */
    private function mapOfClusterObject(array &$args, $required = false)
    {
        $clusters = new MapField(GPBType::STRING, GPBType::MESSAGE, Cluster::class);
        foreach ($args as $key => $value) {
            $clusters[$value['name']] = $this->clusterObject($value, $required);;
        }
        return $clusters;
    }

    /**
     * @param array $args
     * @param bool $required
     */
    private function clusterObject(array &$args, $required = false)
    {
        return $this->serializer->decodeMessage(
            new Cluster(),
            $this->clusterArray($args, $required)
        );
    }

    /**
     * @param array $args
     * @param bool $required
     * @return array
     */
    private function clusterArray(array &$args, $required = false)
    {
        $argsCopy = $args;
        return array_intersect_key([
            'location' => $this->pluck('location', $args, $required),
            'serveNodes' => $this->pluck('serveNodes', $args, $required),
            'defaultStorageType' => $this->pluck('defaultStorageType', $args, $required)
        ], $argsCopy);
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
