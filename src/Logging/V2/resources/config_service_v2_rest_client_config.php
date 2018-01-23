<?php

return [
    'interfaces' => [
        'google.logging.v2.ConfigServiceV2' => [
            'ListSinks' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=*/*}/sinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetSink' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{sink_name=*/*/sinks/*}',
                'placeholders' => [
                    'sink_name' => [
                        'getters' => [
                            'getSinkName',
                        ],
                    ],
                ],
            ],
            'CreateSink' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=*/*}/sinks',
                'body' => 'sink',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSink' => [
                'method' => 'put',
                'uriTemplate' => '/v2/{sink_name=*/*/sinks/*}',
                'body' => 'sink',
                'placeholders' => [
                    'sink_name' => [
                        'getters' => [
                            'getSinkName',
                        ],
                    ],
                ],
            ],
            'DeleteSink' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{sink_name=*/*/sinks/*}',
                'placeholders' => [
                    'sink_name' => [
                        'getters' => [
                            'getSinkName',
                        ],
                    ],
                ],
            ],
            'ListExclusions' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=*/*}/exclusions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetExclusion' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=*/*/exclusions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateExclusion' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=*/*}/exclusions',
                'body' => 'exclusion',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateExclusion' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{name=*/*/exclusions/*}',
                'body' => 'exclusion',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExclusion' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=*/*/exclusions/*}',
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
];
