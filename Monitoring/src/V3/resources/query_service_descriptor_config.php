<?php

return [
    'interfaces' => [
        'google.monitoring.v3.QueryService' => [
            'QueryTimeSeries' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTimeSeriesData',
                ],
            ],
        ],
    ],
];
