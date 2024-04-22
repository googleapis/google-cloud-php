<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
    'numericEnums' => true,
];
