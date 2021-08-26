<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1beta4.SqlOperationsService' => [
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/operations/{operation}',
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
                'uriTemplate' => '/sql/v1beta4/projects/{project}/operations',
                'placeholders' => [
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
