<?php

return [
    'interfaces' => [
        'google.spanner.admin.instance.v1.InstanceAdmin' => [
            'CreateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceMetadata',
                    'initialPollDelayMillis' => '20000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '86400000',
                ],
            ],
            'CreateInstanceConfig' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig',
                    'metadataReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceConfigMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceMetadata',
                    'initialPollDelayMillis' => '20000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '86400000',
                ],
            ],
            'UpdateInstanceConfig' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig',
                    'metadataReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceConfigMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListInstanceConfigOperations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getOperations',
                ],
            ],
            'ListInstanceConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getInstanceConfigs',
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
