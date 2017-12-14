<?php

return [
    'interfaces' => [
        'google.logging.v2.ConfigServiceV2' => [
            'ListSinks' => [
                'method' => 'get',
                'uri' => '/v2/{parent=*/*}/sinks',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetSink' => [
                'method' => 'get',
                'uri' => '/v2/{sink_name=*/*/sinks/*}',
                'placeholders' => [
                    'sink_name' => [
                        'getSink_name',
                    ],
                ],
            ],
            'CreateSink' => [
                'method' => 'post',
                'uri' => '/v2/{parent=*/*}/sinks',
                'body' => 'sink',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'UpdateSink' => [
                'method' => 'put',
                'uri' => '/v2/{sink_name=*/*/sinks/*}',
                'body' => 'sink',
                'placeholders' => [
                    'sink_name' => [
                        'getSink_name',
                    ],
                ],
            ],
            'DeleteSink' => [
                'method' => 'delete',
                'uri' => '/v2/{sink_name=*/*/sinks/*}',
                'placeholders' => [
                    'sink_name' => [
                        'getSink_name',
                    ],
                ],
            ],
            'ListExclusions' => [
                'method' => 'get',
                'uri' => '/v2/{parent=*/*}/exclusions',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetExclusion' => [
                'method' => 'get',
                'uri' => '/v2/{name=*/*/exclusions/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CreateExclusion' => [
                'method' => 'post',
                'uri' => '/v2/{parent=*/*}/exclusions',
                'body' => 'exclusion',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'UpdateExclusion' => [
                'method' => 'patch',
                'uri' => '/v2/{name=*/*/exclusions/*}',
                'body' => 'exclusion',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'DeleteExclusion' => [
                'method' => 'delete',
                'uri' => '/v2/{name=*/*/exclusions/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
        ],
    ],
];
