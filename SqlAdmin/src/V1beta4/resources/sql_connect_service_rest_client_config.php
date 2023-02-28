<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1beta4.SqlConnectService' => [
            'GenerateEphemeralCert' => [
                'method' => 'post',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}:generateEphemeralCert',
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
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/connectSettings',
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
