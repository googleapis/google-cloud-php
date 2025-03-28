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
                'generator' => 'projects/{project}/locations/{location}/generators/{generator}',
                'knowledgeBase' => 'projects/{project}/knowledgeBases/{knowledge_base}',
                'location' => 'projects/{project}/locations/{location}',
                'phraseSet' => 'projects/{project}/locations/{location}/phraseSets/{phrase_set}',
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
