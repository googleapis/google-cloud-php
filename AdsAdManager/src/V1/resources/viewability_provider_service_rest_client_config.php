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
        'google.ads.admanager.v1.ViewabilityProviderService' => [
            'BatchCreateViewabilityProviders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/viewabilityProviders:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateViewabilityProviders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/viewabilityProviders:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateViewabilityProvider' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/viewabilityProviders',
                'body' => 'viewability_provider',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetViewabilityProvider' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/viewabilityProviders/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListViewabilityProviders' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/viewabilityProviders',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateViewabilityProvider' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{viewability_provider.name=networks/*/viewabilityProviders/*}',
                'body' => 'viewability_provider',
                'placeholders' => [
                    'viewability_provider.name' => [
                        'getters' => [
                            'getViewabilityProvider',
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
