<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.InstanceGroupManagers' => [
            'AbandonInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/abandonInstances',
                'body' => 'instance_group_managers_abandon_instances_request_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/instanceGroupManagers',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ApplyUpdatesToInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/applyUpdatesToInstances',
                'body' => 'instance_group_managers_apply_updates_request_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'CreateInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/createInstances',
                'body' => 'instance_group_managers_create_instances_request_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'DeleteInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/deleteInstances',
                'body' => 'instance_group_managers_delete_instances_request_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'DeletePerInstanceConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/deletePerInstanceConfigs',
                'body' => 'instance_group_managers_delete_per_instance_configs_req_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers',
                'body' => 'instance_group_manager_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'ListErrors' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/listErrors',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'ListManagedInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/listManagedInstances',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'ListPerInstanceConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/listPerInstanceConfigs',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}',
                'body' => 'instance_group_manager_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'PatchPerInstanceConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/patchPerInstanceConfigs',
                'body' => 'instance_group_managers_patch_per_instance_configs_req_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'RecreateInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/recreateInstances',
                'body' => 'instance_group_managers_recreate_instances_request_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'Resize' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/resize',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
                'queryParams' => [
                    'size',
                ],
            ],
            'SetInstanceTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/setInstanceTemplate',
                'body' => 'instance_group_managers_set_instance_template_request_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'SetTargetPools' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/setTargetPools',
                'body' => 'instance_group_managers_set_target_pools_request_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'UpdatePerInstanceConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/updatePerInstanceConfigs',
                'body' => 'instance_group_managers_update_per_instance_configs_req_resource',
                'placeholders' => [
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.compute.v1.ZoneOperations' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/operations/{operation}',
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
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/operations/{operation}',
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
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'Wait' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/operations/{operation}/wait',
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
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
