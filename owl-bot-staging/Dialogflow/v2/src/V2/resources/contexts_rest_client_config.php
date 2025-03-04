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
        'google.cloud.dialogflow.v2.Contexts' => [
            'CreateContext' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent/sessions/*}/contexts',
                'body' => 'context',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/environments/*/users/*/sessions/*}/contexts',
                        'body' => 'context',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/sessions/*}/contexts',
                        'body' => 'context',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/environments/*/users/*/sessions/*}/contexts',
                        'body' => 'context',
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
            'DeleteAllContexts' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{parent=projects/*/agent/sessions/*}/contexts',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/environments/*/users/*/sessions/*}/contexts',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/sessions/*}/contexts',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/environments/*/users/*/sessions/*}/contexts',
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
            'DeleteContext' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/agent/sessions/*/contexts/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/agent/environments/*/users/*/sessions/*/contexts/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/agent/sessions/*/contexts/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/agent/environments/*/users/*/sessions/*/contexts/*}',
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
            'GetContext' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/agent/sessions/*/contexts/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/agent/environments/*/users/*/sessions/*/contexts/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/agent/sessions/*/contexts/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/agent/environments/*/users/*/sessions/*/contexts/*}',
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
            'ListContexts' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/agent/sessions/*}/contexts',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/environments/*/users/*/sessions/*}/contexts',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/sessions/*}/contexts',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/agent/environments/*/users/*/sessions/*}/contexts',
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
            'UpdateContext' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{context.name=projects/*/agent/sessions/*/contexts/*}',
                'body' => 'context',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{context.name=projects/*/agent/environments/*/users/*/sessions/*/contexts/*}',
                        'body' => 'context',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{context.name=projects/*/locations/*/agent/sessions/*/contexts/*}',
                        'body' => 'context',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{context.name=projects/*/locations/*/agent/environments/*/users/*/sessions/*/contexts/*}',
                        'body' => 'context',
                    ],
                ],
                'placeholders' => [
                    'context.name' => [
                        'getters' => [
                            'getContext',
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
