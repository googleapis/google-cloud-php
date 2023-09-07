<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.AnswerRecords' => [
            'ListAnswerRecords' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAnswerRecords',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ListAnswerRecordsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAnswerRecord' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\AnswerRecord',
                'headerParams' => [
                    [
                        'keyName' => 'answer_record.name',
                        'fieldAccessors' => [
                            'getAnswerRecord',
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
                'answerRecord' => 'projects/{project}/answerRecords/{answer_record}',
                'context' => 'projects/{project}/agent/sessions/{session}/contexts/{context}',
                'intent' => 'projects/{project}/agent/intents/{intent}',
                'location' => 'projects/{project}/locations/{location}',
                'project' => 'projects/{project}',
                'projectAgent' => 'projects/{project}/agent',
                'projectAnswerRecord' => 'projects/{project}/answerRecords/{answer_record}',
                'projectEnvironmentUserSession' => 'projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}',
                'projectEnvironmentUserSessionContext' => 'projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}/contexts/{context}',
                'projectIntent' => 'projects/{project}/agent/intents/{intent}',
                'projectLocationAgent' => 'projects/{project}/locations/{location}/agent',
                'projectLocationAnswerRecord' => 'projects/{project}/locations/{location}/answerRecords/{answer_record}',
                'projectLocationEnvironmentUserSession' => 'projects/{project}/locations/{location}/agent/environments/{environment}/users/{user}/sessions/{session}',
                'projectLocationEnvironmentUserSessionContext' => 'projects/{project}/locations/{location}/agent/environments/{environment}/users/{user}/sessions/{session}/contexts/{context}',
                'projectLocationIntent' => 'projects/{project}/locations/{location}/agent/intents/{intent}',
                'projectLocationSession' => 'projects/{project}/locations/{location}/agent/sessions/{session}',
                'projectLocationSessionContext' => 'projects/{project}/locations/{location}/agent/sessions/{session}/contexts/{context}',
                'projectSession' => 'projects/{project}/agent/sessions/{session}',
                'projectSessionContext' => 'projects/{project}/agent/sessions/{session}/contexts/{context}',
                'session' => 'projects/{project}/agent/sessions/{session}',
            ],
        ],
    ],
];
