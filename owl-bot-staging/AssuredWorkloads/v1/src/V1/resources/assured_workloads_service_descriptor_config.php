<?php

return [
    'interfaces' => [
        'google.cloud.assuredworkloads.v1.AssuredWorkloadsService' => [
            'CreateWorkload' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AssuredWorkloads\V1\Workload',
                    'metadataReturnType' => '\Google\Cloud\AssuredWorkloads\V1\CreateWorkloadOperationMetadata',
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
            'AcknowledgeViolation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AssuredWorkloads\V1\AcknowledgeViolationResponse',
            ],
            'DeleteWorkload' => [
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
            'GetViolation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AssuredWorkloads\V1\Violation',
            ],
            'GetWorkload' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AssuredWorkloads\V1\Workload',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListViolations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getViolations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AssuredWorkloads\V1\ListViolationsResponse',
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
                'responseType' => 'Google\Cloud\AssuredWorkloads\V1\ListWorkloadsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RestrictAllowedResources' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AssuredWorkloads\V1\RestrictAllowedResourcesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateWorkload' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AssuredWorkloads\V1\Workload',
                'headerParams' => [
                    [
                        'keyName' => 'workload.name',
                        'fieldAccessors' => [
                            'getWorkload',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'location' => 'organizations/{organization}/locations/{location}',
                'violation' => 'organizations/{organization}/locations/{location}/workloads/{workload}/violations/{violation}',
                'workload' => 'organizations/{organization}/locations/{location}/workloads/{workload}',
            ],
        ],
    ],
];
