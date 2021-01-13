<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.TargetPools' => [
            'AddHealthCheck' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools/{target_pool}/addHealthCheck',
                'body' => 'target_pools_add_health_check_request_resource',
                'placeholders' => [
                    'target_pool' => [
                        'getters' => [
                            'getTargetPool',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'AddInstance' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools/{target_pool}/addInstance',
                'body' => 'target_pools_add_instance_request_resource',
                'placeholders' => [
                    'target_pool' => [
                        'getters' => [
                            'getTargetPool',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/targetPools',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools/{target_pool}',
                'placeholders' => [
                    'target_pool' => [
                        'getters' => [
                            'getTargetPool',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools/{target_pool}',
                'placeholders' => [
                    'target_pool' => [
                        'getters' => [
                            'getTargetPool',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'GetHealth' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools/{target_pool}/getHealth',
                'body' => 'instance_reference_resource',
                'placeholders' => [
                    'target_pool' => [
                        'getters' => [
                            'getTargetPool',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools',
                'body' => 'target_pool_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'RemoveHealthCheck' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools/{target_pool}/removeHealthCheck',
                'body' => 'target_pools_remove_health_check_request_resource',
                'placeholders' => [
                    'target_pool' => [
                        'getters' => [
                            'getTargetPool',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'RemoveInstance' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools/{target_pool}/removeInstance',
                'body' => 'target_pools_remove_instance_request_resource',
                'placeholders' => [
                    'target_pool' => [
                        'getters' => [
                            'getTargetPool',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'SetBackup' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/targetPools/{target_pool}/setBackup',
                'body' => 'target_reference_resource',
                'placeholders' => [
                    'target_pool' => [
                        'getters' => [
                            'getTargetPool',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
