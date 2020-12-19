<?php

return [
    'interfaces' => [
        'google.cloud.recommender.v1.Recommender' => [
            'ListInsights' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/insightTypes/*}/insights',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetInsight' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/insightTypes/*/insights/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MarkInsightAccepted' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/insightTypes/*/insights/*}:markAccepted',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListRecommendations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/recommenders/*}/recommendations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetRecommendation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/recommenders/*/recommendations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MarkRecommendationClaimed' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/recommenders/*/recommendations/*}:markClaimed',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MarkRecommendationSucceeded' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/recommenders/*/recommendations/*}:markSucceeded',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MarkRecommendationFailed' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/recommenders/*/recommendations/*}:markFailed',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
