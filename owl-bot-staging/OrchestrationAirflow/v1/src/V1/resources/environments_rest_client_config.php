<?php

return [
    'interfaces' => [
        'google.cloud.orchestration.airflow.service.v1.Environments' => [
            'CreateEnvironment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/environments',
                'body' => 'environment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteEnvironment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEnvironment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEnvironments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/environments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LoadSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:loadSnapshot',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'SaveSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=projects/*/locations/*/environments/*}:saveSnapshot',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'UpdateEnvironment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/environments/*}',
                'body' => 'environment',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
