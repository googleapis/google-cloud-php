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
        'google.analytics.data.v1alpha.AlphaAnalyticsData' => [
            'CreateAudienceList' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/audienceLists',
                'body' => 'audience_list',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRecurringAudienceList' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/recurringAudienceLists',
                'body' => 'recurring_audience_list',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateReportTask' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/reportTasks',
                'body' => 'report_task',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAudienceList' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/audienceLists/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPropertyQuotasSnapshot' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/propertyQuotasSnapshot}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRecurringAudienceList' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/recurringAudienceLists/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetReportTask' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/reportTasks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAudienceLists' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/audienceLists',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRecurringAudienceLists' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/recurringAudienceLists',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReportTasks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/reportTasks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryAudienceList' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/audienceLists/*}:query',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'QueryReportTask' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/reportTasks/*}:query',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunFunnelReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{property=properties/*}:runFunnelReport',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'SheetExportAudienceList' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/audienceLists/*}:exportSheet',
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
    'numericEnums' => true,
];
