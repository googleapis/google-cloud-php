<?php

return [
    'interfaces' => [
        'google.analytics.data.v1alpha.AlphaAnalyticsData' => [
            'CreateAudienceList' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Analytics\Data\V1alpha\AudienceList',
                    'metadataReturnType' => '\Google\Analytics\Data\V1alpha\AudienceListMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListAudienceLists' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAudienceLists',
                ],
            ],
            'ListRecurringAudienceLists' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRecurringAudienceLists',
                ],
            ],
        ],
    ],
];
