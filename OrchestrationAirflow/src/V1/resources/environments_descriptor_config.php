<?php

return [
    'interfaces' => [
        'google.cloud.orchestration.airflow.service.v1.Environments' => [
            'CreateEnvironment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\Environment',
                    'metadataReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DatabaseFailover' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\DatabaseFailoverResponse',
                    'metadataReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'DeleteEnvironment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'LoadSnapshot' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\LoadSnapshotResponse',
                    'metadataReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'SaveSnapshot' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\SaveSnapshotResponse',
                    'metadataReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'UpdateEnvironment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\Environment',
                    'metadataReturnType' => '\Google\Cloud\Orchestration\Airflow\Service\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateUserWorkloadsConfigMap' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\UserWorkloadsConfigMap',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateUserWorkloadsSecret' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\UserWorkloadsSecret',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteUserWorkloadsConfigMap' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUserWorkloadsSecret' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExecuteAirflowCommand' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\ExecuteAirflowCommandResponse',
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'FetchDatabaseProperties' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\FetchDatabasePropertiesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'GetEnvironment' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\Environment',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUserWorkloadsConfigMap' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\UserWorkloadsConfigMap',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUserWorkloadsSecret' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\UserWorkloadsSecret',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEnvironments' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEnvironments',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\ListEnvironmentsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUserWorkloadsConfigMaps' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getUserWorkloadsConfigMaps',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\ListUserWorkloadsConfigMapsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUserWorkloadsSecrets' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getUserWorkloadsSecrets',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\ListUserWorkloadsSecretsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListWorkloads' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getWorkloads',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\ListWorkloadsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PollAirflowCommand' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\PollAirflowCommandResponse',
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'StopAirflowCommand' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\StopAirflowCommandResponse',
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'UpdateUserWorkloadsConfigMap' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\UserWorkloadsConfigMap',
                'headerParams' => [
                    [
                        'keyName' => 'user_workloads_config_map.name',
                        'fieldAccessors' => [
                            'getUserWorkloadsConfigMap',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateUserWorkloadsSecret' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Orchestration\Airflow\Service\V1\UserWorkloadsSecret',
                'headerParams' => [
                    [
                        'keyName' => 'user_workloads_secret.name',
                        'fieldAccessors' => [
                            'getUserWorkloadsSecret',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'environment' => 'projects/{project}/locations/{location}/environments/{environment}',
                'userWorkloadsConfigMap' => 'projects/{project}/locations/{location}/environments/{environment}/userWorkloadsConfigMaps/{user_workloads_config_map}',
                'userWorkloadsSecret' => 'projects/{project}/locations/{location}/environments/{environment}/userWorkloadsSecrets/{user_workloads_secret}',
            ],
        ],
    ],
];
