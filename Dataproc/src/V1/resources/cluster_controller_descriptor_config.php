<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1.ClusterController' => [
            'CreateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'region',
                        'fieldAccessors' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'region',
                        'fieldAccessors' => [
                            'getRegion',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_name',
                        'fieldAccessors' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
            'DiagnoseCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\DiagnoseClusterResults',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'region',
                        'fieldAccessors' => [
                            'getRegion',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_name',
                        'fieldAccessors' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
            'StartCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'region',
                        'fieldAccessors' => [
                            'getRegion',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_name',
                        'fieldAccessors' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
            'StopCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'region',
                        'fieldAccessors' => [
                            'getRegion',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_name',
                        'fieldAccessors' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'region',
                        'fieldAccessors' => [
                            'getRegion',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_name',
                        'fieldAccessors' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataproc\V1\Cluster',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'region',
                        'fieldAccessors' => [
                            'getRegion',
                        ],
                    ],
                    [
                        'keyName' => 'cluster_name',
                        'fieldAccessors' => [
                            'getClusterName',
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
                'responseType' => 'Google\Cloud\Dataproc\V1\ListClustersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'region',
                        'fieldAccessors' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\TestIamPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'templateMap' => [
                'cluster' => 'projects/{project}/locations/{location}/clusters/{cluster}',
                'clusterRegion' => 'projects/{project}/regions/{region}/clusters/{cluster}',
                'nodeGroup' => 'projects/{project}/regions/{region}/clusters/{cluster}/nodeGroups/{node_group}',
                'service' => 'projects/{project}/locations/{location}/services/{service}',
            ],
        ],
    ],
];
