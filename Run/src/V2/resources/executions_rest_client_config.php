<?php

return [
    'interfaces' => [
        'google.cloud.run.v2.Executions' => [
            'CancelExecution' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/jobs/*/executions/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExecution' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/jobs/*/executions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExecution' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/jobs/*/executions/*}',
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
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/jobs/*}/executions',
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
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'WaitOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:wait',
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
    ],
    'numericEnums' => true,
];
