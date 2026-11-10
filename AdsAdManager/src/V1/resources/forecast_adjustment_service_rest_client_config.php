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
        'google.ads.admanager.v1.ForecastAdjustmentService' => [
            'BatchActivateForecastAdjustments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/forecastAdjustments:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateForecastAdjustments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/forecastAdjustments:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateForecastAdjustments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/forecastAdjustments:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateForecastAdjustments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/forecastAdjustments:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CalculateDailyAdOpportunityCounts' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/forecastAdjustments:calculateDailyAdOpportunityCounts',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateForecastAdjustment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/forecastAdjustments',
                'body' => 'forecast_adjustment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetForecastAdjustment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/forecastAdjustments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListForecastAdjustments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/forecastAdjustments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateForecastAdjustment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{forecast_adjustment.name=networks/*/forecastAdjustments/*}',
                'body' => 'forecast_adjustment',
                'placeholders' => [
                    'forecast_adjustment.name' => [
                        'getters' => [
                            'getForecastAdjustment',
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
