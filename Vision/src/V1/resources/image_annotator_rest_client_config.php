<?php

return [
    'interfaces' => [
        'google.cloud.vision.v1.ImageAnnotator' => [
            'BatchAnnotateImages' => [
                'method' => 'post',
                'uriTemplate' => '/v1/images:annotate',
                'body' => '*',
            ],
            'BatchAnnotateFiles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/files:annotate',
                'body' => '*',
            ],
            'AsyncBatchAnnotateImages' => [
                'method' => 'post',
                'uriTemplate' => '/v1/images:asyncBatchAnnotate',
                'body' => '*',
            ],
            'AsyncBatchAnnotateFiles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/files:asyncBatchAnnotate',
                'body' => '*',
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=locations/*/operations/*}',
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
