<?php

return [
    'interfaces' => [
        'google.monitoring.v3.UptimeCheckService' => [
            'CreateUptimeCheckConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\UptimeCheckConfig',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteUptimeCheckConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUptimeCheckConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\UptimeCheckConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListUptimeCheckConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getUptimeCheckConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\ListUptimeCheckConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUptimeCheckIps' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getUptimeCheckIps',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\ListUptimeCheckIpsResponse',
            ],
            'UpdateUptimeCheckConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\UptimeCheckConfig',
                'headerParams' => [
                    [
                        'keyName' => 'uptime_check_config.name',
                        'fieldAccessors' => [
                            'getUptimeCheckConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'folderUptimeCheckConfig' => 'folders/{folder}/uptimeCheckConfigs/{uptime_check_config}',
                'organizationUptimeCheckConfig' => 'organizations/{organization}/uptimeCheckConfigs/{uptime_check_config}',
                'projectUptimeCheckConfig' => 'projects/{project}/uptimeCheckConfigs/{uptime_check_config}',
                'uptimeCheckConfig' => 'projects/{project}/uptimeCheckConfigs/{uptime_check_config}',
            ],
        ],
    ],
];
