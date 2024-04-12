<?php

return [
    'interfaces' => [
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.secretmanager.v1beta2.SecretManagerService' => [
            'AccessSecretVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/secrets/*/versions/*}:access',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/secrets/*/versions/*}:access',
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
            'AddSecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{parent=projects/*/secrets/*}:addVersion',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/secrets/*}:addVersion',
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
            'CreateSecret' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{parent=projects/*}/secrets',
                'body' => 'secret',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/secrets',
                        'body' => 'secret',
                        'queryParams' => [
                            'secret_id',
                        ],
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'secret_id',
                ],
            ],
            'DeleteSecret' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta2/{name=projects/*/secrets/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/secrets/*}',
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
            'DestroySecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{name=projects/*/secrets/*/versions/*}:destroy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/secrets/*/versions/*}:destroy',
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
            'DisableSecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{name=projects/*/secrets/*/versions/*}:disable',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/secrets/*/versions/*}:disable',
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
            'EnableSecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{name=projects/*/secrets/*/versions/*}:enable',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/secrets/*/versions/*}:enable',
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
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{resource=projects/*/secrets/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{resource=projects/*/locations/*/secrets/*}:getIamPolicy',
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
            'GetSecret' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/secrets/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/secrets/*}',
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
            'GetSecretVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/secrets/*/versions/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/secrets/*/versions/*}',
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
            'ListSecretVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{parent=projects/*/secrets/*}/versions',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/secrets/*}/versions',
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
            'ListSecrets' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{parent=projects/*}/secrets',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/secrets',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{resource=projects/*/secrets/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{resource=projects/*/locations/*/secrets/*}:setIamPolicy',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{resource=projects/*/secrets/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{resource=projects/*/locations/*/secrets/*}:testIamPermissions',
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
            'UpdateSecret' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta2/{secret.name=projects/*/secrets/*}',
                'body' => 'secret',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1beta2/{secret.name=projects/*/locations/*/secrets/*}',
                        'body' => 'secret',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                ],
                'placeholders' => [
                    'secret.name' => [
                        'getters' => [
                            'getSecret',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
