<?php
/*
 * Copyright 2024 Google LLC
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
        'google.cloud.dialogflow.cx.v3.Sessions' => [
            'DetectIntent' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{session=projects/*/locations/*/agents/*/sessions/*}:detectIntent',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{session=projects/*/locations/*/agents/*/environments/*/sessions/*}:detectIntent',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'FulfillIntent' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{match_intent_request.session=projects/*/locations/*/agents/*/sessions/*}:fulfillIntent',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{match_intent_request.session=projects/*/locations/*/agents/*/environments/*/sessions/*}:fulfillIntent',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'match_intent_request.session' => [
                        'getters' => [
                            'getMatchIntentRequest',
                            'getSession',
                        ],
                    ],
                ],
            ],
            'MatchIntent' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{session=projects/*/locations/*/agents/*/sessions/*}:matchIntent',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{session=projects/*/locations/*/agents/*/environments/*/sessions/*}:matchIntent',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'ServerStreamingDetectIntent' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{session=projects/*/locations/*/agents/*/sessions/*}:serverStreamingDetectIntent',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{session=projects/*/locations/*/agents/*/environments/*/sessions/*}:serverStreamingDetectIntent',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'SubmitAnswerFeedback' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{session=projects/*/locations/*/agents/*/sessions/*}:submitAnswerFeedback',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v3/{name=projects/*}/locations',
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
                'uriTemplate' => '/v3/{name=projects/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v3/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v3/{name=projects/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*}/operations',
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
