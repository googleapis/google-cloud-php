<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.TargetHttpsProxies' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/targetHttpsProxies',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpsProxies/{target_https_proxy}',
                'placeholders' => [
                    'target_https_proxy' => [
                        'getters' => [
                            'getTargetHttpsProxy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpsProxies/{target_https_proxy}',
                'placeholders' => [
                    'target_https_proxy' => [
                        'getters' => [
                            'getTargetHttpsProxy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpsProxies',
                'body' => 'target_https_proxy_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpsProxies',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetQuicOverride' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpsProxies/{target_https_proxy}/setQuicOverride',
                'body' => 'target_https_proxies_set_quic_override_request_resource',
                'placeholders' => [
                    'target_https_proxy' => [
                        'getters' => [
                            'getTargetHttpsProxy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetSslCertificates' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/targetHttpsProxies/{target_https_proxy}/setSslCertificates',
                'body' => 'target_https_proxies_set_ssl_certificates_request_resource',
                'placeholders' => [
                    'target_https_proxy' => [
                        'getters' => [
                            'getTargetHttpsProxy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetSslPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpsProxies/{target_https_proxy}/setSslPolicy',
                'body' => 'ssl_policy_reference_resource',
                'placeholders' => [
                    'target_https_proxy' => [
                        'getters' => [
                            'getTargetHttpsProxy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetUrlMap' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/targetHttpsProxies/{target_https_proxy}/setUrlMap',
                'body' => 'url_map_reference_resource',
                'placeholders' => [
                    'target_https_proxy' => [
                        'getters' => [
                            'getTargetHttpsProxy',
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
