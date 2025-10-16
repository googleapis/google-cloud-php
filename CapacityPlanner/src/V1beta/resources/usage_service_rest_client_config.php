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
        'google.cloud.capacityplanner.v1beta.UsageService' => [
            'ExportForecasts' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/forecasts:export',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/forecasts:export',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*}/forecasts:export',
                        'body' => '*',
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
            'ExportReservationsUsage' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/reservationsUsage:export',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/reservationsUsage:export',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*}/reservationsUsage:export',
                        'body' => '*',
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
            'ExportUsageHistories' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/usageHistories:export',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/usageHistories:export',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*}/usageHistories:export',
                        'body' => '*',
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
            'QueryForecasts' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/forecasts:query',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/forecasts:query',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*}/forecasts:query',
                        'body' => '*',
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
            'QueryReservations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/reservations:query',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/reservations:query',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*}/reservations:query',
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
            'QueryUsageHistories' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/usageHistories:query',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/usageHistories:query',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*}/usageHistories:query',
                        'body' => '*',
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
        ],
    ],
    'numericEnums' => true,
];
