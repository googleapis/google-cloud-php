<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.CompanyService' => [
            'CreateCompany' => [
                'method' => 'post',
                'uriTemplate' => '/v4beta1/{parent=projects/*/tenants/*}/companies',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v4beta1/{parent=projects/*}/companies',
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
            'GetCompany' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{name=projects/*/tenants/*/companies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v4beta1/{name=projects/*/companies/*}',
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
            'UpdateCompany' => [
                'method' => 'patch',
                'uriTemplate' => '/v4beta1/{company.name=projects/*/tenants/*/companies/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v4beta1/{company.name=projects/*/companies/*}',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'company.name' => [
                        'getters' => [
                            'getCompany',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCompany' => [
                'method' => 'delete',
                'uriTemplate' => '/v4beta1/{name=projects/*/tenants/*/companies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v4beta1/{name=projects/*/companies/*}',
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
            'ListCompanies' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{parent=projects/*/tenants/*}/companies',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v4beta1/{parent=projects/*}/companies',
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
        ],
    ],
];
