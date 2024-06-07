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
        'google.apps.meet.v2beta.ConferenceRecordsService' => [
            'GetConferenceRecord' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=conferenceRecords/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetParticipant' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=conferenceRecords/*/participants/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetParticipantSession' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=conferenceRecords/*/participants/*/participantSessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRecording' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=conferenceRecords/*/recordings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTranscript' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=conferenceRecords/*/transcripts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTranscriptEntry' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=conferenceRecords/*/transcripts/*/entries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListConferenceRecords' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/conferenceRecords',
            ],
            'ListParticipantSessions' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{parent=conferenceRecords/*/participants/*}/participantSessions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListParticipants' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{parent=conferenceRecords/*}/participants',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRecordings' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{parent=conferenceRecords/*}/recordings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTranscriptEntries' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{parent=conferenceRecords/*/transcripts/*}/entries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTranscripts' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{parent=conferenceRecords/*}/transcripts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
