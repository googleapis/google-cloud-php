<?php

return [
    'interfaces' => [
        'google.cloud.policysimulator.v1.Simulator' => [
            'CreateReplay' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/replays',
                'body' => 'replay',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/replays',
                        'body' => 'replay',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/replays',
                        'body' => 'replay',
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
            'GetReplay' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/replays/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/replays/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/replays/*}',
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
            'ListReplayResults' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/replays/*}/results',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*/replays/*}/results',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*/replays/*}/results',
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
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=operations/**}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/replays/*/operations/**}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/replays/*/operations/**}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/replays/*/operations/**}',
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
                'uriTemplate' => '/v1/{name=operations}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/replays/*/operations}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/replays/*/operations}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/replays/*/operations}',
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
    'numericEnums' => true,
];
