<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Zones' => [
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}',
                'placeholders' => [
                    'zone' => [
                        'getters' => [
                            'getZone',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones',
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
