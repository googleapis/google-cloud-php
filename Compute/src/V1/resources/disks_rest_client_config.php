<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Disks' => [
            'AddResourcePolicies' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{disk}/addResourcePolicies',
                'body' => 'disks_add_resource_policies_request_resource',
                'placeholders' => [
                    'disk' => [
                        'getters' => [
                            'getDisk',
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
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/disks',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'CreateSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{disk}/createSnapshot',
                'body' => 'snapshot_resource',
                'placeholders' => [
                    'disk' => [
                        'getters' => [
                            'getDisk',
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
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{disk}',
                'placeholders' => [
                    'disk' => [
                        'getters' => [
                            'getDisk',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{disk}',
                'placeholders' => [
                    'disk' => [
                        'getters' => [
                            'getDisk',
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
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{resource}/getIamPolicy',
                'placeholders' => [
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks',
                'body' => 'disk_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks',
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
            'RemoveResourcePolicies' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{disk}/removeResourcePolicies',
                'body' => 'disks_remove_resource_policies_request_resource',
                'placeholders' => [
                    'disk' => [
                        'getters' => [
                            'getDisk',
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
            'Resize' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{disk}/resize',
                'body' => 'disks_resize_request_resource',
                'placeholders' => [
                    'disk' => [
                        'getters' => [
                            'getDisk',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{resource}/setIamPolicy',
                'body' => 'zone_set_policy_request_resource',
                'placeholders' => [
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetLabels' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{resource}/setLabels',
                'body' => 'zone_set_labels_request_resource',
                'placeholders' => [
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/disks/{resource}/testIamPermissions',
                'body' => 'test_permissions_request_resource',
                'placeholders' => [
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
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
