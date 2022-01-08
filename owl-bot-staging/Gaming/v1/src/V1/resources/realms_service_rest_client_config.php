<?php

return [
    'interfaces' => [
        'google.cloud.gaming.v1.RealmsService' => [
            'CreateRealm' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/realms',
                'body' => 'realm',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'realm_id',
                ],
            ],
            'DeleteRealm' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/realms/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRealm' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/realms/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListRealms' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/realms',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewRealmUpdate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{realm.name=projects/*/locations/*/realms/*}:previewUpdate',
                'body' => 'realm',
                'placeholders' => [
                    'realm.name' => [
                        'getters' => [
                            'getRealm',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRealm' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{realm.name=projects/*/locations/*/realms/*}',
                'body' => 'realm',
                'placeholders' => [
                    'realm.name' => [
                        'getters' => [
                            'getRealm',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
];
