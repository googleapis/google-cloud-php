<?php

return [
    'interfaces' => [
        'google.cloud.workflows.v1beta.Workflows' => [
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
    ],
];
