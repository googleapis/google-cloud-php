<?php

return [
    'interfaces' => [
        'google.cloud.orchestration.airflow.service.v1.Environments' => [
            'CreateEnvironment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/environments',
                'body' => 'environment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateUserWorkloadsConfigMap' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/environments/*}/userWorkloadsConfigMaps',
                'body' => 'user_workloads_config_map',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateUserWorkloadsSecret' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/environments/*}/userWorkloadsSecrets',
                'body' => 'user_workloads_secret',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DatabaseFailover' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:databaseFailover',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'DeleteEnvironment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUserWorkloadsConfigMap' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*/userWorkloadsConfigMaps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUserWorkloadsSecret' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*/userWorkloadsSecrets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExecuteAirflowCommand' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:executeAirflowCommand',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'FetchDatabaseProperties' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:fetchDatabaseProperties',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'GetEnvironment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUserWorkloadsConfigMap' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*/userWorkloadsConfigMaps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUserWorkloadsSecret' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*/userWorkloadsSecrets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEnvironments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/environments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUserWorkloadsConfigMaps' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/environments/*}/userWorkloadsConfigMaps',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUserWorkloadsSecrets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/environments/*}/userWorkloadsSecrets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListWorkloads' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/environments/*}/workloads',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LoadSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:loadSnapshot',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'PollAirflowCommand' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:pollAirflowCommand',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'SaveSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:saveSnapshot',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'StopAirflowCommand' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:stopAirflowCommand',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'UpdateEnvironment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*}',
                'body' => 'environment',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateUserWorkloadsConfigMap' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{user_workloads_config_map.name=projects/*/locations/*/environments/*/userWorkloadsConfigMaps/*}',
                'body' => 'user_workloads_config_map',
                'placeholders' => [
                    'user_workloads_config_map.name' => [
                        'getters' => [
                            'getUserWorkloadsConfigMap',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateUserWorkloadsSecret' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{user_workloads_secret.name=projects/*/locations/*/environments/*/userWorkloadsSecrets/*}',
                'body' => 'user_workloads_secret',
                'placeholders' => [
                    'user_workloads_secret.name' => [
                        'getters' => [
                            'getUserWorkloadsSecret',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
