<?php

return [
    'interfaces' => [
        'google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1' => [
            'CreateAttestor' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/attestors',
                'body' => 'attestor',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'attestor_id',
                ],
            ],
            'DeleteAttestor' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/attestors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAttestor' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/attestors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/policy}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAttestors' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/attestors',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAttestor' => [
                'method' => 'put',
                'uriTemplate' => '/v1beta1/{attestor.name=projects/*/attestors/*}',
                'body' => 'attestor',
                'placeholders' => [
                    'attestor.name' => [
                        'getters' => [
                            'getAttestor',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePolicy' => [
                'method' => 'put',
                'uriTemplate' => '/v1beta1/{policy.name=projects/*/policy}',
                'body' => 'policy',
                'placeholders' => [
                    'policy.name' => [
                        'getters' => [
                            'getPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=projects/*/policy}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/attestors/*}:getIamPolicy',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{resource=projects/*/policy}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/attestors/*}:setIamPolicy',
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
                'uriTemplate' => '/v1beta1/{resource=projects/*/policy}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/attestors/*}:testIamPermissions',
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
        ],
    ],
];
