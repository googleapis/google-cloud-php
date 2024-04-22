<?php
/*
 * Copyright 2024 Google LLC
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
        'google.cloud.gkemulticloud.v1.AwsClusters' => [
            'CreateAwsCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AwsCluster',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
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
            'CreateAwsNodePool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AwsNodePool',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
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
            'DeleteAwsCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
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
            'DeleteAwsNodePool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
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
            'RollbackAwsNodePoolUpdate' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AwsNodePool',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
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
            'UpdateAwsCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AwsCluster',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'aws_cluster.name',
                        'fieldAccessors' => [
                            'getAwsCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAwsNodePool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AwsNodePool',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'aws_node_pool.name',
                        'fieldAccessors' => [
                            'getAwsNodePool',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateAwsAccessToken' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\GenerateAwsAccessTokenResponse',
                'headerParams' => [
                    [
                        'keyName' => 'aws_cluster',
                        'fieldAccessors' => [
                            'getAwsCluster',
                        ],
                    ],
                ],
            ],
            'GenerateAwsClusterAgentToken' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\GenerateAwsClusterAgentTokenResponse',
                'headerParams' => [
                    [
                        'keyName' => 'aws_cluster',
                        'fieldAccessors' => [
                            'getAwsCluster',
                        ],
                    ],
                ],
            ],
            'GetAwsCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AwsCluster',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAwsJsonWebKeys' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AwsJsonWebKeys',
                'headerParams' => [
                    [
                        'keyName' => 'aws_cluster',
                        'fieldAccessors' => [
                            'getAwsCluster',
                        ],
                    ],
                ],
            ],
            'GetAwsNodePool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AwsNodePool',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAwsOpenIdConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AwsOpenIdConfig',
                'headerParams' => [
                    [
                        'keyName' => 'aws_cluster',
                        'fieldAccessors' => [
                            'getAwsCluster',
                        ],
                    ],
                ],
            ],
            'GetAwsServerConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AwsServerConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAwsClusters' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAwsClusters',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\ListAwsClustersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAwsNodePools' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAwsNodePools',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\ListAwsNodePoolsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'awsCluster' => 'projects/{project}/locations/{location}/awsClusters/{aws_cluster}',
                'awsNodePool' => 'projects/{project}/locations/{location}/awsClusters/{aws_cluster}/awsNodePools/{aws_node_pool}',
                'awsServerConfig' => 'projects/{project}/locations/{location}/awsServerConfig',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
