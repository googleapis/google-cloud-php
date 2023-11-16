<?php

return [
    'interfaces' => [
        'google.cloud.webrisk.v1.WebRiskService' => [
            'ComputeThreatListDiff' => [
                'method' => 'get',
                'uriTemplate' => '/v1/threatLists:computeDiff',
            ],
            'CreateSubmission' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/submissions',
                'body' => 'submission',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchHashes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/hashes:search',
            ],
            'SearchUris' => [
                'method' => 'get',
                'uriTemplate' => '/v1/uris:search',
            ],
            'SubmitUri' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/uris:submit',
                'body' => '*',
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
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*}/operations',
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
    'numericEnums' => true,
];
