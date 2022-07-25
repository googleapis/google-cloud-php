<?php

return [
    'interfaces' => [
        'google.identity.accesscontextmanager.v1.AccessContextManager' => [
            'CommitServicePerimeters' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\CommitServicePerimetersResponse',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateAccessLevel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\AccessLevel',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateAccessPolicy' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\AccessPolicy',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateGcpUserAccessBinding' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\GcpUserAccessBinding',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\GcpUserAccessBindingOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateServicePerimeter' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\ServicePerimeter',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteAccessLevel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteAccessPolicy' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteGcpUserAccessBinding' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\GcpUserAccessBindingOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteServicePerimeter' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ReplaceAccessLevels' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\ReplaceAccessLevelsResponse',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ReplaceServicePerimeters' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\ReplaceServicePerimetersResponse',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateAccessLevel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\AccessLevel',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateAccessPolicy' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\AccessPolicy',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateGcpUserAccessBinding' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\GcpUserAccessBinding',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\GcpUserAccessBindingOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateServicePerimeter' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Identity\AccessContextManager\V1\ServicePerimeter',
                    'metadataReturnType' => '\Google\Identity\AccessContextManager\V1\AccessContextManagerOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListAccessLevels' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAccessLevels',
                ],
            ],
            'ListAccessPolicies' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAccessPolicies',
                ],
            ],
            'ListGcpUserAccessBindings' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getGcpUserAccessBindings',
                ],
            ],
            'ListServicePerimeters' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getServicePerimeters',
                ],
            ],
        ],
    ],
];
