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
    ],
];
