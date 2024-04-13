<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
