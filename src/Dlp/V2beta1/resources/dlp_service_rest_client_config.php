<?php

return [
    'interfaces' => [
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=inspect/operations}',
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
                'uriTemplate' => '/v1/{name=inspect/operations/*}',
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
                'uriTemplate' => '/v1/{name=inspect/operations/*}',
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
                'uriTemplate' => '/v1/{name=inspect/operations/*}:cancel',
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
        'google.privacy.dlp.v2beta1.DlpService' => [
            'InspectContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta1/content:inspect',
                'body' => '*',
            ],
            'RedactContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta1/content:redact',
                'body' => '*',
            ],
            'DeidentifyContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta1/content:deidentify',
                'body' => '*',
            ],
            'AnalyzeDataSourceRisk' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta1/dataSource:analyze',
                'body' => '*',
            ],
            'CreateInspectOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta1/inspect/operations',
                'body' => '*',
            ],
            'ListInspectFindings' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta1/{name=inspect/results/*}/findings',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListInfoTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta1/rootCategories/{category=*}/infoTypes',
                'placeholders' => [
                    'category' => [
                        'getters' => [
                            'getCategory',
                        ],
                    ],
                ],
            ],
            'ListRootCategories' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta1/rootCategories',
            ],
        ],
    ],
];
