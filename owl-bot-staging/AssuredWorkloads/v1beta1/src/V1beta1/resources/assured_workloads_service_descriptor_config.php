<?php

return [
    'interfaces' => [
        'google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService' => [
            'CreateWorkload' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AssuredWorkloads\V1beta1\Workload',
                    'metadataReturnType' => '\Google\Cloud\AssuredWorkloads\V1beta1\CreateWorkloadOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListWorkloads' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getWorkloads',
                ],
            ],
        ],
    ],
];
