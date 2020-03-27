<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Sessions' => [
            'DetectIntent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{session=projects/*/agent/sessions/*}:detectIntent',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{session=projects/*/agent/environments/*/users/*/sessions/*}:detectIntent',
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
        ],
    ],
];
