<?php

return [
    'interfaces' => [
        'google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService' => [
            'CreateWorkload' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=organizations/*/locations/*}/workloads',
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
                'uriTemplate' => '/v1beta1/{name=organizations/*/locations/*/workloads/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestrictAllowedResources' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=organizations/*/locations/*/workloads/*}:restrictAllowedResources',
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
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=organizations/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1beta1/{name=organizations/*/locations/*}/operations',
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
