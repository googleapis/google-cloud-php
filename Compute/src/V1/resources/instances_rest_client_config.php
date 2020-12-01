<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Instances' => [
            'AddAccessConfig' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/addAccessConfig',
                'body' => 'access_config_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'AddResourcePolicies' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/addResourcePolicies',
                'body' => 'instances_add_resource_policies_request_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/instances',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'AttachDisk' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/attachDisk',
                'body' => 'attached_disk_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'DeleteAccessConfig' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/deleteAccessConfig',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'DetachDisk' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/detachDisk',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'GetGuestAttributes' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/getGuestAttributes',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{resource}/getIamPolicy',
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
            'GetScreenshot' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/screenshot',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'GetSerialPortOutput' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/serialPort',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'GetShieldedInstanceIdentity' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/getShieldedInstanceIdentity',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances',
                'body' => 'instance_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances',
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
            'ListReferrers' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/referrers',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'RemoveResourcePolicies' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/removeResourcePolicies',
                'body' => 'instances_remove_resource_policies_request_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'Reset' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/reset',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetDeletionProtection' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{resource}/setDeletionProtection',
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
            'SetDiskAutoDelete' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setDiskAutoDelete',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{resource}/setIamPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setLabels',
                'body' => 'instances_set_labels_request_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetMachineResources' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setMachineResources',
                'body' => 'instances_set_machine_resources_request_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetMachineType' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setMachineType',
                'body' => 'instances_set_machine_type_request_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetMetadata' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setMetadata',
                'body' => 'metadata_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetMinCpuPlatform' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setMinCpuPlatform',
                'body' => 'instances_set_min_cpu_platform_request_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetScheduling' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setScheduling',
                'body' => 'scheduling_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetServiceAccount' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setServiceAccount',
                'body' => 'instances_set_service_account_request_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetShieldedInstanceIntegrityPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setShieldedInstanceIntegrityPolicy',
                'body' => 'shielded_instance_integrity_policy_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetTags' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/setTags',
                'body' => 'tags_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SimulateMaintenanceEvent' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/simulateMaintenanceEvent',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'Start' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/start',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'StartWithEncryptionKey' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/startWithEncryptionKey',
                'body' => 'instances_start_with_encryption_key_request_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'Stop' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/stop',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{resource}/testIamPermissions',
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
            'Update' => [
                'method' => 'put',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}',
                'body' => 'instance_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'UpdateAccessConfig' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/updateAccessConfig',
                'body' => 'access_config_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'UpdateDisplayDevice' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/updateDisplayDevice',
                'body' => 'display_device_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'UpdateNetworkInterface' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/updateNetworkInterface',
                'body' => 'network_interface_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'UpdateShieldedInstanceConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/updateShieldedInstanceConfig',
                'body' => 'shielded_instance_config_resource',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
