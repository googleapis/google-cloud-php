<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1beta4.SqlSslCertsService' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/sslCerts/{sha1_fingerprint}',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'sha1_fingerprint' => [
                        'getters' => [
                            'getSha1Fingerprint',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/sslCerts/{sha1_fingerprint}',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'sha1_fingerprint' => [
                        'getters' => [
                            'getSha1Fingerprint',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/sslCerts',
                'body' => 'body',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/sslCerts',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
