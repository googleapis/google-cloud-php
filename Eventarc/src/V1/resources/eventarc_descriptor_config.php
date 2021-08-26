<?php

return [
    'interfaces' => [
        'google.cloud.eventarc.v1.Eventarc' => [
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
        ],
    ],
];
