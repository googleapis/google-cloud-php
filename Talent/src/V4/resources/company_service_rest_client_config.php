<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4.CompanyService' => [
            'CreateCompany' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/companies',
                'body' => 'company',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteCompany' => [
                'method' => 'delete',
                'uriTemplate' => '/v4/{name=projects/*/tenants/*/companies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCompany' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{name=projects/*/tenants/*/companies/*}',
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
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/companies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCompany' => [
                'method' => 'patch',
                'uriTemplate' => '/v4/{company.name=projects/*/tenants/*/companies/*}',
                'body' => 'company',
                'placeholders' => [
                    'company.name' => [
                        'getters' => [
                            'getCompany',
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
