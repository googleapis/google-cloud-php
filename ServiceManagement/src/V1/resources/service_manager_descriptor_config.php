<?php

return [
    'interfaces' => [
        'google.api.servicemanagement.v1.ServiceManager' => [
            'CreateService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ServiceManagement\V1\ManagedService',
                    'metadataReturnType' => '\Google\Cloud\ServiceManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
            ],
            'CreateServiceRollout' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ServiceManagement\V1\Rollout',
                    'metadataReturnType' => '\Google\Cloud\ServiceManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'DeleteService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\ServiceManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'SubmitConfigSource' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ServiceManagement\V1\SubmitConfigSourceResponse',
                    'metadataReturnType' => '\Google\Cloud\ServiceManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'UndeleteService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ServiceManagement\V1\UndeleteServiceResponse',
                    'metadataReturnType' => '\Google\Cloud\ServiceManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'CreateServiceConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Api\Service',
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'GenerateConfigReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ServiceManagement\V1\GenerateConfigReportResponse',
            ],
            'GetService' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ServiceManagement\V1\ManagedService',
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'GetServiceConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Api\Service',
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                    [
                        'keyName' => 'config_id',
                        'fieldAccessors' => [
                            'getConfigId',
                        ],
                    ],
                ],
            ],
            'GetServiceRollout' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ServiceManagement\V1\Rollout',
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                    [
                        'keyName' => 'rollout_id',
                        'fieldAccessors' => [
                            'getRolloutId',
                        ],
                    ],
                ],
            ],
            'ListServiceConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getServiceConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ServiceManagement\V1\ListServiceConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'ListServiceRollouts' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRollouts',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ServiceManagement\V1\ListServiceRolloutsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'ListServices' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getServices',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ServiceManagement\V1\ListServicesResponse',
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\TestIamPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
        ],
    ],
];
