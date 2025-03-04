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
        'google.cloud.dialogflow.v2.SessionEntityTypes' => [
            'CreateSessionEntityType' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent/sessions/*}/entityTypes',
                'body' => 'session_entity_type',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/environments/*/users/*/sessions/*}/entityTypes',
                        'body' => 'session_entity_type',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/sessions/*}/entityTypes',
                        'body' => 'session_entity_type',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/environments/*/users/*/sessions/*}/entityTypes',
                        'body' => 'session_entity_type',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteSessionEntityType' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/agent/sessions/*/entityTypes/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/agent/environments/*/users/*/sessions/*/entityTypes/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/agent/sessions/*/entityTypes/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/agent/environments/*/users/*/sessions/*/entityTypes/*}',
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
            'GetSessionEntityType' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/agent/sessions/*/entityTypes/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/agent/environments/*/users/*/sessions/*/entityTypes/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/agent/sessions/*/entityTypes/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/agent/environments/*/users/*/sessions/*/entityTypes/*}',
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
            'ListSessionEntityTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/agent/sessions/*}/entityTypes',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/environments/*/users/*/sessions/*}/entityTypes',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/sessions/*}/entityTypes',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/environments/*/users/*/sessions/*}/entityTypes',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSessionEntityType' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{session_entity_type.name=projects/*/agent/sessions/*/entityTypes/*}',
                'body' => 'session_entity_type',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{session_entity_type.name=projects/*/agent/environments/*/users/*/sessions/*/entityTypes/*}',
                        'body' => 'session_entity_type',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{session_entity_type.name=projects/*/locations/*/agent/sessions/*/entityTypes/*}',
                        'body' => 'session_entity_type',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{session_entity_type.name=projects/*/locations/*/agent/environments/*/users/*/sessions/*/entityTypes/*}',
                        'body' => 'session_entity_type',
                    ],
                ],
                'placeholders' => [
                    'session_entity_type.name' => [
                        'getters' => [
                            'getSessionEntityType',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:cancel',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
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
