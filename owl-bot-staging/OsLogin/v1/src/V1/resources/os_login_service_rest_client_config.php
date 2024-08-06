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
        'google.cloud.oslogin.v1.OsLoginService' => [
            'CreateSshPublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=users/*}/sshPublicKeys',
                'body' => 'ssh_public_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeletePosixAccount' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=users/*/projects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSshPublicKey' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=users/*/sshPublicKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLoginProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*}/loginProfile',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSshPublicKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*/sshPublicKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportSshPublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=users/*}:importSshPublicKey',
                'body' => 'ssh_public_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSshPublicKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=users/*/sshPublicKeys/*}',
                'body' => 'ssh_public_key',
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
