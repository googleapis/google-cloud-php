<?php

return [
    'interfaces' => [
        'google.logging.v2.MetricsServiceV2' => [
            'CreateLogMetric' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\LogMetric',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteLogMetric' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'metric_name',
                        'fieldAccessors' => [
                            'getMetricName',
                        ],
                    ],
                ],
            ],
            'GetLogMetric' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\LogMetric',
                'headerParams' => [
                    [
                        'keyName' => 'metric_name',
                        'fieldAccessors' => [
                            'getMetricName',
                        ],
                    ],
                ],
            ],
            'ListLogMetrics' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMetrics',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\ListLogMetricsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateLogMetric' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\LogMetric',
                'headerParams' => [
                    [
                        'keyName' => 'metric_name',
                        'fieldAccessors' => [
                            'getMetricName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'logMetric' => 'projects/{project}/metrics/{metric}',
                'project' => 'projects/{project}',
            ],
        ],
    ],
];
