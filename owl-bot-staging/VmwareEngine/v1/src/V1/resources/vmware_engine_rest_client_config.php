<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
            'CreateExternalAccessRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/networkPolicies/*}/externalAccessRules',
                'body' => 'external_access_rule',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'external_access_rule_id',
                ],
            ],
            'CreateExternalAddress' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/externalAddresses',
                'body' => 'external_address',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'external_address_id',
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
            'CreateLoggingServer' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/loggingServers',
                'body' => 'logging_server',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'logging_server_id',
                ],
            ],
            'CreateManagementDnsZoneBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/managementDnsZoneBindings',
                'body' => 'management_dns_zone_binding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'management_dns_zone_binding_id',
                ],
            ],
            'CreateNetworkPeering' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/networkPeerings',
                'body' => 'network_peering',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'network_peering_id',
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
            'CreatePrivateConnection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/privateConnections',
                'body' => 'private_connection',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'private_connection_id',
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
            'DeleteExternalAccessRule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/networkPolicies/*/externalAccessRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExternalAddress' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/externalAddresses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteLoggingServer' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/loggingServers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteManagementDnsZoneBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/managementDnsZoneBindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteNetworkPeering' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/networkPeerings/*}',
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
            'DeletePrivateConnection' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateConnections/*}',
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
            'FetchNetworkPolicyExternalAddresses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{network_policy=projects/*/locations/*/networkPolicies/*}:fetchExternalAddresses',
                'placeholders' => [
                    'network_policy' => [
                        'getters' => [
                            'getNetworkPolicy',
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
            'GetDnsBindPermission' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dnsBindPermission}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDnsForwarding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/dnsForwarding}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExternalAccessRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/networkPolicies/*/externalAccessRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExternalAddress' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/externalAddresses/*}',
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
            'GetLoggingServer' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/loggingServers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetManagementDnsZoneBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/managementDnsZoneBindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNetworkPeering' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/networkPeerings/*}',
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
            'GetNode' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/clusters/*/nodes/*}',
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
            'GetPrivateConnection' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateConnections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSubnet' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/subnets/*}',
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
            'GrantDnsBindPermission' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dnsBindPermission}:grant',
                'body' => '*',
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
            'ListExternalAccessRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/networkPolicies/*}/externalAccessRules',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExternalAddresses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/externalAddresses',
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
            'ListLoggingServers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/loggingServers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListManagementDnsZoneBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*}/managementDnsZoneBindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNetworkPeerings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/networkPeerings',
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
            'ListNodes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateClouds/*/clusters/*}/nodes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPeeringRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/networkPeerings/*}/peeringRoutes',
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
            'ListPrivateConnectionPeeringRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateConnections/*}/peeringRoutes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPrivateConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/privateConnections',
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
            'RepairManagementDnsZoneBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateClouds/*/managementDnsZoneBindings/*}:repair',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'RevokeDnsBindPermission' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dnsBindPermission}:revoke',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'UpdateDnsForwarding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{dns_forwarding.name=projects/*/locations/*/privateClouds/*/dnsForwarding}',
                'body' => 'dns_forwarding',
                'placeholders' => [
                    'dns_forwarding.name' => [
                        'getters' => [
                            'getDnsForwarding',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateExternalAccessRule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{external_access_rule.name=projects/*/locations/*/networkPolicies/*/externalAccessRules/*}',
                'body' => 'external_access_rule',
                'placeholders' => [
                    'external_access_rule.name' => [
                        'getters' => [
                            'getExternalAccessRule',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateExternalAddress' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{external_address.name=projects/*/locations/*/privateClouds/*/externalAddresses/*}',
                'body' => 'external_address',
                'placeholders' => [
                    'external_address.name' => [
                        'getters' => [
                            'getExternalAddress',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateLoggingServer' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{logging_server.name=projects/*/locations/*/privateClouds/*/loggingServers/*}',
                'body' => 'logging_server',
                'placeholders' => [
                    'logging_server.name' => [
                        'getters' => [
                            'getLoggingServer',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateManagementDnsZoneBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{management_dns_zone_binding.name=projects/*/locations/*/privateClouds/*/managementDnsZoneBindings/*}',
                'body' => 'management_dns_zone_binding',
                'placeholders' => [
                    'management_dns_zone_binding.name' => [
                        'getters' => [
                            'getManagementDnsZoneBinding',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateNetworkPeering' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{network_peering.name=projects/*/locations/*/networkPeerings/*}',
                'body' => 'network_peering',
                'placeholders' => [
                    'network_peering.name' => [
                        'getters' => [
                            'getNetworkPeering',
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
            'UpdatePrivateConnection' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{private_connection.name=projects/*/locations/*/privateConnections/*}',
                'body' => 'private_connection',
                'placeholders' => [
                    'private_connection.name' => [
                        'getters' => [
                            'getPrivateConnection',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSubnet' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{subnet.name=projects/*/locations/*/privateClouds/*/subnets/*}',
                'body' => 'subnet',
                'placeholders' => [
                    'subnet.name' => [
                        'getters' => [
                            'getSubnet',
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
    'numericEnums' => true,
];
