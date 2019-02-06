<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.ProfileService' => [
            'ListProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{parent=projects/*/companies/*}/profiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v4beta1/{parent=projects/*/companies/*}/profiles',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{name=projects/*/companies/*/profiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProfile' => [
                'method' => 'patch',
                'uriTemplate' => '/v4beta1/{profile.name=projects/*/companies/*/profiles/*}',
                'body' => '*',
                'placeholders' => [
                    'profile.name' => [
                        'getters' => [
                            'getProfile',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteProfile' => [
                'method' => 'delete',
                'uriTemplate' => '/v4beta1/{name=projects/*/companies/*/profiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchProfiles' => [
                'method' => 'post',
                'uriTemplate' => '/v4beta1/{parent=projects/*/companies/*}:search',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3p1beta1/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v4beta1/{name=projects/*/operations/*}',
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
        ],
    ],
];
