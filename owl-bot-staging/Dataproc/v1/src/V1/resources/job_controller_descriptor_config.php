<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1.JobController' => [
            'SubmitJobAsOperation' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\Job',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\JobMetadata',
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
