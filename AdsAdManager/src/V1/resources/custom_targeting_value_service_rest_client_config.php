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
        'google.ads.admanager.v1.CustomTargetingValueService' => [
            'BatchActivateCustomTargetingValues' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingValues:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateCustomTargetingValues' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingValues:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateCustomTargetingValues' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingValues:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateCustomTargetingValues' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingValues:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCustomTargetingValue' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingValues',
                'body' => 'custom_targeting_value',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetCustomTargetingValue' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/customTargetingValues/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=networks/*/customTargetingKeys/*/customTargetingValues/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCustomTargetingValues' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingValues',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=networks/*/customTargetingKeys/*}/customTargetingValues',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCustomTargetingValue' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{custom_targeting_value.name=networks/*/customTargetingValues/*}',
                'body' => 'custom_targeting_value',
                'placeholders' => [
                    'custom_targeting_value.name' => [
                        'getters' => [
                            'getCustomTargetingValue',
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
