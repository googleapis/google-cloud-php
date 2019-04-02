<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.ApplicationService' => [
            'CreateApplication' => [
                'method' => 'post',
                'uriTemplate' => '/v4beta1/{parent=projects/*/tenants/*/profiles/*}/applications',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetApplication' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{name=projects/*/tenants/*/profiles/*/applications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApplication' => [
                'method' => 'patch',
                'uriTemplate' => '/v4beta1/{application.name=projects/*/tenants/*/profiles/*/applications/*}',
                'body' => '*',
                'placeholders' => [
                    'application.name' => [
                        'getters' => [
                            'getApplication',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApplication' => [
                'method' => 'delete',
                'uriTemplate' => '/v4beta1/{name=projects/*/tenants/*/profiles/*/applications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApplications' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{parent=projects/*/tenants/*/profiles/*}/applications',
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
