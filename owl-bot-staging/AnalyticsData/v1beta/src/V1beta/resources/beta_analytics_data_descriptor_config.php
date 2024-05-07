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
            'CreateAudienceExport' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Analytics\Data\V1beta\AudienceExport',
                    'metadataReturnType' => '\Google\Analytics\Data\V1beta\AudienceExportMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRunPivotReports' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\BatchRunPivotReportsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'BatchRunReports' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\BatchRunReportsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'CheckCompatibility' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\CheckCompatibilityResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'GetAudienceExport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\AudienceExport',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetadata' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\Metadata',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAudienceExports' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAudienceExports',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\ListAudienceExportsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryAudienceExport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\QueryAudienceExportResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunPivotReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\RunPivotReportResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'RunRealtimeReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\RunRealtimeReportResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'RunReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Analytics\Data\V1beta\RunReportResponse',
                'headerParams' => [
                    [
                        'keyName' => 'property',
                        'fieldAccessors' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'audienceExport' => 'properties/{property}/audienceExports/{audience_export}',
                'metadata' => 'properties/{property}/metadata',
                'property' => 'properties/{property}',
            ],
        ],
    ],
];
