<?php

return [
    'interfaces' => [
        'google.apps.meet.v2beta.SpacesService' => [
            'CreateSpace' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Apps\Meet\V2beta\Space',
            ],
            'EndActiveConference' => [
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
            'GetSpace' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Apps\Meet\V2beta\Space',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSpace' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Apps\Meet\V2beta\Space',
                'headerParams' => [
                    [
                        'keyName' => 'space.name',
                        'fieldAccessors' => [
                            'getSpace',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'conferenceRecord' => 'conferenceRecords/{conference_record}',
                'space' => 'spaces/{space}',
            ],
        ],
    ],
];
