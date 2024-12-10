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
        'google.cloud.secrets.v1beta1.SecretManagerService' => [
            'AccessSecretVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}:access',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'AddSecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/secrets/*}:addVersion',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSecret' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/secrets',
                'body' => 'secret',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'secret_id',
                ],
            ],
            'DeleteSecret' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DestroySecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}:destroy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DisableSecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}:disable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EnableSecretVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}:enable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=projects/*/secrets/*}:getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetSecret' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSecretVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/secrets/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSecretVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/secrets/*}/versions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSecrets' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/secrets',
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
                'uriTemplate' => '/v1beta1/{resource=projects/*/secrets/*}:setIamPolicy',
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
                'uriTemplate' => '/v1beta1/{resource=projects/*/secrets/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateSecret' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{secret.name=projects/*/secrets/*}',
                'body' => 'secret',
                'placeholders' => [
                    'secret.name' => [
                        'getters' => [
                            'getSecret',
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
    'numericEnums' => true,
];
