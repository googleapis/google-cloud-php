<?php

return [
    'interfaces' => [
        'google.cloud.asset.v1.AssetService' => [
            'ExportAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=*/*}:exportAssets',
                'body' => '*',
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
                'uriTemplate' => '/v1/{parent=*/*}:batchGetAssetsHistory',
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
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1alpha1/{name=*/*/operations/*/**}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=*/*/operations/*/**}',
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
