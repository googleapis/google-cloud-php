<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.RegionHealthCheckServices' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/healthCheckServices/{health_check_service}',
                'placeholders' => [
                    'health_check_service' => [
                        'getters' => [
                            'getHealthCheckService',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/healthCheckServices/{health_check_service}',
                'placeholders' => [
                    'health_check_service' => [
                        'getters' => [
                            'getHealthCheckService',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/healthCheckServices',
                'body' => 'health_check_service_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/healthCheckServices',
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
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/healthCheckServices/{health_check_service}',
                'body' => 'health_check_service_resource',
                'placeholders' => [
                    'health_check_service' => [
                        'getters' => [
                            'getHealthCheckService',
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
        'google.cloud.compute.v1.RegionOperations' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
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
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/operations',
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
            'Wait' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/operations/{operation}/wait',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
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
