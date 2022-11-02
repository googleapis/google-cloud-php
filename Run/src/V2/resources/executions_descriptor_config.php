<?php

return [
    'interfaces' => [
        'google.cloud.run.v2.Executions' => [
            'DeleteExecution' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Execution',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Execution',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListExecutions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getExecutions',
                ],
            ],
        ],
    ],
];
