<?php

return [
    'interfaces' => [
        'google.devtools.cloudbuild.v1.CloudBuild' => [
            'CreateBuild' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Build\V1\Build',
                    'metadataReturnType' => '\Google\Cloud\Build\V1\BuildOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RetryBuild' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Build\V1\Build',
                    'metadataReturnType' => '\Google\Cloud\Build\V1\BuildOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RunBuildTrigger' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Build\V1\Build',
                    'metadataReturnType' => '\Google\Cloud\Build\V1\BuildOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListBuildTriggers' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTriggers',
                ],
            ],
            'ListBuilds' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getBuilds',
                ],
            ],
        ],
    ],
];
