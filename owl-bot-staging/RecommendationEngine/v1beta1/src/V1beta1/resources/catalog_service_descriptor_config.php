<?php

return [
    'interfaces' => [
        'google.cloud.recommendationengine.v1beta1.CatalogService' => [
            'ImportCatalogItems' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\RecommendationEngine\V1beta1\ImportCatalogItemsResponse',
                    'metadataReturnType' => '\Google\Cloud\RecommendationEngine\V1beta1\ImportMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListCatalogItems' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCatalogItems',
                ],
            ],
        ],
    ],
];
