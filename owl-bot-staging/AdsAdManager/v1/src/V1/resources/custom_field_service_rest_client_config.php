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
        'google.ads.admanager.v1.CustomFieldService' => [
            'BatchActivateCustomFields' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customFields:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateCustomFields' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customFields:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateCustomFields' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customFields:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateCustomFields' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customFields:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCustomField' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/customFields',
                'body' => 'custom_field',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetCustomField' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/customFields/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCustomFields' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/customFields',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCustomField' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{custom_field.name=networks/*/customFields/*}',
                'body' => 'custom_field',
                'placeholders' => [
                    'custom_field.name' => [
                        'getters' => [
                            'getCustomField',
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
