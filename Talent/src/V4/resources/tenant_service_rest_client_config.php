<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4.TenantService' => [
            'CreateTenant' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*}/tenants',
                'body' => 'tenant',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteTenant' => [
                'method' => 'delete',
                'uriTemplate' => '/v4/{name=projects/*/tenants/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTenant' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{name=projects/*/tenants/*}',
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
                'uriTemplate' => '/v4/{parent=projects/*}/tenants',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateTenant' => [
                'method' => 'patch',
                'uriTemplate' => '/v4/{tenant.name=projects/*/tenants/*}',
                'body' => 'tenant',
                'placeholders' => [
                    'tenant.name' => [
                        'getters' => [
                            'getTenant',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{name=projects/*/operations/*}',
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
