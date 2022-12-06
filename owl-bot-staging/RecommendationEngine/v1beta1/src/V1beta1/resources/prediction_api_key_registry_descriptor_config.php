<?php

return [
    'interfaces' => [
        'google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry' => [
            'ListPredictionApiKeyRegistrations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getPredictionApiKeyRegistrations',
                ],
            ],
        ],
    ],
];
