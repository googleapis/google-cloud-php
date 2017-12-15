<?php

return [
    'interfaces' => [
        'google.bigtable.admin.v2.BigtableInstanceAdmin' => [
            'CreateInstance' => [
                'method' => 'post',
                'uri' => '/v2/{parent=projects/*}/instances',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uri' => '/v2/{name=projects/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uri' => '/v2/{parent=projects/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'UpdateInstance' => [
                'method' => 'put',
                'uri' => '/v2/{name=projects/*/instances/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'PartialUpdateInstance' => [
                'method' => 'patch',
                'uri' => '/v2/{instance.name=projects/*/instances/*}',
                'body' => 'instance',
                'placeholders' => [
                    'instance.name' => [
                        'getInstance',
                        'getName',
                    ],
                ],
            ],
            'DeleteInstance' => [
                'method' => 'delete',
                'uri' => '/v2/{name=projects/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CreateCluster' => [
                'method' => 'post',
                'uri' => '/v2/{parent=projects/*/instances/*}/clusters',
                'body' => 'cluster',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uri' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListClusters' => [
                'method' => 'get',
                'uri' => '/v2/{parent=projects/*/instances/*}/clusters',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'UpdateCluster' => [
                'method' => 'put',
                'uri' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uri' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CreateAppProfile' => [
                'method' => 'post',
                'uri' => '/v2/{parent=projects/*/instances/*}/appProfiles',
                'body' => 'app_profile',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetAppProfile' => [
                'method' => 'get',
                'uri' => '/v2/{name=projects/*/instances/*/appProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListAppProfiles' => [
                'method' => 'get',
                'uri' => '/v2/{parent=projects/*/instances/*}/appProfiles',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'UpdateAppProfile' => [
                'method' => 'patch',
                'uri' => '/v2/{app_profile.name=projects/*/instances/*/appProfiles/*}',
                'body' => 'app_profile',
                'placeholders' => [
                    'app_profile.name' => [
                        'getAppProfile',
                        'getName',
                    ],
                ],
            ],
            'DeleteAppProfile' => [
                'method' => 'delete',
                'uri' => '/v2/{name=projects/*/instances/*/appProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uri' => '/v2/{resource=projects/*/instances/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uri' => '/v2/{resource=projects/*/instances/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uri' => '/v2/{resource=projects/*/instances/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
        ],
    ],
];
