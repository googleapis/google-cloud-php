<?php

return [
    'interfaces' => [
        'google.cloud.baremetalsolution.v2.BareMetalSolution' => [
            'DetachLun' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\Instance',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ResetInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\ResetInstanceResponse',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ResizeVolume' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\Volume',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'StartInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\StartInstanceResponse',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'StopInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\StopInstanceResponse',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\Instance',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateNetwork' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\Network',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateNfsShare' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\NfsShare',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateVolume' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BareMetalSolution\V2\Volume',
                    'metadataReturnType' => '\Google\Cloud\BareMetalSolution\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
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
            'ListLuns' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLuns',
                ],
            ],
            'ListNetworks' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getNetworks',
                ],
            ],
            'ListNfsShares' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getNfsShares',
                ],
            ],
            'ListVolumes' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getVolumes',
                ],
            ],
        ],
    ],
];
