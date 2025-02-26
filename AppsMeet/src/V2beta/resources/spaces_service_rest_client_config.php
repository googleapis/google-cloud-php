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
        'google.apps.meet.v2beta.SpacesService' => [
            'ConnectActiveConference' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta/{name=spaces/*}:connectActiveConference',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateMember' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta/{parent=spaces/*}/members',
                'body' => 'member',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSpace' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta/spaces',
                'body' => 'space',
            ],
            'DeleteMember' => [
                'method' => 'delete',
                'uriTemplate' => '/v2beta/{name=spaces/*/members/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EndActiveConference' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta/{name=spaces/*}:endActiveConference',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMember' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=spaces/*/members/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpace' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=spaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListMembers' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{parent=spaces/*}/members',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSpace' => [
                'method' => 'patch',
                'uriTemplate' => '/v2beta/{space.name=spaces/*}',
                'body' => 'space',
                'placeholders' => [
                    'space.name' => [
                        'getters' => [
                            'getSpace',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
