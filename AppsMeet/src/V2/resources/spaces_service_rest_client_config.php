<?php

return [
    'interfaces' => [
        'google.apps.meet.v2.SpacesService' => [
            'CreateSpace' => [
                'method' => 'post',
                'uriTemplate' => '/v2/spaces',
                'body' => 'space',
            ],
            'EndActiveConference' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=spaces/*}:endActiveConference',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpace' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=spaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSpace' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{space.name=spaces/*}',
                'body' => 'space',
                'placeholders' => [
                    'space.name' => [
                        'getters' => [
                            'getSpace',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
