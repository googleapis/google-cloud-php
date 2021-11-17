<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.TargetTcpProxies' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetTcpProxies/{target_tcp_proxy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_tcp_proxy' => [
                        'getters' => [
                            'getTargetTcpProxy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetTcpProxies/{target_tcp_proxy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_tcp_proxy' => [
                        'getters' => [
                            'getTargetTcpProxy',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetTcpProxies',
                'body' => 'target_tcp_proxy_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetTcpProxies',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetBackendService' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetTcpProxies/{target_tcp_proxy}/setBackendService',
                'body' => 'target_tcp_proxies_set_backend_service_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_tcp_proxy' => [
                        'getters' => [
                            'getTargetTcpProxy',
                        ],
                    ],
                ],
            ],
            'SetProxyHeader' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetTcpProxies/{target_tcp_proxy}/setProxyHeader',
                'body' => 'target_tcp_proxies_set_proxy_header_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_tcp_proxy' => [
                        'getters' => [
                            'getTargetTcpProxy',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
