<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.InstanceGroupManagers' => [
            'AbandonInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/abandonInstances',
                'body' => 'instance_group_managers_abandon_instances_request_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'CreateInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/createInstances',
                'body' => 'instance_group_managers_create_instances_request_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'DeleteInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/deleteInstances',
                'body' => 'instance_group_managers_delete_instances_request_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'DeletePerInstanceConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/deletePerInstanceConfigs',
                'body' => 'instance_group_managers_delete_per_instance_configs_req_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers',
                'body' => 'instance_group_manager_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers',
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
            'ListErrors' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/listErrors',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'ListManagedInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/listManagedInstances',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'ListPerInstanceConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/listPerInstanceConfigs',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}',
                'body' => 'instance_group_manager_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'PatchPerInstanceConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/patchPerInstanceConfigs',
                'body' => 'instance_group_managers_patch_per_instance_configs_req_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'RecreateInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/recreateInstances',
                'body' => 'instance_group_managers_recreate_instances_request_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'Resize' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/resize',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'SetInstanceTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/setInstanceTemplate',
                'body' => 'instance_group_managers_set_instance_template_request_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'SetTargetPools' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/setTargetPools',
                'body' => 'instance_group_managers_set_target_pools_request_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'UpdatePerInstanceConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instanceGroupManagers/{instance_group_manager}/updatePerInstanceConfigs',
                'body' => 'instance_group_managers_update_per_instance_configs_req_resource',
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
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
