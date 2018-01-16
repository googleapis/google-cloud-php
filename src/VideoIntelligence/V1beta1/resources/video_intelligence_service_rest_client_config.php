<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta1.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/videos:annotate',
                'body' => '*',
            ],
        ],
        'google.longrunning.Operations' => [
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/operations',
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
        ],
    ],
];
