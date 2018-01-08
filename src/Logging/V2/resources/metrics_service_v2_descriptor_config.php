<?php

return [
    'interfaces' => [
        'google.logging.v2.MetricsServiceV2' => [
            'ListLogMetrics' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMetrics',
                ],
            ],
        ],
    ],
];
