<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.ProfileService' => [
            'ListProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{parent=projects/*/tenants/*}/profiles',
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
                'uriTemplate' => '/v4beta1/{parent=projects/*/tenants/*}/profiles',
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
                'uriTemplate' => '/v4beta1/{name=projects/*/tenants/*/profiles/*}',
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
                'uriTemplate' => '/v4beta1/{profile.name=projects/*/tenants/*/profiles/*}',
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
                'uriTemplate' => '/v4beta1/{name=projects/*/tenants/*/profiles/*}',
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
                'uriTemplate' => '/v4beta1/{parent=projects/*/tenants/*}:search',
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
    ],
];
