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
                    'network_interface',
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
            'BulkInsert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/bulkInsert',
                'body' => 'bulk_insert_instance_resource_resource',
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
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'DeleteAccessConfig' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/deleteAccessConfig',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                    'access_config',
                    'network_interface',
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
                    'device_name',
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
            'GetEffectiveFirewalls' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/getEffectiveFirewalls',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                    'network_interface',
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
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{resource}/getIamPolicy',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
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
            'GetSerialPortOutput' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/serialPort',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'GetShieldedInstanceIdentity' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/getShieldedInstanceIdentity',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances',
                'body' => 'instance_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances',
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
            'ListReferrers' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/referrers',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'Reset' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/reset',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'Resume' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/resume',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SendDiagnosticInterrupt' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/sendDiagnosticInterrupt',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'SetDeletionProtection' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{resource}/setDeletionProtection',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
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
                    'auto_delete',
                    'device_name',
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{resource}/setIamPolicy',
                'body' => 'zone_set_policy_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
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
            'SimulateMaintenanceEvent' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/simulateMaintenanceEvent',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'Start' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/start',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'Stop' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/stop',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'Suspend' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{instance}/suspend',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/instances/{resource}/testIamPermissions',
                'body' => 'test_permissions_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
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
                    'network_interface',
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
                    'network_interface',
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
