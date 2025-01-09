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
        'google.monitoring.v3.ServiceMonitoringService' => [
            'CreateService' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=*/*}/services',
                'body' => 'service',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateServiceLevelObjective' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=*/*/services/*}/serviceLevelObjectives',
                'body' => 'service_level_objective',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteService' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=*/*/services/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteServiceLevelObjective' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=*/*/services/*/serviceLevelObjectives/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetService' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=*/*/services/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServiceLevelObjective' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=*/*/services/*/serviceLevelObjectives/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListServiceLevelObjectives' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=*/*/services/*}/serviceLevelObjectives',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServices' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=*/*}/services',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateService' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{service.name=*/*/services/*}',
                'body' => 'service',
                'placeholders' => [
                    'service.name' => [
                        'getters' => [
                            'getService',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateServiceLevelObjective' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{service_level_objective.name=*/*/services/*/serviceLevelObjectives/*}',
                'body' => 'service_level_objective',
                'placeholders' => [
                    'service_level_objective.name' => [
                        'getters' => [
                            'getServiceLevelObjective',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
