<?php

return [
    'interfaces' => [
        'google.container.v1.ClusterManager' => [
            'CancelOperation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'operation_id',
                        'fieldAccessors' => [
                            'getOperationId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CheckAutopilotCompatibility' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\CheckAutopilotCompatibilityResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CompleteIPRotation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CompleteNodePoolUpgrade' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateNodePool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteNodePool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'node_pool_id',
                        'fieldAccessors' => [
                            'getNodePoolId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Cluster',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetJSONWebKeys' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\GetJSONWebKeysResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetNodePool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\NodePool',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'node_pool_id',
                        'fieldAccessors' => [
                            'getNodePoolId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'operation_id',
                        'fieldAccessors' => [
                            'getOperationId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServerConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\ServerConfig',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\ListClustersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNodePools' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\ListNodePoolsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\ListOperationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUsableSubnetworks' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSubnetworks',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Container\V1\ListUsableSubnetworksResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RollbackNodePoolUpgrade' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'node_pool_id',
                        'fieldAccessors' => [
                            'getNodePoolId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetAddonsConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetLabels' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetLegacyAbac' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetLocations' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetLoggingService' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetMaintenancePolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetMasterAuth' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetMonitoringService' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetNetworkPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetNodePoolAutoscaling' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'node_pool_id',
                        'fieldAccessors' => [
                            'getNodePoolId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetNodePoolManagement' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'node_pool_id',
                        'fieldAccessors' => [
                            'getNodePoolId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetNodePoolSize' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'node_pool_id',
                        'fieldAccessors' => [
                            'getNodePoolId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StartIPRotation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMaster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNodePool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Container\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_id',
                        'fieldAccessors' => [
                            'getClusterId',
                        ],
                    ],
                    [
                        'keyName' => 'node_pool_id',
                        'fieldAccessors' => [
                            'getNodePoolId',
                        ],
                    ],
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'topic' => 'projects/{project}/topics/{topic}',
            ],
        ],
    ],
];
