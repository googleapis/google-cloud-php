<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1p1beta1.Speech' => [
            'Recognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1p1beta1/speech:recognize',
                'body' => '*',
            ],
            'LongRunningRecognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1p1beta1/speech:longrunningrecognize',
                'body' => '*',
            ],
        ],
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1p1beta1/operations',
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1p1beta1/operations/{name=*}',
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
                'uriTemplate' => '/v1p1beta1/operations/{name=*}',
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
                'uriTemplate' => '/v1p1beta1/operations/{name=*}:cancel',
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
