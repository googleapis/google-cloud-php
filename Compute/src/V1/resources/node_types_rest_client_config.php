<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.NodeTypes' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/nodeTypes',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/nodeTypes/{node_type}',
                'placeholders' => [
                    'node_type' => [
                        'getters' => [
                            'getNodeType',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/nodeTypes',
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
