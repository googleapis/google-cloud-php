<?php

return [
    'interfaces' => [
        'google.analytics.data.v1beta.BetaAnalyticsData' => [
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
            'CheckCompatibility' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:checkCompatibility',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'CreateAudienceExport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*}/audienceExports',
                'body' => 'audience_export',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAudienceExport' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/audienceExports/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'ListAudienceExports' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*}/audienceExports',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryAudienceExport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=properties/*/audienceExports/*}:query',
                'body' => '*',
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
        ],
    ],
    'numericEnums' => true,
];
