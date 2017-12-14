<?php

return [
    'interfaces' => [
        'google.logging.v2.MetricsServiceV2' => [
            'ListLogMetrics' => [
                'method' => 'get',
                'uri' => '/v2/{parent=projects/*}/metrics',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetLogMetric' => [
                'method' => 'get',
                'uri' => '/v2/{metric_name=projects/*/metrics/*}',
                'placeholders' => [
                    'metric_name' => [
                        'getMetric_name',
                    ],
                ],
            ],
            'CreateLogMetric' => [
                'method' => 'post',
                'uri' => '/v2/{parent=projects/*}/metrics',
                'body' => 'metric',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'UpdateLogMetric' => [
                'method' => 'put',
                'uri' => '/v2/{metric_name=projects/*/metrics/*}',
                'body' => 'metric',
                'placeholders' => [
                    'metric_name' => [
                        'getMetric_name',
                    ],
                ],
            ],
            'DeleteLogMetric' => [
                'method' => 'delete',
                'uri' => '/v2/{metric_name=projects/*/metrics/*}',
                'placeholders' => [
                    'metric_name' => [
                        'getMetric_name',
                    ],
                ],
            ],
        ],
    ],
];
