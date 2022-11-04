<?php

return [
    'interfaces' => [
        'google.bigtable.admin.v2.BigtableInstanceAdmin' => [
            'CreateAppProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/appProfiles',
                'body' => 'app_profile',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'app_profile_id',
                ],
            ],
            'CreateCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/clusters',
                'body' => 'cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cluster_id',
                ],
            ],
            'CreateInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/instances',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAppProfile' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/appProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'ignore_warnings',
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteInstance' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAppProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/appProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/instances/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAppProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/appProfiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/clusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHotTablets' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*/clusters/*}/hotTablets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PartialUpdateCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{cluster.name=projects/*/instances/*/clusters/*}',
                'body' => 'cluster',
                'placeholders' => [
                    'cluster.name' => [
                        'getters' => [
                            'getCluster',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'PartialUpdateInstance' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{instance.name=projects/*/instances/*}',
                'body' => 'instance',
                'placeholders' => [
                    'instance.name' => [
                        'getters' => [
                            'getInstance',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/instances/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/instances/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateAppProfile' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{app_profile.name=projects/*/instances/*/appProfiles/*}',
                'body' => 'app_profile',
                'placeholders' => [
                    'app_profile.name' => [
                        'getters' => [
                            'getAppProfile',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCluster' => [
                'method' => 'put',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInstance' => [
                'method' => 'put',
                'uriTemplate' => '/v2/{name=projects/*/instances/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=operations/**}:cancel',
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
                'uriTemplate' => '/v2/{name=operations/**}',
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
                'uriTemplate' => '/v2/{name=operations/**}',
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
                'uriTemplate' => '/v2/{name=operations/projects/**}/operations',
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
