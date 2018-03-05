<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1.Speech' => [
            'Recognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1/speech:recognize',
                'body' => '*',
            ],
            'LongRunningRecognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1/speech:longrunningrecognize',
                'body' => '*',
            ],
        ],
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/operations',
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/operations/{name=*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/operations/{name=*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/operations/{name=*}:cancel',
                'body' => '*',
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
