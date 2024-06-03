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
        'google.cloud.gkemulticloud.v1.AzureClusters' => [
            'CreateAzureClient' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/azureClients',
                'body' => 'azure_client',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'azure_client_id',
                ],
            ],
            'CreateAzureCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/azureClusters',
                'body' => 'azure_cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'azure_cluster_id',
                ],
            ],
            'CreateAzureNodePool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/azureClusters/*}/azureNodePools',
                'body' => 'azure_node_pool',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'azure_node_pool_id',
                ],
            ],
            'DeleteAzureClient' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/azureClients/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAzureCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/azureClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAzureNodePool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/azureClusters/*/azureNodePools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateAzureAccessToken' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{azure_cluster=projects/*/locations/*/azureClusters/*}:generateAzureAccessToken',
                'placeholders' => [
                    'azure_cluster' => [
                        'getters' => [
                            'getAzureCluster',
                        ],
                    ],
                ],
            ],
            'GenerateAzureClusterAgentToken' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{azure_cluster=projects/*/locations/*/azureClusters/*}:generateAzureClusterAgentToken',
                'body' => '*',
                'placeholders' => [
                    'azure_cluster' => [
                        'getters' => [
                            'getAzureCluster',
                        ],
                    ],
                ],
            ],
            'GetAzureClient' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/azureClients/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAzureCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/azureClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAzureJsonWebKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{azure_cluster=projects/*/locations/*/azureClusters/*}/jwks',
                'placeholders' => [
                    'azure_cluster' => [
                        'getters' => [
                            'getAzureCluster',
                        ],
                    ],
                ],
            ],
            'GetAzureNodePool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/azureClusters/*/azureNodePools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAzureOpenIdConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{azure_cluster=projects/*/locations/*/azureClusters/*}/.well-known/openid-configuration',
                'placeholders' => [
                    'azure_cluster' => [
                        'getters' => [
                            'getAzureCluster',
                        ],
                    ],
                ],
            ],
            'GetAzureServerConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/azureServerConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAzureClients' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/azureClients',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAzureClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/azureClusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAzureNodePools' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/azureClusters/*}/azureNodePools',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAzureCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{azure_cluster.name=projects/*/locations/*/azureClusters/*}',
                'body' => 'azure_cluster',
                'placeholders' => [
                    'azure_cluster.name' => [
                        'getters' => [
                            'getAzureCluster',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateAzureNodePool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{azure_node_pool.name=projects/*/locations/*/azureClusters/*/azureNodePools/*}',
                'body' => 'azure_node_pool',
                'placeholders' => [
                    'azure_node_pool.name' => [
                        'getters' => [
                            'getAzureNodePool',
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
