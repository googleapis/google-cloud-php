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
        'google.cloud.discoveryengine.v1beta.ConversationalSearchService' => [
            'AnswerQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{serving_config=projects/*/locations/*/dataStores/*/servingConfigs/*}:answer',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{serving_config=projects/*/locations/*/collections/*/dataStores/*/servingConfigs/*}:answer',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{serving_config=projects/*/locations/*/collections/*/engines/*/servingConfigs/*}:answer',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'serving_config' => [
                        'getters' => [
                            'getServingConfig',
                        ],
                    ],
                ],
            ],
            'ConverseConversation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/conversations/*}:converse',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/conversations/*}:converse',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*/conversations/*}:converse',
                        'body' => '*',
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
            'CreateConversation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/dataStores/*}/conversations',
                'body' => 'conversation',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/dataStores/*}/conversations',
                        'body' => 'conversation',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/engines/*}/conversations',
                        'body' => 'conversation',
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
            'CreateSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/dataStores/*}/sessions',
                'body' => 'session',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/dataStores/*}/sessions',
                        'body' => 'session',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/engines/*}/sessions',
                        'body' => 'session',
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
            'DeleteConversation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/conversations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/conversations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*/conversations/*}',
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
            'DeleteSession' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/sessions/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/sessions/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*/sessions/*}',
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
            'GetAnswer' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/sessions/*/answers/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/sessions/*/answers/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*/sessions/*/answers/*}',
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
            'GetConversation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/conversations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/conversations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*/conversations/*}',
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
            'GetSession' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/sessions/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/sessions/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*/sessions/*}',
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
            'ListConversations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/dataStores/*}/conversations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/dataStores/*}/conversations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/engines/*}/conversations',
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
            'ListSessions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/dataStores/*}/sessions',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/dataStores/*}/sessions',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/engines/*}/sessions',
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
            'UpdateConversation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{conversation.name=projects/*/locations/*/dataStores/*/conversations/*}',
                'body' => 'conversation',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1beta/{conversation.name=projects/*/locations/*/collections/*/dataStores/*/conversations/*}',
                        'body' => 'conversation',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1beta/{conversation.name=projects/*/locations/*/collections/*/engines/*/conversations/*}',
                        'body' => 'conversation',
                    ],
                ],
                'placeholders' => [
                    'conversation.name' => [
                        'getters' => [
                            'getConversation',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSession' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{session.name=projects/*/locations/*/dataStores/*/sessions/*}',
                'body' => 'session',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1beta/{session.name=projects/*/locations/*/collections/*/dataStores/*/sessions/*}',
                        'body' => 'session',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1beta/{session.name=projects/*/locations/*/collections/*/engines/*/sessions/*}',
                        'body' => 'session',
                    ],
                ],
                'placeholders' => [
                    'session.name' => [
                        'getters' => [
                            'getSession',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/branches/*/operations/*}:cancel',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/branches/*/operations/*}:cancel',
                        'body' => '*',
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
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataConnector/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/schemas/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/operations/*}',
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
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataConnector}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/branches/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/schemas/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/branches/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*}/operations',
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
