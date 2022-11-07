<?php

return [
    'interfaces' => [
        'google.cloud.eventarc.v1.Eventarc' => [
            'CreateChannel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Eventarc\V1\Channel',
                    'metadataReturnType' => '\Google\Cloud\Eventarc\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateChannelConnection' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Eventarc\V1\ChannelConnection',
                    'metadataReturnType' => '\Google\Cloud\Eventarc\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateTrigger' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Eventarc\V1\Trigger',
                    'metadataReturnType' => '\Google\Cloud\Eventarc\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteChannel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Eventarc\V1\Channel',
                    'metadataReturnType' => '\Google\Cloud\Eventarc\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteChannelConnection' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Eventarc\V1\ChannelConnection',
                    'metadataReturnType' => '\Google\Cloud\Eventarc\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteTrigger' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Eventarc\V1\Trigger',
                    'metadataReturnType' => '\Google\Cloud\Eventarc\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateChannel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Eventarc\V1\Channel',
                    'metadataReturnType' => '\Google\Cloud\Eventarc\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateTrigger' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Eventarc\V1\Trigger',
                    'metadataReturnType' => '\Google\Cloud\Eventarc\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListChannelConnections' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getChannelConnections',
                ],
            ],
            'ListChannels' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getChannels',
                ],
            ],
            'ListProviders' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProviders',
                ],
            ],
            'ListTriggers' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTriggers',
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
