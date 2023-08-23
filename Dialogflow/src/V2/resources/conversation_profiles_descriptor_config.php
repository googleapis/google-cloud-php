<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.ConversationProfiles' => [
            'ClearSuggestionFeatureConfig' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dialogflow\V2\ConversationProfile',
                    'metadataReturnType' => '\Google\Cloud\Dialogflow\V2\ClearSuggestionFeatureConfigOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'conversation_profile',
                        'fieldAccessors' => [
                            'getConversationProfile',
                        ],
                    ],
                ],
            ],
            'SetSuggestionFeatureConfig' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dialogflow\V2\ConversationProfile',
                    'metadataReturnType' => '\Google\Cloud\Dialogflow\V2\SetSuggestionFeatureConfigOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'conversation_profile',
                        'fieldAccessors' => [
                            'getConversationProfile',
                        ],
                    ],
                ],
            ],
            'CreateConversationProfile' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ConversationProfile',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteConversationProfile' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConversationProfile' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ConversationProfile',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListConversationProfiles' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getConversationProfiles',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ListConversationProfilesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateConversationProfile' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ConversationProfile',
                'headerParams' => [
                    [
                        'keyName' => 'conversation_profile.name',
                        'fieldAccessors' => [
                            'getConversationProfile',
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
                'agent' => 'projects/{project}/agent',
                'cXSecuritySettings' => 'projects/{project}/locations/{location}/securitySettings/{security_settings}',
                'conversationModel' => 'projects/{project}/locations/{location}/conversationModels/{conversation_model}',
                'conversationProfile' => 'projects/{project}/conversationProfiles/{conversation_profile}',
                'document' => 'projects/{project}/knowledgeBases/{knowledge_base}/documents/{document}',
                'knowledgeBase' => 'projects/{project}/knowledgeBases/{knowledge_base}',
                'location' => 'projects/{project}/locations/{location}',
                'project' => 'projects/{project}',
                'projectAgent' => 'projects/{project}/agent',
                'projectConversationModel' => 'projects/{project}/conversationModels/{conversation_model}',
                'projectConversationProfile' => 'projects/{project}/conversationProfiles/{conversation_profile}',
                'projectKnowledgeBase' => 'projects/{project}/knowledgeBases/{knowledge_base}',
                'projectKnowledgeBaseDocument' => 'projects/{project}/knowledgeBases/{knowledge_base}/documents/{document}',
                'projectLocationAgent' => 'projects/{project}/locations/{location}/agent',
                'projectLocationConversationModel' => 'projects/{project}/locations/{location}/conversationModels/{conversation_model}',
                'projectLocationConversationProfile' => 'projects/{project}/locations/{location}/conversationProfiles/{conversation_profile}',
                'projectLocationKnowledgeBase' => 'projects/{project}/locations/{location}/knowledgeBases/{knowledge_base}',
                'projectLocationKnowledgeBaseDocument' => 'projects/{project}/locations/{location}/knowledgeBases/{knowledge_base}/documents/{document}',
            ],
        ],
    ],
];
