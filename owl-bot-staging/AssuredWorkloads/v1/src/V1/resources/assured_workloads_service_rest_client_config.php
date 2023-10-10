<?php

return [
    'interfaces' => [
        'google.cloud.assuredworkloads.v1.AssuredWorkloadsService' => [
            'CreateWorkload' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/workloads',
                'body' => 'workload',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteWorkload' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/workloads/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetWorkload' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/workloads/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListWorkloads' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/workloads',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RestrictAllowedResources' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/workloads/*}:restrictAllowedResources',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateWorkload' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{workload.name=organizations/*/locations/*/workloads/*}',
                'body' => 'workload',
                'placeholders' => [
                    'workload.name' => [
                        'getters' => [
                            'getWorkload',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/locations/*}/operations',
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
