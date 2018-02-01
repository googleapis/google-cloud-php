<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1.ClusterController' => [
            'CreateCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/regions/{region}/clusters',
                'body' => 'cluster',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/projects/{project_id}/regions/{region}/clusters/{cluster_name}',
                'body' => 'cluster',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                    'cluster_name' => [
                        'getters' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/projects/{project_id}/regions/{region}/clusters/{cluster_name}',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                    'cluster_name' => [
                        'getters' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/regions/{region}/clusters/{cluster_name}',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                    'cluster_name' => [
                        'getters' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/regions/{region}/clusters',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'DiagnoseCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/regions/{region}/clusters/{cluster_name}:diagnose',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                    'cluster_name' => [
                        'getters' => [
                            'getClusterName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/regions/*/operations}',
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
                'uriTemplate' => '/v1/{name=projects/*/regions/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/regions/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/regions/*/operations/*}:cancel',
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
