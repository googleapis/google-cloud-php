<?php

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
];
