<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.AnalyticsService' => [
            'ExportAnalyticsMetrics' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Retail\V2\ExportAnalyticsMetricsResponse',
                    'metadataReturnType' => '\Google\Cloud\Retail\V2\ExportMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'catalog',
                        'fieldAccessors' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
