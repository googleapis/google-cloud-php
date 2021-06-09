<?php

return [
    'interfaces' => [
        'google.cloud.workflows.v1beta.Workflows' => [
            'CreateWorkflow' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/workflows',
                'body' => 'workflow',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteWorkflow' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/workflows/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetWorkflow' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/workflows/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListWorkflows' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/workflows',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateWorkflow' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{workflow.name=projects/*/locations/*/workflows/*}',
                'body' => 'workflow',
                'placeholders' => [
                    'workflow.name' => [
                        'getters' => [
                            'getWorkflow',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*}/operations',
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
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/operations/*}:cancel',
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
