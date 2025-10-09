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
            'ValidateIapAttributeExpression' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=**}:validateAttributeExpression',
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
