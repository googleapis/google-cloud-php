<?php

return [
    'interfaces' => [
        'google.analytics.data.v1beta.BetaAnalyticsData' => [
            'RunReport' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDimensionHeaders',
                ],
            ],
        ],
    ],
];
