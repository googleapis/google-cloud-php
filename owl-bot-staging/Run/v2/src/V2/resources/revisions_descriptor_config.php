<?php

return [
    'interfaces' => [
        'google.cloud.run.v2.Revisions' => [
            'DeleteRevision' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Revision',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Revision',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListRevisions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRevisions',
                ],
            ],
        ],
    ],
];
