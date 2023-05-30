<?php

return [
    'interfaces' => [
        'google.cloud.websecurityscanner.v1.WebSecurityScanner' => [
            'CreateScanConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/scanConfigs',
                'body' => 'scan_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteScanConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/scanConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/scanConfigs/*/scanRuns/*/findings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetScanConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/scanConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetScanRun' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/scanConfigs/*/scanRuns/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCrawledUrls' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/scanConfigs/*/scanRuns/*}/crawledUrls',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFindingTypeStats' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/scanConfigs/*/scanRuns/*}/findingTypeStats',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/scanConfigs/*/scanRuns/*}/findings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListScanConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/scanConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListScanRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/scanConfigs/*}/scanRuns',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'StartScanRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/scanConfigs/*}:start',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopScanRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/scanConfigs/*/scanRuns/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateScanConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{scan_config.name=projects/*/scanConfigs/*}',
                'body' => 'scan_config',
                'placeholders' => [
                    'scan_config.name' => [
                        'getters' => [
                            'getScanConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
