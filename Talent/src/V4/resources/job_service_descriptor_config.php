<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4.JobService' => [
            'BatchCreateJobs' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Talent\V4\BatchCreateJobsResponse',
                    'metadataReturnType' => '\Google\Cloud\Talent\V4\BatchOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'BatchDeleteJobs' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Talent\V4\BatchDeleteJobsResponse',
                    'metadataReturnType' => '\Google\Cloud\Talent\V4\BatchOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'BatchUpdateJobs' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Talent\V4\BatchUpdateJobsResponse',
                    'metadataReturnType' => '\Google\Cloud\Talent\V4\BatchOperationMetadata',
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
