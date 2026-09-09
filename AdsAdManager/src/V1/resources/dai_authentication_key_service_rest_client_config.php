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
        'google.ads.admanager.v1.DaiAuthenticationKeyService' => [
            'BatchActivateDaiAuthenticationKeys' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiAuthenticationKeys:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateDaiAuthenticationKeys' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiAuthenticationKeys:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateDaiAuthenticationKeys' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiAuthenticationKeys:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateDaiAuthenticationKeys' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiAuthenticationKeys:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDaiAuthenticationKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiAuthenticationKeys',
                'body' => 'dai_authentication_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetDaiAuthenticationKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/daiAuthenticationKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDaiAuthenticationKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/daiAuthenticationKeys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDaiAuthenticationKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{dai_authentication_key.name=networks/*/daiAuthenticationKeys/*}',
                'body' => 'dai_authentication_key',
                'placeholders' => [
                    'dai_authentication_key.name' => [
                        'getters' => [
                            'getDaiAuthenticationKey',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}:cancel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
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
