<?php

return [
    'interfaces' => [
        'google.cloud.aiplatform.v1.IndexEndpointService' => [
            'CreateIndexEndpoint' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\IndexEndpoint',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\CreateIndexEndpointOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteIndexEndpoint' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\DeleteOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeployIndex' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\DeployIndexResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\DeployIndexOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'MutateDeployedIndex' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\MutateDeployedIndexResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\MutateDeployedIndexOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeployIndex' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\UndeployIndexResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\UndeployIndexOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListIndexEndpoints' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getIndexEndpoints',
                ],
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
            ],
        ],
    ],
];
