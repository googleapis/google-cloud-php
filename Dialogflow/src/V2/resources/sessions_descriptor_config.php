<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Sessions' => [
            'DetectIntent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\DetectIntentResponse',
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
                'responseType' => 'Google\Cloud\Dialogflow\V2\StreamingDetectIntentResponse',
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
                'projectEnvironmentUserSession' => 'projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}',
                'projectLocationEnvironmentUserSession' => 'projects/{project}/locations/{location}/agent/environments/{environment}/users/{user}/sessions/{session}',
                'projectLocationSession' => 'projects/{project}/locations/{location}/agent/sessions/{session}',
                'projectSession' => 'projects/{project}/agent/sessions/{session}',
                'session' => 'projects/{project}/agent/sessions/{session}',
            ],
        ],
    ],
];
