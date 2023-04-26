<?php

return [
    'interfaces' => [
        'google.cloud.orchestration.airflow.service.v1.ImageVersions' => [
            'ListImageVersions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getImageVersions',
                ],
            ],
        ],
    ],
];
