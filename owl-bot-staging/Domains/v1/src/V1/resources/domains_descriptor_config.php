<?php

return [
    'interfaces' => [
        'google.cloud.domains.v1.Domains' => [
            'ConfigureContactSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'registration',
                        'fieldAccessors' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'ConfigureDnsSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'registration',
                        'fieldAccessors' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'ConfigureManagementSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'registration',
                        'fieldAccessors' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'DeleteRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1\OperationMetadata',
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
            'ExportRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1\OperationMetadata',
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
            'RegisterDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1\OperationMetadata',
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
            'TransferDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1\OperationMetadata',
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
            'UpdateRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'registration.name',
                        'fieldAccessors' => [
                            'getRegistration',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRegistration' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Domains\V1\Registration',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListRegistrations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRegistrations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Domains\V1\ListRegistrationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResetAuthorizationCode' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Domains\V1\AuthorizationCode',
                'headerParams' => [
                    [
                        'keyName' => 'registration',
                        'fieldAccessors' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'RetrieveAuthorizationCode' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Domains\V1\AuthorizationCode',
                'headerParams' => [
                    [
                        'keyName' => 'registration',
                        'fieldAccessors' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'RetrieveRegisterParameters' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Domains\V1\RetrieveRegisterParametersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'RetrieveTransferParameters' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Domains\V1\RetrieveTransferParametersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'SearchDomains' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Domains\V1\SearchDomainsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'location' => 'projects/{project}/locations/{location}',
                'registration' => 'projects/{project}/locations/{location}/registrations/{registration}',
            ],
        ],
    ],
];
