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
        'google.cloud.dialogflow.v2.Intents' => [
            'BatchDeleteIntents' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Protobuf\Struct',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateIntents' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dialogflow\V2\BatchUpdateIntentsResponse',
                    'metadataReturnType' => '\Google\Protobuf\Struct',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateIntent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Intent',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteIntent' => [
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
            'GetIntent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Intent',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListIntents' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getIntents',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\ListIntentsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateIntent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dialogflow\V2\Intent',
                'headerParams' => [
                    [
                        'keyName' => 'intent.name',
                        'fieldAccessors' => [
                            'getIntent',
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
                'context' => 'projects/{project}/agent/sessions/{session}/contexts/{context}',
                'intent' => 'projects/{project}/agent/intents/{intent}',
                'projectAgent' => 'projects/{project}/agent',
                'projectEnvironmentUserSession' => 'projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}',
                'projectEnvironmentUserSessionContext' => 'projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}/contexts/{context}',
                'projectIntent' => 'projects/{project}/agent/intents/{intent}',
                'projectLocationAgent' => 'projects/{project}/locations/{location}/agent',
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
