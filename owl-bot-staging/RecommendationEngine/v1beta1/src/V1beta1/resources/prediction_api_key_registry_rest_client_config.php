<?php

return [
    'interfaces' => [
        'google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry' => [
            'CreatePredictionApiKeyRegistration' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/catalogs/*/eventStores/*}/predictionApiKeyRegistrations',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeletePredictionApiKeyRegistration' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/catalogs/*/eventStores/*/predictionApiKeyRegistrations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPredictionApiKeyRegistrations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/catalogs/*/eventStores/*}/predictionApiKeyRegistrations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/catalogs/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/catalogs/*/eventStores/*/operations/*}',
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/catalogs/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/catalogs/*/eventStores/*}/operations',
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
        ],
    ],
];
