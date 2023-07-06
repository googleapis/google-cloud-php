<?php

return [
    'interfaces' => [
        'google.cloud.managedidentities.v1.ManagedIdentitiesService' => [
            'AttachTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1\OpMetadata',
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
            'CreateMicrosoftAdDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1\OpMetadata',
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
            'DeleteDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1\OpMetadata',
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
            'DetachTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1\OpMetadata',
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
            'ReconfigureTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1\OpMetadata',
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
            'UpdateDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'domain.name',
                        'fieldAccessors' => [
                            'getDomain',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ValidateTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1\OpMetadata',
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
            'GetDomain' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ManagedIdentities\V1\Domain',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDomains' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDomains',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ManagedIdentities\V1\ListDomainsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResetAdminPassword' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ManagedIdentities\V1\ResetAdminPasswordResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'domain' => 'projects/{project}/locations/{location}/domains/{domain}',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
