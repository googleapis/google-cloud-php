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
        'google.cloud.shell.v1.CloudShellService' => [
            'AddPublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=users/*/environments/*}:addPublicKey',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'AuthorizeEnvironment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=users/*/environments/*}:authorize',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEnvironment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*/environments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RemovePublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=users/*/environments/*}:removePublicKey',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'StartEnvironment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=users/*/environments/*}:start',
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
