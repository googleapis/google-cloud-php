<?php

return [
    'interfaces' => [
        'google.cloud.optimization.v1.FleetRouting' => [
            'BatchOptimizeTours' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:batchOptimizeTours',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*}:batchOptimizeTours',
                        'body' => '*',
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
            'OptimizeTours' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:optimizeTours',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*}:optimizeTours',
                        'body' => '*',
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
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
