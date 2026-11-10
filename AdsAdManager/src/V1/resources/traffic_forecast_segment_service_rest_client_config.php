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
        'google.ads.admanager.v1.TrafficForecastSegmentService' => [
            'BatchCreateTrafficForecastSegments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/trafficForecastSegments:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateTrafficForecastSegments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/trafficForecastSegments:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTrafficForecastSegment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/trafficForecastSegments',
                'body' => 'traffic_forecast_segment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetTrafficForecastSegment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/trafficForecastSegments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTrafficForecastSegments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/trafficForecastSegments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateTrafficForecastSegment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{traffic_forecast_segment.name=networks/*/trafficForecastSegments/*}',
                'body' => 'traffic_forecast_segment',
                'placeholders' => [
                    'traffic_forecast_segment.name' => [
                        'getters' => [
                            'getTrafficForecastSegment',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}:cancel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
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
