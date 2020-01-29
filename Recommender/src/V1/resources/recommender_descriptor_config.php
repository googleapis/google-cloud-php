<?php

return [
    'interfaces' => [
        'google.cloud.recommender.v1.Recommender' => [
            'ListRecommendations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRecommendations',
                ],
            ],
        ],
    ],
];
