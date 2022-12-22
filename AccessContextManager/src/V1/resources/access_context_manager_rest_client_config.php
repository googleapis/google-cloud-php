<?php

return [
    'interfaces' => [
        'google.identity.accesscontextmanager.v1.AccessContextManager' => [
            'CommitServicePerimeters' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accessPolicies/*}/servicePerimeters:commit',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAccessLevel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accessPolicies/*}/accessLevels',
                'body' => 'access_level',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAccessPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/accessPolicies',
                'body' => '*',
            ],
            'CreateGcpUserAccessBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*}/gcpUserAccessBindings',
                'body' => 'gcp_user_access_binding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateServicePerimeter' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accessPolicies/*}/servicePerimeters',
                'body' => 'service_perimeter',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAccessLevel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=accessPolicies/*/accessLevels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAccessPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=accessPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGcpUserAccessBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=organizations/*/gcpUserAccessBindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteServicePerimeter' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=accessPolicies/*/servicePerimeters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAccessLevel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accessPolicies/*/accessLevels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAccessPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accessPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGcpUserAccessBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/gcpUserAccessBindings/*}',
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
                'uriTemplate' => '/v1/{resource=accessPolicies/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetServicePerimeter' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accessPolicies/*/servicePerimeters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAccessLevels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accessPolicies/*}/accessLevels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAccessPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/accessPolicies',
                'queryParams' => [
                    'parent',
                ],
            ],
            'ListGcpUserAccessBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*}/gcpUserAccessBindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServicePerimeters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accessPolicies/*}/servicePerimeters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReplaceAccessLevels' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accessPolicies/*}/accessLevels:replaceAll',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReplaceServicePerimeters' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accessPolicies/*}/servicePerimeters:replaceAll',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=accessPolicies/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=accessPolicies/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=accessPolicies/*/accessLevels/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=accessPolicies/*/servicePerimeters/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateAccessLevel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{access_level.name=accessPolicies/*/accessLevels/*}',
                'body' => 'access_level',
                'placeholders' => [
                    'access_level.name' => [
                        'getters' => [
                            'getAccessLevel',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateAccessPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{policy.name=accessPolicies/*}',
                'body' => 'policy',
                'placeholders' => [
                    'policy.name' => [
                        'getters' => [
                            'getPolicy',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateGcpUserAccessBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{gcp_user_access_binding.name=organizations/*/gcpUserAccessBindings/*}',
                'body' => 'gcp_user_access_binding',
                'placeholders' => [
                    'gcp_user_access_binding.name' => [
                        'getters' => [
                            'getGcpUserAccessBinding',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateServicePerimeter' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{service_perimeter.name=accessPolicies/*/servicePerimeters/*}',
                'body' => 'service_perimeter',
                'placeholders' => [
                    'service_perimeter.name' => [
                        'getters' => [
                            'getServicePerimeter',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=operations/**}',
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
