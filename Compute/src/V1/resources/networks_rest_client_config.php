<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Networks' => [
            'AddPeering' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/addPeering',
                'body' => 'networks_add_peering_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks',
                'body' => 'network_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ListPeeringRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/listPeeringRoutes',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}',
                'body' => 'network_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                ],
            ],
            'RemovePeering' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/removePeering',
                'body' => 'networks_remove_peering_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                ],
            ],
            'SwitchToCustomMode' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/switchToCustomMode',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                ],
            ],
            'UpdatePeering' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/updatePeering',
                'body' => 'networks_update_peering_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
