<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.TenantService' => [
            'CreateTenant' => [
                'method' => 'post',
                'uriTemplate' => '/v4beta1/{parent=projects/*}/tenants',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetTenant' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{name=projects/*/tenants/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTenant' => [
                'method' => 'patch',
                'uriTemplate' => '/v4beta1/{tenant.name=projects/*/tenants/*}',
                'body' => '*',
                'placeholders' => [
                    'tenant.name' => [
                        'getters' => [
                            'getTenant',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTenant' => [
                'method' => 'delete',
                'uriTemplate' => '/v4beta1/{name=projects/*/tenants/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTenants' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{parent=projects/*}/tenants',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
