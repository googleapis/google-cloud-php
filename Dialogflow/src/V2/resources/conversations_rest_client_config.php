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
        'google.cloud.dialogflow.v2.Conversations' => [
            'CompleteConversation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/conversations/*}:complete',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/conversations/*}:complete',
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
                'uriTemplate' => '/v2/{parent=projects/*}/conversations',
                'body' => 'conversation',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/conversations',
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
            'GenerateStatelessSuggestion' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/statelessSuggestion:generate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GenerateStatelessSummary' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{stateless_conversation.parent=projects/*}/suggestions:generateStatelessSummary',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{stateless_conversation.parent=projects/*/locations/*}/suggestions:generateStatelessSummary',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'stateless_conversation.parent' => [
                        'getters' => [
                            'getStatelessConversation',
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GenerateSuggestions' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{conversation=projects/*/conversations/*}/suggestions:generate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{conversation=projects/*/locations/*/conversations/*}/suggestions:generate',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'conversation' => [
                        'getters' => [
                            'getConversation',
                        ],
                    ],
                ],
            ],
            'GetConversation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/conversations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/conversations/*}',
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
            'IngestContextReferences' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{conversation=projects/*/locations/*/conversations/*}:ingestContextReferences',
                'body' => '*',
                'placeholders' => [
                    'conversation' => [
                        'getters' => [
                            'getConversation',
                        ],
                    ],
                ],
            ],
            'ListConversations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/conversations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/conversations',
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
            'ListMessages' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/conversations/*}/messages',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/conversations/*}/messages',
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
            'SearchKnowledge' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/suggestions:searchKnowledge',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/suggestions:searchKnowledge',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{conversation=projects/*/conversations/*}/suggestions:searchKnowledge',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{conversation=projects/*/locations/*/conversations/*}/suggestions:searchKnowledge',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'conversation' => [
                        'getters' => [
                            'getConversation',
                        ],
                    ],
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SuggestConversationSummary' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{conversation=projects/*/conversations/*}/suggestions:suggestConversationSummary',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{conversation=projects/*/locations/*/conversations/*}/suggestions:suggestConversationSummary',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'conversation' => [
                        'getters' => [
                            'getConversation',
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
