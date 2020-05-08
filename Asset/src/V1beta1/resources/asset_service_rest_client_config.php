<?php

return [
    'interfaces' => [
        'google.cloud.asset.v1beta1.AssetService' => [
            'ExportAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*}:exportAssets',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{parent=folders/*}:exportAssets',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{parent=organizations/*}:exportAssets',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchGetAssetsHistory' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}:batchGetAssetsHistory',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{parent=organizations/*}:batchGetAssetsHistory',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/operations/*/**}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{name=folders/*/operations/*/**}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{name=organizations/*/operations/*/**}',
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
