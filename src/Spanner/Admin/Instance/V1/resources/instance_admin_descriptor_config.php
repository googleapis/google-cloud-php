<?php

return [
    'interfaces' => [
        'google.spanner.admin.instance.v1.InstanceAdmin' => [
            'createInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceMetadata',
                ],
            ],
            'updateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceMetadata',
                ],
            ],
            'listInstanceConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getInstanceConfigs',
                ],
            ],
            'listInstances' => [
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
