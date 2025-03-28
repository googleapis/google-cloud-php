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
        'google.ads.admanager.v1.EntitySignalsMappingService' => [
            'BatchCreateEntitySignalsMappings' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/entitySignalsMappings:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateEntitySignalsMappings' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/entitySignalsMappings:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateEntitySignalsMapping' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/entitySignalsMappings',
                'body' => 'entity_signals_mapping',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetEntitySignalsMapping' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/entitySignalsMappings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEntitySignalsMappings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/entitySignalsMappings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateEntitySignalsMapping' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{entity_signals_mapping.name=networks/*/entitySignalsMappings/*}',
                'body' => 'entity_signals_mapping',
                'placeholders' => [
                    'entity_signals_mapping.name' => [
                        'getters' => [
                            'getEntitySignalsMapping',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=networks/*/operations/reports/exports/*}',
                    ],
                ],
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
