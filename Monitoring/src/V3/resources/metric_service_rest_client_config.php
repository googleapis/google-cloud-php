<?php

return [
    'interfaces' => [
        'google.monitoring.v3.MetricService' => [
            'ListMonitoredResourceDescriptors' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/monitoredResourceDescriptors',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMonitoredResourceDescriptor' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/monitoredResourceDescriptors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListMetricDescriptors' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/metricDescriptors',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetricDescriptor' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/metricDescriptors/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateMetricDescriptor' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/metricDescriptors',
                'body' => 'metric_descriptor',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMetricDescriptor' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/metricDescriptors/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTimeSeries' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/timeSeries',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateTimeSeries' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/timeSeries',
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
