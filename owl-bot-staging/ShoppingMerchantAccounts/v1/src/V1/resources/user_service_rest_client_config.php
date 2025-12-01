<?php
/*
 * Copyright 2025 Google LLC
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
        'google.shopping.merchant.accounts.v1.UserService' => [
            'CreateUser' => [
                'method' => 'post',
                'uriTemplate' => '/accounts/v1/{parent=accounts/*}/users',
                'body' => 'user',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'user_id',
                ],
            ],
            'DeleteUser' => [
                'method' => 'delete',
                'uriTemplate' => '/accounts/v1/{name=accounts/*/users/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUser' => [
                'method' => 'get',
                'uriTemplate' => '/accounts/v1/{name=accounts/*/users/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListUsers' => [
                'method' => 'get',
                'uriTemplate' => '/accounts/v1/{parent=accounts/*}/users',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateUser' => [
                'method' => 'patch',
                'uriTemplate' => '/accounts/v1/{user.name=accounts/*/users/*}',
                'body' => 'user',
                'placeholders' => [
                    'user.name' => [
                        'getters' => [
                            'getUser',
                            'getName',
                        ],
                    ],
                ],
            ],
            'VerifySelf' => [
                'method' => 'patch',
                'uriTemplate' => '/accounts/v1/{account=accounts/*}/users/me:verifySelf',
                'body' => '*',
                'placeholders' => [
                    'account' => [
                        'getters' => [
                            'getAccount',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
