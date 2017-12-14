<?php

return [
    'interfaces' => [
        'google.logging.v2.LoggingServiceV2' => [
            'DeleteLog' => [
                'method' => 'delete',
                'uri' => '/v2beta1/{log_name=projects/*/logs/*}',
                'placeholders' => [
                    'log_name' => [
                        'getLog_name',
                    ],
                ],
            ],
            'WriteLogEntries' => [
                'method' => 'post',
                'uri' => '/v2/entries:write',
                'body' => '*',
            ],
            'ListLogEntries' => [
                'method' => 'post',
                'uri' => '/v2/entries:list',
                'body' => '*',
            ],
            'ListMonitoredResourceDescriptors' => [
                'method' => 'get',
                'uri' => '/v2/monitoredResourceDescriptors',
            ],
            'ListLogs' => [
                'method' => 'get',
                'uri' => '/v2/{parent=*/*}/logs',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
        ],
    ],
];
