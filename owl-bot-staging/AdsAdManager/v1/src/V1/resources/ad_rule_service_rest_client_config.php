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
        'google.ads.admanager.v1.AdRuleService' => [
            'BatchActivateAdRules' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/adRules:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateAdRules' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/adRules:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateAdRules' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/adRules:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteAdRules' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/adRules:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateAdRules' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/adRules:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAdRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/adRules',
                'body' => 'ad_rule',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAdRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/adRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAdRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/adRules',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAdRule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{ad_rule.name=networks/*/adRules/*}',
                'body' => 'ad_rule',
                'placeholders' => [
                    'ad_rule.name' => [
                        'getters' => [
                            'getAdRule',
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
