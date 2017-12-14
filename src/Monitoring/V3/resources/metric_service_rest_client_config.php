<?php

return [
    'interfaces' => [
        'google.monitoring.v3.MetricService' => [
            'ListMonitoredResourceDescriptors' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*}/monitoredResourceDescriptors',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'GetMonitoredResourceDescriptor' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*/monitoredResourceDescriptors/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListMetricDescriptors' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*}/metricDescriptors',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'GetMetricDescriptor' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*/metricDescriptors/**}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CreateMetricDescriptor' => [
                'method' => 'post',
                'uri' => '/v3/{name=projects/*}/metricDescriptors',
                'body' => 'metric_descriptor',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'DeleteMetricDescriptor' => [
                'method' => 'delete',
                'uri' => '/v3/{name=projects/*/metricDescriptors/**}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListTimeSeries' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*}/timeSeries',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CreateTimeSeries' => [
                'method' => 'post',
                'uri' => '/v3/{name=projects/*}/timeSeries',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
        ],
    ],
];
