<?php

return [
    'interfaces' => [
        'google.cloud.beyondcorp.appconnectors.v1.AppConnectorsService' => [
            'CreateAppConnector' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnector',
                    'metadataReturnType' => '\Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnectorOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteAppConnector' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnectorOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ReportStatus' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnector',
                    'metadataReturnType' => '\Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnectorOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateAppConnector' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnector',
                    'metadataReturnType' => '\Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnectorOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListAppConnectors' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAppConnectors',
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
