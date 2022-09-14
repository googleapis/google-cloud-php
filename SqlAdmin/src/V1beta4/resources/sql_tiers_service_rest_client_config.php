<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1beta4.SqlTiersService' => [
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/tiers',
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
