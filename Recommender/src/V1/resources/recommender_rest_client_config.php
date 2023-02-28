<?php

return [
    'interfaces' => [
        'google.cloud.recommender.v1.Recommender' => [
            'GetInsight' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/insightTypes/*/insights/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=billingAccounts/*/locations/*/insightTypes/*/insights/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/insightTypes/*/insights/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/insightTypes/*/insights/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInsightTypeConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/insightTypes/*/config}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/insightTypes/*/config}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRecommendation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/recommenders/*/recommendations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=billingAccounts/*/locations/*/recommenders/*/recommendations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/recommenders/*/recommendations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/recommenders/*/recommendations/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRecommenderConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/recommenders/*/config}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/recommenders/*/config}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListInsights' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/insightTypes/*}/insights',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=billingAccounts/*/locations/*/insightTypes/*}/insights',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*/insightTypes/*}/insights',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*/insightTypes/*}/insights',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRecommendations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/recommenders/*}/recommendations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=billingAccounts/*/locations/*/recommenders/*}/recommendations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*/recommenders/*}/recommendations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*/recommenders/*}/recommendations',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MarkInsightAccepted' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/insightTypes/*/insights/*}:markAccepted',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=billingAccounts/*/locations/*/insightTypes/*/insights/*}:markAccepted',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/insightTypes/*/insights/*}:markAccepted',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/insightTypes/*/insights/*}:markAccepted',
                        'body' => '*',
                    ],
                ],
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=billingAccounts/*/locations/*/recommenders/*/recommendations/*}:markClaimed',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/recommenders/*/recommendations/*}:markClaimed',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/recommenders/*/recommendations/*}:markClaimed',
                        'body' => '*',
                    ],
                ],
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=billingAccounts/*/locations/*/recommenders/*/recommendations/*}:markFailed',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/recommenders/*/recommendations/*}:markFailed',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/recommenders/*/recommendations/*}:markFailed',
                        'body' => '*',
                    ],
                ],
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=billingAccounts/*/locations/*/recommenders/*/recommendations/*}:markSucceeded',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/recommenders/*/recommendations/*}:markSucceeded',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/recommenders/*/recommendations/*}:markSucceeded',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInsightTypeConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{insight_type_config.name=projects/*/locations/*/insightTypes/*/config}',
                'body' => 'insight_type_config',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{insight_type_config.name=organizations/*/locations/*/insightTypes/*/config}',
                        'body' => 'insight_type_config',
                    ],
                ],
                'placeholders' => [
                    'insight_type_config.name' => [
                        'getters' => [
                            'getInsightTypeConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRecommenderConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{recommender_config.name=projects/*/locations/*/recommenders/*/config}',
                'body' => 'recommender_config',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{recommender_config.name=organizations/*/locations/*/recommenders/*/config}',
                        'body' => 'recommender_config',
                    ],
                ],
                'placeholders' => [
                    'recommender_config.name' => [
                        'getters' => [
                            'getRecommenderConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
