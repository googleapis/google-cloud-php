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
        'google.cloud.dialogflow.v2.Participants' => [
            'AnalyzeContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{participant=projects/*/conversations/*/participants/*}:analyzeContent',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{participant=projects/*/locations/*/conversations/*/participants/*}:analyzeContent',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'participant' => [
                        'getters' => [
                            'getParticipant',
                        ],
                    ],
                ],
            ],
            'CreateParticipant' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/conversations/*}/participants',
                'body' => 'participant',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/conversations/*}/participants',
                        'body' => 'participant',
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
            'GetParticipant' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/conversations/*/participants/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/conversations/*/participants/*}',
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
            'ListParticipants' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/conversations/*}/participants',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/conversations/*}/participants',
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
            'SuggestArticles' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/conversations/*/participants/*}/suggestions:suggestArticles',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/conversations/*/participants/*}/suggestions:suggestArticles',
                        'body' => '*',
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
            'SuggestFaqAnswers' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/conversations/*/participants/*}/suggestions:suggestFaqAnswers',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/conversations/*/participants/*}/suggestions:suggestFaqAnswers',
                        'body' => '*',
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
            'SuggestKnowledgeAssist' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/conversations/*/participants/*}/suggestions:suggestKnowledgeAssist',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/conversations/*/participants/*}/suggestions:suggestKnowledgeAssist',
                        'body' => '*',
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
            'SuggestSmartReplies' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/conversations/*/participants/*}/suggestions:suggestSmartReplies',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/conversations/*/participants/*}/suggestions:suggestSmartReplies',
                        'body' => '*',
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
            'UpdateParticipant' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{participant.name=projects/*/conversations/*/participants/*}',
                'body' => 'participant',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{participant.name=projects/*/locations/*/conversations/*/participants/*}',
                        'body' => 'participant',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                ],
                'placeholders' => [
                    'participant.name' => [
                        'getters' => [
                            'getParticipant',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
