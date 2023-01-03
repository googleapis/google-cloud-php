<?php

return [
    'interfaces' => [
        'google.cloud.resourcesettings.v1.ResourceSettingsService' => [
            'GetSetting' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/settings/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/settings/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/settings/*}',
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
            'ListSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*}/settings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/settings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*}/settings',
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
            'UpdateSetting' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{setting.name=organizations/*/settings/*}',
                'body' => 'setting',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{setting.name=folders/*/settings/*}',
                        'body' => 'setting',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{setting.name=projects/*/settings/*}',
                        'body' => 'setting',
                    ],
                ],
                'placeholders' => [
                    'setting.name' => [
                        'getters' => [
                            'getSetting',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
