<?php

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
