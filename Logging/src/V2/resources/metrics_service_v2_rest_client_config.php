<?php

return [
    'interfaces' => [
        'google.logging.v2.MetricsServiceV2' => [
            'CreateLogMetric' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/metrics',
                'body' => 'metric',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteLogMetric' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{metric_name=projects/*/metrics/*}',
                'placeholders' => [
                    'metric_name' => [
                        'getters' => [
                            'getMetricName',
                        ],
                    ],
                ],
            ],
            'GetLogMetric' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{metric_name=projects/*/metrics/*}',
                'placeholders' => [
                    'metric_name' => [
                        'getters' => [
                            'getMetricName',
                        ],
                    ],
                ],
            ],
            'ListLogMetrics' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/metrics',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateLogMetric' => [
                'method' => 'put',
                'uriTemplate' => '/v2/{metric_name=projects/*/metrics/*}',
                'body' => 'metric',
                'placeholders' => [
                    'metric_name' => [
                        'getters' => [
                            'getMetricName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=*/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:cancel',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/operations/*}:cancel',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*/operations/*}:cancel',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=billingAccounts/*/locations/*/operations/*}:cancel',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=*/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=billingAccounts/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=*/*/locations/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=billingAccounts/*/locations/*}/operations',
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
