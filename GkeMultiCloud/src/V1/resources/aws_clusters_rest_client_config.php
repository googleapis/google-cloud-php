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
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/awsClusters',
                'body' => 'aws_cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'aws_cluster_id',
                ],
            ],
            'CreateAwsNodePool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/awsClusters/*}/awsNodePools',
                'body' => 'aws_node_pool',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'aws_node_pool_id',
                ],
            ],
            'DeleteAwsCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/awsClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAwsNodePool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/awsClusters/*/awsNodePools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateAwsAccessToken' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{aws_cluster=projects/*/locations/*/awsClusters/*}:generateAwsAccessToken',
                'placeholders' => [
                    'aws_cluster' => [
                        'getters' => [
                            'getAwsCluster',
                        ],
                    ],
                ],
            ],
            'GenerateAwsClusterAgentToken' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{aws_cluster=projects/*/locations/*/awsClusters/*}:generateAwsClusterAgentToken',
                'body' => '*',
                'placeholders' => [
                    'aws_cluster' => [
                        'getters' => [
                            'getAwsCluster',
                        ],
                    ],
                ],
            ],
            'GetAwsCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/awsClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAwsJsonWebKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{aws_cluster=projects/*/locations/*/awsClusters/*}/jwks',
                'placeholders' => [
                    'aws_cluster' => [
                        'getters' => [
                            'getAwsCluster',
                        ],
                    ],
                ],
            ],
            'GetAwsNodePool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/awsClusters/*/awsNodePools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAwsOpenIdConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{aws_cluster=projects/*/locations/*/awsClusters/*}/.well-known/openid-configuration',
                'placeholders' => [
                    'aws_cluster' => [
                        'getters' => [
                            'getAwsCluster',
                        ],
                    ],
                ],
            ],
            'GetAwsServerConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/awsServerConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAwsClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/awsClusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAwsNodePools' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/awsClusters/*}/awsNodePools',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RollbackAwsNodePoolUpdate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/awsClusters/*/awsNodePools/*}:rollback',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAwsCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{aws_cluster.name=projects/*/locations/*/awsClusters/*}',
                'body' => 'aws_cluster',
                'placeholders' => [
                    'aws_cluster.name' => [
                        'getters' => [
                            'getAwsCluster',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateAwsNodePool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{aws_node_pool.name=projects/*/locations/*/awsClusters/*/awsNodePools/*}',
                'body' => 'aws_node_pool',
                'placeholders' => [
                    'aws_node_pool.name' => [
                        'getters' => [
                            'getAwsNodePool',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
