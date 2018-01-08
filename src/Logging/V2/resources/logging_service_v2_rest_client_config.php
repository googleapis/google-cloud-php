<?php

return [
    'interfaces' => [
        'google.logging.v2.LoggingServiceV2' => [
            'DeleteLog' => [
                'method' => 'delete',
                'uriTemplate' => '/v2beta1/{log_name=projects/*/logs/*}',
                'placeholders' => [
                    'log_name' => [
                        'getters' => [
                            'getLogName',
                        ],
                    ],
                ],
            ],
            'WriteLogEntries' => [
                'method' => 'post',
                'uriTemplate' => '/v2/entries:write',
                'body' => '*',
            ],
            'ListLogEntries' => [
                'method' => 'post',
                'uriTemplate' => '/v2/entries:list',
                'body' => '*',
            ],
            'ListMonitoredResourceDescriptors' => [
                'method' => 'get',
                'uriTemplate' => '/v2/monitoredResourceDescriptors',
            ],
            'ListLogs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=*/*}/logs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
