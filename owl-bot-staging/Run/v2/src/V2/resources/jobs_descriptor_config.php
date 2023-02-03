<?php

return [
    'interfaces' => [
        'google.cloud.run.v2.Jobs' => [
            'CreateJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Job',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Job',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Job',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Job',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RunJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Execution',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Execution',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Job',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Job',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListJobs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getJobs',
                ],
            ],
        ],
    ],
];
