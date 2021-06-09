<?php

return [
    'interfaces' => [
        'google.monitoring.v3.MetricService' => [
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
            'GetMonitoredResourceDescriptor' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/monitoredResourceDescriptors/**}',
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
            'ListTimeSeries' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/timeSeries',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=organizations/*}/timeSeries',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=folders/*}/timeSeries',
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
