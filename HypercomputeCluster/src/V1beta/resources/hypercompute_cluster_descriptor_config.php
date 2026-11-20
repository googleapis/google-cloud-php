<?php
/*
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

return [
    'interfaces' => [
        'google.cloud.hypercomputecluster.v1beta.HypercomputeCluster' => [
            'CreateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\HypercomputeCluster\V1beta\Cluster',
                    'metadataReturnType' => '\Google\Cloud\HypercomputeCluster\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\HypercomputeCluster\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\HypercomputeCluster\V1beta\Cluster',
                    'metadataReturnType' => '\Google\Cloud\HypercomputeCluster\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'cluster.name',
                        'fieldAccessors' => [
                            'getCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\HypercomputeCluster\V1beta\Cluster',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getClusters',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\HypercomputeCluster\V1beta\ListClustersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNodes' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getNodes',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\HypercomputeCluster\V1beta\ListNodesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetLocation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Location\Location',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Location\ListLocationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'templateMap' => [
                'bucket' => 'projects/{project}/buckets/{bucket}',
                'cluster' => 'projects/{project}/locations/{location}/clusters/{cluster}',
                'computeInstance' => 'projects/{project}/zones/{zone}/instances/{instance}',
                'disk' => 'projects/{project}/zones/{zone}/disks/{disk}',
                'diskType' => 'projects/{project}/zones/{zone}/diskTypes/{disk_type}',
                'fileInstance' => 'projects/{project}/locations/{location}/instances/{instance}',
                'image' => 'projects/{project}/global/images/{image}',
                'instance' => 'projects/{project}/locations/{location}/instances/{instance}',
                'instanceGroupManager' => 'projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}',
                'instanceTemplate' => 'projects/{project}/global/instanceTemplates/{instance_template}',
                'location' => 'projects/{project}/locations/{location}',
                'network' => 'projects/{project}/global/networks/{network}',
                'project' => 'projects/{project}',
                'projectRegionInstanceGroupManager' => 'projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}',
                'projectRegionSnapshot' => 'projects/{project}/regions/{region}/snapshots/{snapshot}',
                'projectSnapshot' => 'projects/{project}/global/snapshots/{snapshot}',
                'projectZoneInstanceGroupManager' => 'projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}',
                'reservation' => 'projects/{project}/zones/{zone}/reservations/{reservation}',
                'reservationBlock' => 'projects/{project}/zones/{zone}/reservations/{reservation}/reservationBlocks/{reservation_block}',
                'reservationSubBlock' => 'projects/{project}/zones/{zone}/reservations/{reservation}/reservationBlocks/{reservation_block}/reservationSubBlocks/{reservation_sub_block}',
                'snapshot' => 'projects/{project}/global/snapshots/{snapshot}',
                'storagePool' => 'projects/{project}/zones/{zone}/storagePools/{storage_pool}',
                'subnetwork' => 'projects/{project}/regions/{region}/subnetworks/{subnetwork}',
            ],
        ],
    ],
];
