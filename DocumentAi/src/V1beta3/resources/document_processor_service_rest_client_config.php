<?php

return [
    'interfaces' => [
        'google.cloud.documentai.v1beta3.DocumentProcessorService' => [
            'BatchProcessDocuments' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*/processors/*}:batchProcess',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateProcessor' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta3/{parent=projects/*/locations/*}/processors',
                'body' => 'processor',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteProcessor' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*/processors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DisableProcessor' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*/processors/*}:disable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EnableProcessor' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*/processors/*}:enable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchProcessorTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta3/{parent=projects/*/locations/*}:fetchProcessorTypes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProcessors' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta3/{parent=projects/*/locations/*}/processors',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ProcessDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*/processors/*}:process',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ReviewDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta3/{human_review_config=projects/*/locations/*/processors/*/humanReviewConfig}:reviewDocument',
                'body' => '*',
                'placeholders' => [
                    'human_review_config' => [
                        'getters' => [
                            'getHumanReviewConfig',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*}/operations',
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
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1beta3/{name=projects/*/locations/*/operations/*}:cancel',
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
