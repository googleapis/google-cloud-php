<?php

return [
    'interfaces' => [
        'google.container.v1beta1.ClusterManager' => [
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/clusters',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/clusters',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'method' => 'put',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNodePool' => [
                'method' => 'put',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*/nodePools/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/update',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetNodePoolAutoscaling' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*/nodePools/*}:setAutoscaling',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/autoscaling',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetLoggingService' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setLogging',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/logging',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetMonitoringService' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setMonitoring',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/monitoring',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetAddonsConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setAddons',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/addons',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetLocations' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setLocations',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/locations',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMaster' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:updateMaster',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/master',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetMasterAuth' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setMasterAuth',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setMasterAuth',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                    ],
                ],
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
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/operations',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/operations/{operation_id}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/operations/{operation_id}:cancel',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServerConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*}/serverConfig',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/serverconfig',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListNodePools' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/clusters/*}/nodePools',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetNodePool' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*/nodePools/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateNodePool' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/clusters/*}/nodePools',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteNodePool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*/nodePools/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RollbackNodePoolUpgrade' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*/nodePools/*}:rollback',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}:rollback',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetNodePoolManagement' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*/nodePools/*}:setManagement',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/setManagement',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetLabels' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setResourceLabels',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/resourceLabels',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetLegacyAbac' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setLegacyAbac',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/legacyAbac',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StartIPRotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:startIpRotation',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:startIpRotation',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CompleteIPRotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:completeIpRotation',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:completeIpRotation',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetNodePoolSize' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*/nodePools/*}:setSize',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/setSize',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetNetworkPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setNetworkPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setNetworkPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetMaintenancePolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/clusters/*}:setMaintenancePolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setMaintenancePolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListUsableSubnetworks' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/aggregated/usableSubnetworks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/locations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
