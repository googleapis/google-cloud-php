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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/{name=projects/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/operations/{name=**}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/operations/{name=**}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/operations/{name=**}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/{name=projects/*/locations/*/operations/*}',
                    ],
                ],
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
