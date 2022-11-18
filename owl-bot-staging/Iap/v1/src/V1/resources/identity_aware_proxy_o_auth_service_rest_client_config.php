<?php

return [
    'interfaces' => [
        'google.cloud.iap.v1.IdentityAwareProxyOAuthService' => [
            'CreateBrand' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/brands',
                'body' => 'brand',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateIdentityAwareProxyClient' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/brands/*}/identityAwareProxyClients',
                'body' => 'identity_aware_proxy_client',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteIdentityAwareProxyClient' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/brands/*/identityAwareProxyClients/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBrand' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/brands/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIdentityAwareProxyClient' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/brands/*/identityAwareProxyClients/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBrands' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/brands',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIdentityAwareProxyClients' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/brands/*}/identityAwareProxyClients',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResetIdentityAwareProxyClientSecret' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/brands/*/identityAwareProxyClients/*}:resetSecret',
                'body' => '*',
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
