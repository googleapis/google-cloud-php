<?php

return [
    'interfaces' => [
        'google.cloud.apigeeconnect.v1.ConnectionService' => [
            'ListConnections' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getConnections',
                ],
            ],
        ],
    ],
];
