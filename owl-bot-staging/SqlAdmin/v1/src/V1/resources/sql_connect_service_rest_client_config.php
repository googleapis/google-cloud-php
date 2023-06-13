<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1.SqlConnectService' => [
            'GenerateEphemeralCert' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}:generateEphemeralCert',
                'body' => '*',
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
            'GetConnectSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/connectSettings',
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
