<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.cx.v3.Sessions' => [
            'DetectIntent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\Cx\V3\DetectIntentResponse',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'FulfillIntent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\Cx\V3\FulfillIntentResponse',
                'headerParams' => [
                    [
                        'keyName' => 'match_intent_request.session',
                        'fieldAccessors' => [
                            'getMatchIntentRequest',
                            'getSession',
                        ],
                    ],
                ],
            ],
            'MatchIntent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\Cx\V3\MatchIntentResponse',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'ServerStreamingDetectIntent' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\Cx\V3\DetectIntentResponse',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'StreamingDetectIntent' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\Cx\V3\StreamingDetectIntentResponse',
            ],
            'SubmitAnswerFeedback' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\Cx\V3\AnswerFeedback',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
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
                'agent' => 'projects/{project}/locations/{location}/agents/{agent}',
                'dataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'entityType' => 'projects/{project}/locations/{location}/agents/{agent}/entityTypes/{entity_type}',
                'intent' => 'projects/{project}/locations/{location}/agents/{agent}/intents/{intent}',
                'page' => 'projects/{project}/locations/{location}/agents/{agent}/flows/{flow}/pages/{page}',
                'projectLocationAgentEnvironmentSession' => 'projects/{project}/locations/{location}/agents/{agent}/environments/{environment}/sessions/{session}',
                'projectLocationAgentEnvironmentSessionEntityType' => 'projects/{project}/locations/{location}/agents/{agent}/environments/{environment}/sessions/{session}/entityTypes/{entity_type}',
                'projectLocationAgentSession' => 'projects/{project}/locations/{location}/agents/{agent}/sessions/{session}',
                'projectLocationAgentSessionEntityType' => 'projects/{project}/locations/{location}/agents/{agent}/sessions/{session}/entityTypes/{entity_type}',
                'projectLocationCollectionDataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'projectLocationDataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'session' => 'projects/{project}/locations/{location}/agents/{agent}/sessions/{session}',
                'sessionEntityType' => 'projects/{project}/locations/{location}/agents/{agent}/sessions/{session}/entityTypes/{entity_type}',
                'version' => 'projects/{project}/locations/{location}/agents/{agent}/flows/{flow}/versions/{version}',
            ],
        ],
    ],
];
