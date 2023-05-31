<?php

return [
    'interfaces' => [
        'google.cloud.recommendationengine.v1beta1.PredictionService' => [
            'Predict' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\RecommendationEngine\V1beta1\PredictResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'placement' => 'projects/{project}/locations/{location}/catalogs/{catalog}/eventStores/{event_store}/placements/{placement}',
            ],
        ],
    ],
];
