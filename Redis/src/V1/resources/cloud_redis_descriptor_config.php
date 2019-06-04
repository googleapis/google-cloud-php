<?php

return [
    'interfaces' => [
        'google.cloud.redis.v1.CloudRedis' => [
            'CreateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Redis\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Redis\V1\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '360000',
                    'totalPollTimeoutMillis' => '1200000',
                ],
            ],
            'UpdateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Redis\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Redis\V1\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '360000',
                    'totalPollTimeoutMillis' => '7200000',
                ],
            ],
            'ImportInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Redis\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Redis\V1\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '360000',
                    'totalPollTimeoutMillis' => '18000000',
                ],
            ],
            'ExportInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Redis\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Redis\V1\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '360000',
                    'totalPollTimeoutMillis' => '18000000',
                ],
            ],
            'FailoverInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Redis\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Redis\V1\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '360000',
                    'totalPollTimeoutMillis' => '1200000',
                ],
            ],
            'DeleteInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Redis\V1\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '360000',
                    'totalPollTimeoutMillis' => '1200000',
                ],
            ],
            'ListInstances' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getInstances',
                ],
            ],
        ],
    ],
];
