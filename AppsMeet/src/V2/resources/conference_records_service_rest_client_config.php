<?php

return [
    'interfaces' => [
        'google.apps.meet.v2.ConferenceRecordsService' => [
            'GetConferenceRecord' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=conferenceRecords/*}',
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
                'uriTemplate' => '/v2/{name=conferenceRecords/*/participants/*}',
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
                'uriTemplate' => '/v2/{name=conferenceRecords/*/participants/*/participantSessions/*}',
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
                'uriTemplate' => '/v2/{name=conferenceRecords/*/recordings/*}',
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
                'uriTemplate' => '/v2/{name=conferenceRecords/*/transcripts/*}',
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
                'uriTemplate' => '/v2/{name=conferenceRecords/*/transcripts/*/entries/*}',
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
                'uriTemplate' => '/v2/conferenceRecords',
            ],
            'ListParticipantSessions' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=conferenceRecords/*/participants/*}/participantSessions',
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
                'uriTemplate' => '/v2/{parent=conferenceRecords/*}/participants',
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
                'uriTemplate' => '/v2/{parent=conferenceRecords/*}/recordings',
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
                'uriTemplate' => '/v2/{parent=conferenceRecords/*/transcripts/*}/entries',
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
                'uriTemplate' => '/v2/{parent=conferenceRecords/*}/transcripts',
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
