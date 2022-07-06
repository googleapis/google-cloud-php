<?php

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
