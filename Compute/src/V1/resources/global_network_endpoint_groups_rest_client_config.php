<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.GlobalNetworkEndpointGroups' => [
            'AttachNetworkEndpoints' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}/attachNetworkEndpoints',
                'body' => 'global_network_endpoint_groups_attach_endpoints_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
                        ],
                    ],
                ],
            ],
            'DetachNetworkEndpoints' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}/detachNetworkEndpoints',
                'body' => 'global_network_endpoint_groups_detach_endpoints_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups',
                'body' => 'network_endpoint_group_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ListNetworkEndpoints' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}/listNetworkEndpoints',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
