<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.TargetGrpcProxies' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetGrpcProxies/{target_grpc_proxy}',
                'placeholders' => [
                    'target_grpc_proxy' => [
                        'getters' => [
                            'getTargetGrpcProxy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetGrpcProxies/{target_grpc_proxy}',
                'placeholders' => [
                    'target_grpc_proxy' => [
                        'getters' => [
                            'getTargetGrpcProxy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetGrpcProxies',
                'body' => 'target_grpc_proxy_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetGrpcProxies',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetGrpcProxies/{target_grpc_proxy}',
                'body' => 'target_grpc_proxy_resource',
                'placeholders' => [
                    'target_grpc_proxy' => [
                        'getters' => [
                            'getTargetGrpcProxy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
