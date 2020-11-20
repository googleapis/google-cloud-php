<?php

return [
    'interfaces' => [
        'google.analytics.data.v1alpha.AlphaAnalyticsData' => [
            'RunReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha:runReport',
                'body' => '*',
            ],
            'RunPivotReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha:runPivotReport',
                'body' => '*',
            ],
            'BatchRunReports' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha:batchRunReports',
                'body' => '*',
            ],
            'BatchRunPivotReports' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha:batchRunPivotReports',
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
        ],
    ],
];
