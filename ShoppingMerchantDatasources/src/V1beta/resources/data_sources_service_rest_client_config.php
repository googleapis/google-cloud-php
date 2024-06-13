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
        'google.shopping.merchant.datasources.v1beta.DataSourcesService' => [
            'CreateDataSource' => [
                'method' => 'post',
                'uriTemplate' => '/datasources/v1beta/{parent=accounts/*}/dataSources',
                'body' => 'data_source',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteDataSource' => [
                'method' => 'delete',
                'uriTemplate' => '/datasources/v1beta/{name=accounts/*/dataSources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchDataSource' => [
                'method' => 'post',
                'uriTemplate' => '/datasources/v1beta/{name=accounts/*/dataSources/*}:fetch',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataSource' => [
                'method' => 'get',
                'uriTemplate' => '/datasources/v1beta/{name=accounts/*/dataSources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDataSources' => [
                'method' => 'get',
                'uriTemplate' => '/datasources/v1beta/{parent=accounts/*}/dataSources',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDataSource' => [
                'method' => 'patch',
                'uriTemplate' => '/datasources/v1beta/{data_source.name=accounts/*/dataSources/*}',
                'body' => 'data_source',
                'placeholders' => [
                    'data_source.name' => [
                        'getters' => [
                            'getDataSource',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
