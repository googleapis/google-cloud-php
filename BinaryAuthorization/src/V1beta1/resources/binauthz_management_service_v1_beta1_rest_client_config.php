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
    ],
];
