<?php

return [
    'interfaces' => [
        'google.monitoring.v3.UptimeCheckService' => [
            'ListUptimeCheckConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*}/uptimeCheckConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetUptimeCheckConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/uptimeCheckConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateUptimeCheckConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*}/uptimeCheckConfigs',
                'body' => 'uptime_check_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateUptimeCheckConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{uptime_check_config.name=projects/*/uptimeCheckConfigs/*}',
                'body' => 'uptime_check_config',
                'placeholders' => [
                    'uptime_check_config.name' => [
                        'getters' => [
                            'getUptimeCheckConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUptimeCheckConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/uptimeCheckConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListUptimeCheckIps' => [
                'method' => 'get',
                'uriTemplate' => '/v3/uptimeCheckIps',
            ],
        ],
    ],
];
