<?php

return [
    'interfaces' => [
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.vmwareengine.v1.VmwareEngine' => [
            'CreateCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/clusters',
                'body' => 'cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cluster_id',
                ],
            ],
            'CreateHcxActivationKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/hcxActivationKeys',
                'body' => 'hcx_activation_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'hcx_activation_key_id',
                ],
            ],
            'CreateNetworkPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/networkPolicies',
                'body' => 'network_policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'network_policy_id',
                ],
            ],
            'CreatePrivateCloud' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/privateClouds',
                'body' => 'private_cloud',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'private_cloud_id',
                ],
            ],
            'CreateVmwareEngineNetwork' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/vmwareEngineNetworks',
                'body' => 'vmware_engine_network',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'vmware_engine_network_id',
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteNetworkPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/networkPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePrivateCloud' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteVmwareEngineNetwork' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/vmwareEngineNetworks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHcxActivationKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/hcxActivationKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNetworkPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/networkPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNodeType' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/nodeTypes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPrivateCloud' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVmwareEngineNetwork' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/vmwareEngineNetworks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/clusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHcxActivationKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/hcxActivationKeys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNetworkPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/networkPolicies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNodeTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/nodeTypes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPrivateClouds' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/privateClouds',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSubnets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/subnets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVmwareEngineNetworks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/vmwareEngineNetworks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResetNsxCredentials' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{private_cloud=projects/*/locations/*/privateClouds/*}:resetNsxCredentials',
                'body' => '*',
                'placeholders' => [
                    'private_cloud' => [
                        'getters' => [
                            'getPrivateCloud',
                        ],
                    ],
                ],
            ],
            'ResetVcenterCredentials' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{private_cloud=projects/*/locations/*/privateClouds/*}:resetVcenterCredentials',
                'body' => '*',
                'placeholders' => [
                    'private_cloud' => [
                        'getters' => [
                            'getPrivateCloud',
                        ],
                    ],
                ],
            ],
            'ShowNsxCredentials' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{private_cloud=projects/*/locations/*/privateClouds/*}:showNsxCredentials',
                'placeholders' => [
                    'private_cloud' => [
                        'getters' => [
                            'getPrivateCloud',
                        ],
                    ],
                ],
            ],
            'ShowVcenterCredentials' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{private_cloud=projects/*/locations/*/privateClouds/*}:showVcenterCredentials',
                'placeholders' => [
                    'private_cloud' => [
                        'getters' => [
                            'getPrivateCloud',
                        ],
                    ],
                ],
            ],
            'UndeletePrivateCloud' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{cluster.name=projects/*/locations/*/privateClouds/*/clusters/*}',
                'body' => 'cluster',
                'placeholders' => [
                    'cluster.name' => [
                        'getters' => [
                            'getCluster',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateNetworkPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{network_policy.name=projects/*/locations/*/networkPolicies/*}',
                'body' => 'network_policy',
                'placeholders' => [
                    'network_policy.name' => [
                        'getters' => [
                            'getNetworkPolicy',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdatePrivateCloud' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{private_cloud.name=projects/*/locations/*/privateClouds/*}',
                'body' => 'private_cloud',
                'placeholders' => [
                    'private_cloud.name' => [
                        'getters' => [
                            'getPrivateCloud',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateVmwareEngineNetwork' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{vmware_engine_network.name=projects/*/locations/*/vmwareEngineNetworks/*}',
                'body' => 'vmware_engine_network',
                'placeholders' => [
                    'vmware_engine_network.name' => [
                        'getters' => [
                            'getVmwareEngineNetwork',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*/clusters/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*/hcxActivationKeys/*}:getIamPolicy',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*/clusters/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*/hcxActivationKeys/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*/clusters/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateClouds/*/hcxActivationKeys/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
