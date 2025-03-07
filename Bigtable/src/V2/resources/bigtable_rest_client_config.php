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
        'google.bigtable.v2.Bigtable' => [
            'CheckAndMutateRow' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:checkAndMutateRow',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{authorized_view_name=projects/*/instances/*/tables/*/authorizedViews/*}:checkAndMutateRow',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'authorized_view_name' => [
                        'getters' => [
                            'getAuthorizedViewName',
                        ],
                    ],
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'ExecuteQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{instance_name=projects/*/instances/*}:executeQuery',
                'body' => '*',
                'placeholders' => [
                    'instance_name' => [
                        'getters' => [
                            'getInstanceName',
                        ],
                    ],
                ],
            ],
            'GenerateInitialChangeStreamPartitions' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:generateInitialChangeStreamPartitions',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'MutateRow' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:mutateRow',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{authorized_view_name=projects/*/instances/*/tables/*/authorizedViews/*}:mutateRow',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'authorized_view_name' => [
                        'getters' => [
                            'getAuthorizedViewName',
                        ],
                    ],
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'MutateRows' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:mutateRows',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{authorized_view_name=projects/*/instances/*/tables/*/authorizedViews/*}:mutateRows',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'authorized_view_name' => [
                        'getters' => [
                            'getAuthorizedViewName',
                        ],
                    ],
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'PingAndWarm' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/instances/*}:ping',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'PrepareQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{instance_name=projects/*/instances/*}:prepareQuery',
                'body' => '*',
                'placeholders' => [
                    'instance_name' => [
                        'getters' => [
                            'getInstanceName',
                        ],
                    ],
                ],
            ],
            'ReadChangeStream' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:readChangeStream',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'ReadModifyWriteRow' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:readModifyWriteRow',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{authorized_view_name=projects/*/instances/*/tables/*/authorizedViews/*}:readModifyWriteRow',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'authorized_view_name' => [
                        'getters' => [
                            'getAuthorizedViewName',
                        ],
                    ],
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'ReadRows' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:readRows',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{authorized_view_name=projects/*/instances/*/tables/*/authorizedViews/*}:readRows',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'authorized_view_name' => [
                        'getters' => [
                            'getAuthorizedViewName',
                        ],
                    ],
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'SampleRowKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:sampleRowKeys',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{authorized_view_name=projects/*/instances/*/tables/*/authorizedViews/*}:sampleRowKeys',
                    ],
                ],
                'placeholders' => [
                    'authorized_view_name' => [
                        'getters' => [
                            'getAuthorizedViewName',
                        ],
                    ],
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
