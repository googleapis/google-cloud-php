<?php

return [
    'interfaces' => [
        'google.cloud.iap.v1.IdentityAwareProxyAdminService' => [
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=**}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetIapSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=**}:iapSettings',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=**}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=**}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateIapSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{iap_settings.name=**}:iapSettings',
                'body' => 'iap_settings',
                'placeholders' => [
                    'iap_settings.name' => [
                        'getters' => [
                            'getIapSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
