<?php

return [
    'interfaces' => [
        'google.analytics.data.v1alpha.AlphaAnalyticsData' => [
            'CreateAudienceList' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/audienceLists',
                'body' => 'audience_list',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRecurringAudienceList' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/recurringAudienceLists',
                'body' => 'recurring_audience_list',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAudienceList' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/audienceLists/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRecurringAudienceList' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/recurringAudienceLists/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAudienceLists' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/audienceLists',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRecurringAudienceLists' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/recurringAudienceLists',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryAudienceList' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/audienceLists/*}:query',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunFunnelReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{property=properties/*}:runFunnelReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'SheetExportAudienceList' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/audienceLists/*}:exportSheet',
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
    'numericEnums' => true,
];
