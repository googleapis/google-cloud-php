<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.DiskTypes' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/diskTypes',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/diskTypes/{disk_type}',
                'placeholders' => [
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                    'disk_type' => [
                        'getters' => [
                            'getDiskType',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/diskTypes',
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
        ],
    ],
];
