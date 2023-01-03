<?php

return [
    'interfaces' => [
        'google.api.serviceusage.v1.ServiceUsage' => [
            'BatchEnableServices' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ServiceUsage\V1\BatchEnableServicesResponse',
                    'metadataReturnType' => '\Google\Cloud\ServiceUsage\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DisableService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ServiceUsage\V1\DisableServiceResponse',
                    'metadataReturnType' => '\Google\Cloud\ServiceUsage\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'EnableService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ServiceUsage\V1\EnableServiceResponse',
                    'metadataReturnType' => '\Google\Cloud\ServiceUsage\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
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
            ],
        ],
    ],
];
