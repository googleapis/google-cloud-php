<?php

return [
    'interfaces' => [
        'google.analytics.data.v1beta.BetaAnalyticsData' => [
            'BatchRunPivotReports' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\BatchRunPivotReportsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'BatchRunReports' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\BatchRunReportsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'CheckCompatibility' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\CheckCompatibilityResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'GetMetadata' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\Metadata',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunPivotReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\RunPivotReportResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'RunRealtimeReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\RunRealtimeReportResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'RunReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\RunReportResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'metadata' => 'properties/{property}/metadata',
            ],
        ],
    ],
];
