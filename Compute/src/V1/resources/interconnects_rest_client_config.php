<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Interconnects' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects/{interconnect}',
                'placeholders' => [
                    'interconnect' => [
                        'getters' => [
                            'getInterconnect',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects/{interconnect}',
                'placeholders' => [
                    'interconnect' => [
                        'getters' => [
                            'getInterconnect',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetDiagnostics' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects/{interconnect}/getDiagnostics',
                'placeholders' => [
                    'interconnect' => [
                        'getters' => [
                            'getInterconnect',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects',
                'body' => 'interconnect_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects/{interconnect}',
                'body' => 'interconnect_resource',
                'placeholders' => [
                    'interconnect' => [
                        'getters' => [
                            'getInterconnect',
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
