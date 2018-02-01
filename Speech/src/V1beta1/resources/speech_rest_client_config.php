<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1beta1.Speech' => [
            'SyncRecognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/speech:syncrecognize',
                'body' => '*',
            ],
            'AsyncRecognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/speech:asyncrecognize',
                'body' => '*',
            ],
        ],
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/operations',
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/operations/{name=*}',
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
                'uriTemplate' => '/v1beta1/operations/{name=*}',
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
                'uriTemplate' => '/v1beta1/operations/{name=*}:cancel',
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
