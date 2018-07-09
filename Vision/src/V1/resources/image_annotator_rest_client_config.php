<?php

return [
    'interfaces' => [
        'google.cloud.vision.v1.ImageAnnotator' => [
            'BatchAnnotateImages' => [
                'method' => 'post',
                'uriTemplate' => '/v1/images:annotate',
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
                'uriTemplate' => '/v1/{name=operations/*}',
                'additionalBindings' => [
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
