<?php

return [
    'interfaces' => [
        'google.logging.v2.MetricsServiceV2' => [
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
        ],
    ],
];
