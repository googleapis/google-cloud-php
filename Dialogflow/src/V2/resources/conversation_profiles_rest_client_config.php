<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.ConversationProfiles' => [
            'ClearSuggestionFeatureConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{conversation_profile=projects/*/conversationProfiles/*}:clearSuggestionFeatureConfig',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{conversation_profile=projects/*/locations/*/conversationProfiles/*}:clearSuggestionFeatureConfig',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'conversation_profile' => [
                        'getters' => [
                            'getConversationProfile',
                        ],
                    ],
                ],
            ],
            'CreateConversationProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/conversationProfiles',
                'body' => 'conversation_profile',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/conversationProfiles',
                        'body' => 'conversation_profile',
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
            'DeleteConversationProfile' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/conversationProfiles/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/conversationProfiles/*}',
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
            'GetConversationProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/conversationProfiles/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/conversationProfiles/*}',
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
            'ListConversationProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/conversationProfiles',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/conversationProfiles',
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
            'SetSuggestionFeatureConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{conversation_profile=projects/*/conversationProfiles/*}:setSuggestionFeatureConfig',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{conversation_profile=projects/*/locations/*/conversationProfiles/*}:setSuggestionFeatureConfig',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'conversation_profile' => [
                        'getters' => [
                            'getConversationProfile',
                        ],
                    ],
                ],
            ],
            'UpdateConversationProfile' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{conversation_profile.name=projects/*/conversationProfiles/*}',
                'body' => 'conversation_profile',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{conversation_profile.name=projects/*/locations/*/conversationProfiles/*}',
                        'body' => 'conversation_profile',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                ],
                'placeholders' => [
                    'conversation_profile.name' => [
                        'getters' => [
                            'getConversationProfile',
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
];
