<?php

return [
    'interfaces' => [
        'google.cloud.resourcesettings.v1.ResourceSettingsService' => [
            'ListSettings' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSettings',
                ],
            ],
        ],
    ],
];
