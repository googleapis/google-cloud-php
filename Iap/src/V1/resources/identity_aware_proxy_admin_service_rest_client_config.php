<?php

return [
    'interfaces' => [
        'google.cloud.iap.v1.IdentityAwareProxyAdminService' => [
            'CreateTunnelDestGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/iap_tunnel/locations/*}/destGroups',
                'body' => 'tunnel_dest_group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'tunnel_dest_group_id',
                ],
            ],
            'DeleteTunnelDestGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/iap_tunnel/locations/*/destGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
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
            'GetTunnelDestGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/iap_tunnel/locations/*/destGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTunnelDestGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/iap_tunnel/locations/*}/destGroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
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
            'UpdateTunnelDestGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tunnel_dest_group.name=projects/*/iap_tunnel/locations/*/destGroups/*}',
                'body' => 'tunnel_dest_group',
                'placeholders' => [
                    'tunnel_dest_group.name' => [
                        'getters' => [
                            'getTunnelDestGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
