<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.MachineTypes' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/machineTypes',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/machineTypes/{machine_type}',
                'placeholders' => [
                    'machine_type' => [
                        'getters' => [
                            'getMachineType',
                        ],
                    ],
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/machineTypes',
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
