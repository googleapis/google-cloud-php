<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.RegionInstanceGroupManagers' => [
            'AbandonInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/abandonInstances',
                'body' => 'region_instance_group_managers_abandon_instances_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                    'instance_group_manager' => [
                        'getters' => [
                            'getInstanceGroupManager',
                        ],
                    ],
                ],
            ],
            'ApplyUpdatesToInstances' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/applyUpdatesToInstances',
                'body' => 'region_instance_group_managers_apply_updates_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/createInstances',
                'body' => 'region_instance_group_managers_create_instances_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/deleteInstances',
                'body' => 'region_instance_group_managers_delete_instances_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/deletePerInstanceConfigs',
                'body' => 'region_instance_group_manager_delete_instance_config_req_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers',
                'body' => 'instance_group_manager_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'ListErrors' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/listErrors',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/listManagedInstances',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/listPerInstanceConfigs',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}',
                'body' => 'instance_group_manager_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/patchPerInstanceConfigs',
                'body' => 'region_instance_group_manager_patch_instance_config_req_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/recreateInstances',
                'body' => 'region_instance_group_managers_recreate_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/resize',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/setInstanceTemplate',
                'body' => 'region_instance_group_managers_set_template_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/setTargetPools',
                'body' => 'region_instance_group_managers_set_target_pools_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instanceGroupManagers/{instance_group_manager}/updatePerInstanceConfigs',
                'body' => 'region_instance_group_manager_update_instance_config_req_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
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
