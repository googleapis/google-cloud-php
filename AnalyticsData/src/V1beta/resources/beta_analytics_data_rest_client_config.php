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
        'google.analytics.data.v1beta.BetaAnalyticsData' => [
            'BatchRunPivotReports' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:batchRunPivotReports',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'BatchRunReports' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:batchRunReports',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'CheckCompatibility' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:checkCompatibility',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'CreateAudienceExport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*}/audienceExports',
                'body' => 'audience_export',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAudienceExport' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/audienceExports/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetadata' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/metadata}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAudienceExports' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*}/audienceExports',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryAudienceExport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=properties/*/audienceExports/*}:query',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunPivotReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:runPivotReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'RunRealtimeReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:runRealtimeReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'RunReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:runReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
