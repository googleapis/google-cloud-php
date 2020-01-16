<?php

return [
    'interfaces' => [
        'google.cloud.secrets.v1beta1.SecretManagerService' => [
            'ListSecrets' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/secrets',
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
                'uriTemplate' => '/v1beta1/{parent=projects/*}/secrets',
                'body' => 'secret',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'AddSecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/secrets/*}:addVersion',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetSecret' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSecret' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{secret.name=projects/*/secrets/*}',
                'body' => 'secret',
                'placeholders' => [
                    'secret.name' => [
                        'getters' => [
                            'getSecret',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSecret' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*}',
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
                'uriTemplate' => '/v1beta1/{parent=projects/*/secrets/*}/versions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetSecretVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'AccessSecretVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}:access',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}:disable',
                'body' => '*',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}:enable',
                'body' => '*',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}:destroy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{resource=projects/*/secrets/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=projects/*/secrets/*}:getIamPolicy',
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
                'uriTemplate' => '/v1beta1/{resource=projects/*/secrets/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
