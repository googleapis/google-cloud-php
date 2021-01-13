<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.TargetHttpProxies' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/targetHttpProxies',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpProxies/{target_http_proxy}',
                'placeholders' => [
                    'target_http_proxy' => [
                        'getters' => [
                            'getTargetHttpProxy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpProxies/{target_http_proxy}',
                'placeholders' => [
                    'target_http_proxy' => [
                        'getters' => [
                            'getTargetHttpProxy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpProxies',
                'body' => 'target_http_proxy_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpProxies',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetHttpProxies/{target_http_proxy}',
                'body' => 'target_http_proxy_resource',
                'placeholders' => [
                    'target_http_proxy' => [
                        'getters' => [
                            'getTargetHttpProxy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/targetHttpProxies/{target_http_proxy}/setUrlMap',
                'body' => 'url_map_reference_resource',
                'placeholders' => [
                    'target_http_proxy' => [
                        'getters' => [
                            'getTargetHttpProxy',
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
