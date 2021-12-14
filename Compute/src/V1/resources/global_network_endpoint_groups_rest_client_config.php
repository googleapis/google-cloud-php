<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.GlobalNetworkEndpointGroups' => [
            'AttachNetworkEndpoints' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}/attachNetworkEndpoints',
                'body' => 'global_network_endpoint_groups_attach_endpoints_request_resource',
                'placeholders' => [
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}',
                'placeholders' => [
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'DetachNetworkEndpoints' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}/detachNetworkEndpoints',
                'body' => 'global_network_endpoint_groups_detach_endpoints_request_resource',
                'placeholders' => [
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/networkEndpointGroups/{network_endpoint_group}',
                'placeholders' => [
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
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
                    'network_endpoint_group' => [
                        'getters' => [
                            'getNetworkEndpointGroup',
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
        'google.cloud.compute.v1.GlobalOperations' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Wait' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}/wait',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
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
