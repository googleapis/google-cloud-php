<?php

return [
    'interfaces' => [
        'google.apps.meet.v2beta.SpacesService' => [
            'CreateSpace' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta/spaces',
                'body' => 'space',
            ],
            'EndActiveConference' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta/{name=spaces/*}:endActiveConference',
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
                'uriTemplate' => '/v2beta/{name=spaces/*}',
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
                'uriTemplate' => '/v2beta/{space.name=spaces/*}',
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
