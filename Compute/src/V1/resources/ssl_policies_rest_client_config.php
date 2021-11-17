<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.SslPolicies' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/sslPolicies/{ssl_policy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'ssl_policy' => [
                        'getters' => [
                            'getSslPolicy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/sslPolicies/{ssl_policy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'ssl_policy' => [
                        'getters' => [
                            'getSslPolicy',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/sslPolicies',
                'body' => 'ssl_policy_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/sslPolicies',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ListAvailableFeatures' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/sslPolicies/listAvailableFeatures',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/sslPolicies/{ssl_policy}',
                'body' => 'ssl_policy_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'ssl_policy' => [
                        'getters' => [
                            'getSslPolicy',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
