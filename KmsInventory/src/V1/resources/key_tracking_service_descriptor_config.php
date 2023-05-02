<?php

return [
    'interfaces' => [
        'google.cloud.kms.inventory.v1.KeyTrackingService' => [
            'SearchProtectedResources' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProtectedResources',
                ],
            ],
        ],
    ],
];
