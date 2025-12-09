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
        'google.ads.admanager.v1.CustomTargetingKeyService' => [
            'BatchActivateCustomTargetingKeys' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingKeys:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateCustomTargetingKeys' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingKeys:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateCustomTargetingKeys' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingKeys:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateCustomTargetingKeys' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingKeys:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCustomTargetingKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingKeys',
                'body' => 'custom_targeting_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetCustomTargetingKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/customTargetingKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCustomTargetingKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/customTargetingKeys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCustomTargetingKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{custom_targeting_key.name=networks/*/customTargetingKeys/*}',
                'body' => 'custom_targeting_key',
                'placeholders' => [
                    'custom_targeting_key.name' => [
                        'getters' => [
                            'getCustomTargetingKey',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
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
