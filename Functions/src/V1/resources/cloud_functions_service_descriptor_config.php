<?php

return [
    'interfaces' => [
        'google.cloud.functions.v1.CloudFunctionsService' => [
            'CreateFunction' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Functions\V1\CloudFunction',
                    'metadataReturnType' => '\Google\Cloud\Functions\V1\OperationMetadataV1',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteFunction' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Functions\V1\OperationMetadataV1',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateFunction' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Functions\V1\CloudFunction',
                    'metadataReturnType' => '\Google\Cloud\Functions\V1\OperationMetadataV1',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListFunctions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getFunctions',
                ],
            ],
        ],
    ],
];
