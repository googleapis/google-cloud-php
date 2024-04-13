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
        'google.monitoring.v3.GroupService' => [
            'CreateGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/groups',
                'body' => 'group',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGroupMembers' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/groups/*}/members',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/groups',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGroup' => [
                'method' => 'put',
                'uriTemplate' => '/v3/{group.name=projects/*/groups/*}',
                'body' => 'group',
                'placeholders' => [
                    'group.name' => [
                        'getters' => [
                            'getGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
