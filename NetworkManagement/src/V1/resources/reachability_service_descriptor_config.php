<?php

return [
    'interfaces' => [
        'google.cloud.networkmanagement.v1.ReachabilityService' => [
            'CreateConnectivityTest' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\NetworkManagement\V1\ConnectivityTest',
                    'metadataReturnType' => '\Google\Cloud\NetworkManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteConnectivityTest' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\NetworkManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RerunConnectivityTest' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\NetworkManagement\V1\ConnectivityTest',
                    'metadataReturnType' => '\Google\Cloud\NetworkManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateConnectivityTest' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\NetworkManagement\V1\ConnectivityTest',
                    'metadataReturnType' => '\Google\Cloud\NetworkManagement\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListConnectivityTests' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResources',
                ],
            ],
        ],
    ],
];
