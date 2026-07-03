<?php
/*
 * Copyright 2026 Google LLC
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
        'google.cloud.chronicle.v1.FeaturedContentNativeDashboardService' => [
            'GetFeaturedContentNativeDashboard' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Chronicle\V1\FeaturedContentNativeDashboard',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InstallFeaturedContentNativeDashboard' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Chronicle\V1\InstallFeaturedContentNativeDashboardResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListFeaturedContentNativeDashboards' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getFeaturedContentNativeDashboards',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Chronicle\V1\ListFeaturedContentNativeDashboardsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'contentHub' => 'projects/{project}/locations/{location}/instances/{instance}/contentHub',
                'dashboardChart' => 'projects/{project}/locations/{location}/instances/{instance}/dashboardCharts/{chart}',
                'dashboardQuery' => 'projects/{project}/locations/{location}/instances/{instance}/dashboardQueries/{query}',
                'featuredContentNativeDashboard' => 'projects/{project}/locations/{location}/instances/{instance}/contentHub/featuredContentNativeDashboards/{featured_content_native_dashboard}',
                'instance' => 'projects/{project}/locations/{location}/instances/{instance}',
                'nativeDashboard' => 'projects/{project}/locations/{location}/instances/{instance}/nativeDashboards/{dashboard}',
            ],
        ],
    ],
];
