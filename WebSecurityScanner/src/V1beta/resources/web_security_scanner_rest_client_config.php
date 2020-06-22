<?php

return [
    'interfaces' => [
        'google.cloud.websecurityscanner.v1beta.WebSecurityScanner' => [
            'CreateScanConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*}/scanConfigs',
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
                'uriTemplate' => '/v1beta/{name=projects/*/scanConfigs/*}',
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
                'uriTemplate' => '/v1beta/{name=projects/*/scanConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListScanConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*}/scanConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateScanConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{scan_config.name=projects/*/scanConfigs/*}',
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
            'StartScanRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=projects/*/scanConfigs/*}:start',
                'body' => '*',
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
                'uriTemplate' => '/v1beta/{name=projects/*/scanConfigs/*/scanRuns/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListScanRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/scanConfigs/*}/scanRuns',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'StopScanRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=projects/*/scanConfigs/*/scanRuns/*}:stop',
                'body' => '*',
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
                'uriTemplate' => '/v1beta/{parent=projects/*/scanConfigs/*/scanRuns/*}/crawledUrls',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetFinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/scanConfigs/*/scanRuns/*/findings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListFindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/scanConfigs/*/scanRuns/*}/findings',
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
                'uriTemplate' => '/v1beta/{parent=projects/*/scanConfigs/*/scanRuns/*}/findingTypeStats',
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
