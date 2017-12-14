<?php

return [
    'interfaces' => [
        'google.monitoring.v3.UptimeCheckService' => [
            'ListUptimeCheckConfigs' => [
                'method' => 'get',
                'uri' => '/v3/{parent=projects/*}/uptimeCheckConfigs',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetUptimeCheckConfig' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*/uptimeCheckConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CreateUptimeCheckConfig' => [
                'method' => 'post',
                'uri' => '/v3/{parent=projects/*}/uptimeCheckConfigs',
                'body' => 'uptime_check_config',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'UpdateUptimeCheckConfig' => [
                'method' => 'patch',
                'uri' => '/v3/{uptime_check_config.name=projects/*/uptimeCheckConfigs/*}',
                'body' => 'uptime_check_config',
                'placeholders' => [
                    'uptime_check_config.name' => [
                        'getUptime_check_config',
                        'getName',
                    ],
                ],
            ],
            'DeleteUptimeCheckConfig' => [
                'method' => 'delete',
                'uri' => '/v3/{name=projects/*/uptimeCheckConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListUptimeCheckIps' => [
                'method' => 'get',
                'uri' => '/v3/uptimeCheckIps',
            ],
        ],
    ],
];
