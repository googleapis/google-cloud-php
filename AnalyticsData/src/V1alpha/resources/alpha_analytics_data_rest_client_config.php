<?php

return [
    'interfaces' => [
        'google.analytics.data.v1alpha.AlphaAnalyticsData' => [
            'BatchRunPivotReports' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha:batchRunPivotReports',
                'body' => '*',
            ],
            'BatchRunReports' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha:batchRunReports',
                'body' => '*',
            ],
            'GetMetadata' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/metadata}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunPivotReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha:runPivotReport',
                'body' => '*',
            ],
            'RunRealtimeReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{property=properties/*}:runRealtimeReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'RunReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha:runReport',
                'body' => '*',
            ],
        ],
    ],
];
