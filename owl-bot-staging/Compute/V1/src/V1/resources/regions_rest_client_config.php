<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Regions' => [
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions',
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
