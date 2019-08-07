<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Sessions' => [
            'DetectIntent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{session=projects/*/agent/sessions/*}:detectIntent',
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
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/operations/*}',
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
];
