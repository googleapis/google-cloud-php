<?php

return [
    'interfaces' => [
        'google.container.v1.ClusterManager' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/operations/{operation_id}:cancel',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'operation_id' => [
                        'getters' => [
                            'getOperationId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'CompleteIPRotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:completeIpRotation',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:completeIpRotation',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'CompleteNodePoolUpgrade' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/nodePools/*}:completeUpgrade',
                'body' => '*',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/clusters',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'CreateNodePool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/nodePools',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'DeleteNodePool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/nodePools/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'GetJSONWebKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/jwks',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/nodePools/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/operations/{operation_id}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'operation_id' => [
                        'getters' => [
                            'getOperationId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'GetServerConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/serverConfig',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/serverconfig',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/clusters',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'ListNodePools' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/nodePools',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/operations',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'ListUsableSubnetworks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/aggregated/usableSubnetworks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RollbackNodePoolUpgrade' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/nodePools/*}:rollback',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}:rollback',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetAddonsConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setAddons',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/addons',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetLabels' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setResourceLabels',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/resourceLabels',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetLegacyAbac' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setLegacyAbac',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/legacyAbac',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetLocations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setLocations',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/locations',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetLoggingService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setLogging',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/logging',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetMaintenancePolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setMaintenancePolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setMaintenancePolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetMasterAuth' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setMasterAuth',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setMasterAuth',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetMonitoringService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setMonitoring',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/monitoring',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetNetworkPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:setNetworkPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setNetworkPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetNodePoolAutoscaling' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/nodePools/*}:setAutoscaling',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/autoscaling',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetNodePoolManagement' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/nodePools/*}:setManagement',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/setManagement',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetNodePoolSize' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/nodePools/*}:setSize',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/setSize',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'StartIPRotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:startIpRotation',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:startIpRotation',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'UpdateMaster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:updateMaster',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/master',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'UpdateNodePool' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/nodePools/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/update',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
