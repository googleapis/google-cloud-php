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
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Conversation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateConversation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Conversation',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GenerateStatelessSuggestion' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\GenerateStatelessSuggestionResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GenerateStatelessSummary' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\GenerateStatelessSummaryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'stateless_conversation.parent',
                        'fieldAccessors' => [
                            'getStatelessConversation',
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GenerateSuggestions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\GenerateSuggestionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'conversation',
                        'fieldAccessors' => [
                            'getConversation',
                        ],
                    ],
                ],
            ],
            'GetConversation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Conversation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'IngestContextReferences' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\IngestContextReferencesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'conversation',
                        'fieldAccessors' => [
                            'getConversation',
                        ],
                    ],
                ],
            ],
            'ListConversations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getConversations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ListConversationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMessages' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMessages',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ListMessagesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchKnowledge' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\SearchKnowledgeResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                    [
                        'keyName' => 'conversation',
                        'fieldAccessors' => [
                            'getConversation',
                        ],
                    ],
                ],
            ],
            'SuggestConversationSummary' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\SuggestConversationSummaryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'conversation',
                        'fieldAccessors' => [
                            'getConversation',
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
                'conversation' => 'projects/{project}/conversations/{conversation}',
                'conversationModel' => 'projects/{project}/locations/{location}/conversationModels/{conversation_model}',
                'conversationProfile' => 'projects/{project}/conversationProfiles/{conversation_profile}',
                'dataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'document' => 'projects/{project}/knowledgeBases/{knowledge_base}/documents/{document}',
                'generator' => 'projects/{project}/locations/{location}/generators/{generator}',
                'knowledgeBase' => 'projects/{project}/knowledgeBases/{knowledge_base}',
                'location' => 'projects/{project}/locations/{location}',
                'message' => 'projects/{project}/conversations/{conversation}/messages/{message}',
                'phraseSet' => 'projects/{project}/locations/{location}/phraseSets/{phrase_set}',
                'project' => 'projects/{project}',
                'projectAgent' => 'projects/{project}/agent',
                'projectConversation' => 'projects/{project}/conversations/{conversation}',
                'projectConversationMessage' => 'projects/{project}/conversations/{conversation}/messages/{message}',
                'projectConversationModel' => 'projects/{project}/conversationModels/{conversation_model}',
                'projectConversationProfile' => 'projects/{project}/conversationProfiles/{conversation_profile}',
                'projectKnowledgeBase' => 'projects/{project}/knowledgeBases/{knowledge_base}',
                'projectKnowledgeBaseDocument' => 'projects/{project}/knowledgeBases/{knowledge_base}/documents/{document}',
                'projectLocationAgent' => 'projects/{project}/locations/{location}/agent',
                'projectLocationCollectionDataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'projectLocationConversation' => 'projects/{project}/locations/{location}/conversations/{conversation}',
                'projectLocationConversationMessage' => 'projects/{project}/locations/{location}/conversations/{conversation}/messages/{message}',
                'projectLocationConversationModel' => 'projects/{project}/locations/{location}/conversationModels/{conversation_model}',
                'projectLocationConversationProfile' => 'projects/{project}/locations/{location}/conversationProfiles/{conversation_profile}',
                'projectLocationDataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'projectLocationKnowledgeBase' => 'projects/{project}/locations/{location}/knowledgeBases/{knowledge_base}',
                'projectLocationKnowledgeBaseDocument' => 'projects/{project}/locations/{location}/knowledgeBases/{knowledge_base}/documents/{document}',
            ],
        ],
    ],
];
