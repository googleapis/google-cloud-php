<?php

return [
    'interfaces' => [
        'google.cloud.ids.v1.IDS' => [
            'CreateEndpoint' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Ids\V1\Endpoint',
                    'metadataReturnType' => '\Google\Cloud\Ids\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '3600000',
                ],
            ],
            'DeleteEndpoint' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Ids\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '3600000',
                ],
            ],
            'ListEndpoints' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEndpoints',
                ],
            ],
        ],
    ],
];
