<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1.SqlSslCertsService' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/sslCerts/{sha1_fingerprint}',
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
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/sslCerts/{sha1_fingerprint}',
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
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/sslCerts',
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
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/sslCerts',
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
    'numericEnums' => true,
];
