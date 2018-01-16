<?php

return [
    'interfaces' => [
        'google.container.v1.ClusterManager' => [
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters',
                'placeholders' => [
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
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'CreateCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters',
                'body' => '*',
                'placeholders' => [
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
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'UpdateNodePool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/update',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                ],
            ],
            'SetNodePoolAutoscaling' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/autoscaling',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                ],
            ],
            'SetLoggingService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/logging',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'SetMonitoringService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/monitoring',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'SetAddonsConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/addons',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'SetLocations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/locations',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'UpdateMaster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/master',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'SetMasterAuth' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setMasterAuth',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/operations',
                'placeholders' => [
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
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/operations/{operation_id}',
                'placeholders' => [
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
                    'operation_id' => [
                        'getters' => [
                            'getOperationId',
                        ],
                    ],
                ],
            ],
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/operations/{operation_id}:cancel',
                'body' => '*',
                'placeholders' => [
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
                    'operation_id' => [
                        'getters' => [
                            'getOperationId',
                        ],
                    ],
                ],
            ],
            'GetServerConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/serverconfig',
                'placeholders' => [
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
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'GetNodePool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                ],
            ],
            'CreateNodePool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'DeleteNodePool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                ],
            ],
            'RollbackNodePoolUpgrade' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}:rollback',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                ],
            ],
            'SetNodePoolManagement' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/setManagement',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                ],
            ],
            'SetLabels' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/resourceLabels',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'SetLegacyAbac' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/legacyAbac',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'StartIPRotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:startIpRotation',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'CompleteIPRotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:completeIpRotation',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'SetNodePoolSize' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}/nodePools/{node_pool_id}/setSize',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                    'node_pool_id' => [
                        'getters' => [
                            'getNodePoolId',
                        ],
                    ],
                ],
            ],
            'SetNetworkPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setNetworkPolicy',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
            'SetMaintenancePolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/zones/{zone}/clusters/{cluster_id}:setMaintenancePolicy',
                'body' => '*',
                'placeholders' => [
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
                    'cluster_id' => [
                        'getters' => [
                            'getClusterId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
