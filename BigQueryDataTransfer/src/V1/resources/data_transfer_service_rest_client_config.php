<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.datatransfer.v1.DataTransferService' => [
            'GetDataSource' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataSources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDataSources' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataSources',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTransferConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/transferConfigs',
                'body' => 'transfer_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateTransferConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{transfer_config.name=projects/*/locations/*/transferConfigs/*}',
                'body' => 'transfer_config',
                'placeholders' => [
                    'transfer_config.name' => [
                        'getters' => [
                            'getTransferConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTransferConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/transferConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTransferConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/transferConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTransferConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/transferConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ScheduleTransferRuns' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/transferConfigs/*}:scheduleRuns',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetTransferRun' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/transferConfigs/*/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTransferRun' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/transferConfigs/*/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTransferRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/transferConfigs/*}/runs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTransferLogs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/transferConfigs/*/runs/*}/transferLogs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CheckValidCreds' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataSources/*}:checkValidCreds',
                'body' => '*',
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
