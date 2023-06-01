<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1.SqlTiersService' => [
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project}/tiers',
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
    'numericEnums' => true,
];
