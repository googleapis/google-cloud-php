<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.Organizations' => [
            'SearchOrganizations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getOrganizations',
                ],
            ],
        ],
    ],
];
