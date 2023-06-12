<?php

return [
    'interfaces' => [
        'google.cloud.workflows.executions.v1.Executions' => [
            'CancelExecution' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/workflows/*/executions/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateExecution' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/workflows/*}/executions',
                'body' => 'execution',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetExecution' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/workflows/*/executions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListExecutions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/workflows/*}/executions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
