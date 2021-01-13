<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Interconnects' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects/{interconnect}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'interconnect' => [
                        'getters' => [
                            'getInterconnect',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects/{interconnect}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'interconnect' => [
                        'getters' => [
                            'getInterconnect',
                        ],
                    ],
                ],
            ],
            'GetDiagnostics' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnects/{interconnect}/getDiagnostics',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'interconnect' => [
                        'getters' => [
                            'getInterconnect',
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
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'interconnect' => [
                        'getters' => [
                            'getInterconnect',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
