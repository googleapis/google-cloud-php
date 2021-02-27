<?php

return [
    'interfaces' => [
        'google.analytics.data.v1beta.BetaAnalyticsData' => [
            'RunReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:runReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'RunPivotReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:runPivotReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'BatchRunReports' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:batchRunReports',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'BatchRunPivotReports' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:batchRunPivotReports',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'GetMetadata' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/metadata}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunRealtimeReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:runRealtimeReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
