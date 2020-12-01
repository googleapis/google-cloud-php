<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.InstanceGroups' => [
            'AddInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroups/{instance_group}/addInstances',
                'body' => 'instance_groups_add_instances_request_resource',
                'placeholders' => [
                    'instance_group' => [
                        'getters' => [
                            'getInstanceGroup',
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
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/instanceGroups',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroups/{instance_group}',
                'placeholders' => [
                    'instance_group' => [
                        'getters' => [
                            'getInstanceGroup',
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
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroups/{instance_group}',
                'placeholders' => [
                    'instance_group' => [
                        'getters' => [
                            'getInstanceGroup',
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
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroups',
                'body' => 'instance_group_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroups',
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
            'ListInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroups/{instance_group}/listInstances',
                'body' => 'instance_groups_list_instances_request_resource',
                'placeholders' => [
                    'instance_group' => [
                        'getters' => [
                            'getInstanceGroup',
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
            'RemoveInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroups/{instance_group}/removeInstances',
                'body' => 'instance_groups_remove_instances_request_resource',
                'placeholders' => [
                    'instance_group' => [
                        'getters' => [
                            'getInstanceGroup',
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
            'SetNamedPorts' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroups/{instance_group}/setNamedPorts',
                'body' => 'instance_groups_set_named_ports_request_resource',
                'placeholders' => [
                    'instance_group' => [
                        'getters' => [
                            'getInstanceGroup',
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
        ],
    ],
];
