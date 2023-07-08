<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Participants' => [
            'AnalyzeContent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\AnalyzeContentResponse',
                'headerParams' => [
                    [
                        'keyName' => 'participant',
                        'fieldAccessors' => [
                            'getParticipant',
                        ],
                    ],
                ],
            ],
            'CreateParticipant' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Participant',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetParticipant' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Participant',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListParticipants' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getParticipants',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ListParticipantsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'StreamingAnalyzeContent' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\StreamingAnalyzeContentResponse',
            ],
            'SuggestArticles' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\SuggestArticlesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SuggestFaqAnswers' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\SuggestFaqAnswersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SuggestSmartReplies' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\SuggestSmartRepliesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateParticipant' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Participant',
                'headerParams' => [
                    [
                        'keyName' => 'participant.name',
                        'fieldAccessors' => [
                            'getParticipant',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLocation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Location\Location',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Location\ListLocationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'templateMap' => [
                'context' => 'projects/{project}/agent/sessions/{session}/contexts/{context}',
                'conversation' => 'projects/{project}/conversations/{conversation}',
                'message' => 'projects/{project}/conversations/{conversation}/messages/{message}',
                'participant' => 'projects/{project}/conversations/{conversation}/participants/{participant}',
                'projectConversation' => 'projects/{project}/conversations/{conversation}',
                'projectConversationMessage' => 'projects/{project}/conversations/{conversation}/messages/{message}',
                'projectConversationParticipant' => 'projects/{project}/conversations/{conversation}/participants/{participant}',
                'projectEnvironmentUserSession' => 'projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}',
                'projectEnvironmentUserSessionContext' => 'projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}/contexts/{context}',
                'projectEnvironmentUserSessionEntityType' => 'projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}/entityTypes/{entity_type}',
                'projectLocationConversation' => 'projects/{project}/locations/{location}/conversations/{conversation}',
                'projectLocationConversationMessage' => 'projects/{project}/locations/{location}/conversations/{conversation}/messages/{message}',
                'projectLocationConversationParticipant' => 'projects/{project}/locations/{location}/conversations/{conversation}/participants/{participant}',
                'projectLocationEnvironmentUserSession' => 'projects/{project}/locations/{location}/agent/environments/{environment}/users/{user}/sessions/{session}',
                'projectLocationEnvironmentUserSessionContext' => 'projects/{project}/locations/{location}/agent/environments/{environment}/users/{user}/sessions/{session}/contexts/{context}',
                'projectLocationEnvironmentUserSessionEntityType' => 'projects/{project}/locations/{location}/agent/environments/{environment}/users/{user}/sessions/{session}/entityTypes/{entity_type}',
                'projectLocationSession' => 'projects/{project}/locations/{location}/agent/sessions/{session}',
                'projectLocationSessionContext' => 'projects/{project}/locations/{location}/agent/sessions/{session}/contexts/{context}',
                'projectLocationSessionEntityType' => 'projects/{project}/locations/{location}/agent/sessions/{session}/entityTypes/{entity_type}',
                'projectSession' => 'projects/{project}/agent/sessions/{session}',
                'projectSessionContext' => 'projects/{project}/agent/sessions/{session}/contexts/{context}',
                'projectSessionEntityType' => 'projects/{project}/agent/sessions/{session}/entityTypes/{entity_type}',
                'session' => 'projects/{project}/agent/sessions/{session}',
                'sessionEntityType' => 'projects/{project}/agent/sessions/{session}/entityTypes/{entity_type}',
            ],
        ],
    ],
];
