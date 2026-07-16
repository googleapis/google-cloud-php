<?php
/*
 * Copyright 2026 Google LLC
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
        'google.showcase.v1beta1.Testing' => [
            'CreateSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/sessions',
                'body' => 'session',
            ],
            'DeleteSession' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=sessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTest' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=sessions/*/tests/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSession' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=sessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSessions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/sessions',
            ],
            'ListTests' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=sessions/*}/tests',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReportSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=sessions/*}:report',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'VerifyTest' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=sessions/*/tests/*}:check',
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
