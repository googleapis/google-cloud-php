<?php
/*
 * Copyright 2025 Google LLC
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
        'google.monitoring.v3.MetricService' => [
            'CreateMetricDescriptor' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/metricDescriptors',
                'body' => 'metric_descriptor',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateServiceTimeSeries' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/timeSeries:createService',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateTimeSeries' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/timeSeries',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMetricDescriptor' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/metricDescriptors/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetricDescriptor' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/metricDescriptors/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMonitoredResourceDescriptor' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/monitoredResourceDescriptors/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListMetricDescriptors' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/metricDescriptors',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListMonitoredResourceDescriptors' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/monitoredResourceDescriptors',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTimeSeries' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/timeSeries',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=organizations/*}/timeSeries',
                        'queryParams' => [
                            'filter',
                            'interval',
                            'view',
                        ],
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=folders/*}/timeSeries',
                        'queryParams' => [
                            'filter',
                            'interval',
                            'view',
                        ],
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'filter',
                    'interval',
                    'view',
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
