<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.TargetSslProxies' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies',
                'body' => 'target_ssl_proxy_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setBackendService',
                'body' => 'target_ssl_proxies_set_backend_service_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'SetCertificateMap' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setCertificateMap',
                'body' => 'target_ssl_proxies_set_certificate_map_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'SetProxyHeader' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setProxyHeader',
                'body' => 'target_ssl_proxies_set_proxy_header_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'SetSslCertificates' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setSslCertificates',
                'body' => 'target_ssl_proxies_set_ssl_certificates_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'SetSslPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setSslPolicy',
                'body' => 'ssl_policy_reference_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.compute.v1.GlobalOperations' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/operations',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
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
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
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
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Wait' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}/wait',
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
                ],
            ],
        ],
    ],
];
