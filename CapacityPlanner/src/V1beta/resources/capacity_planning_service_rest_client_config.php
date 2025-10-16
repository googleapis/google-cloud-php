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
        'google.cloud.capacityplanner.v1beta.CapacityPlanningService' => [
            'GetCapacityPlan' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/capacityPlans/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'QueryCapacityPlanInsights' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*}/capacityPlanInsights:query',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryCapacityPlans' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=organizations/*}/capacityPlans:query',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=folders/*}/capacityPlans:query',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=projects/*}/capacityPlans:query',
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
