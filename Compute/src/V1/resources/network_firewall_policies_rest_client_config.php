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
        'google.cloud.compute.v1.NetworkFirewallPolicies' => [
            'AddAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/addAssociation',
                'body' => 'firewall_policy_association_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'AddPacketMirroringRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/addPacketMirroringRule',
                'body' => 'firewall_policy_rule_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'AddRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/addRule',
                'body' => 'firewall_policy_rule_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/firewallPolicies',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'CloneRules' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/cloneRules',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetAssociation' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/getAssociation',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{resource}/getIamPolicy',
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
                ],
            ],
            'GetPacketMirroringRule' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/getPacketMirroringRule',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetRule' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/getRule',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies',
                'body' => 'firewall_policy_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}',
                'body' => 'firewall_policy_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'PatchPacketMirroringRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/patchPacketMirroringRule',
                'body' => 'firewall_policy_rule_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'PatchRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/patchRule',
                'body' => 'firewall_policy_rule_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'RemoveAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/removeAssociation',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'RemovePacketMirroringRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/removePacketMirroringRule',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'RemoveRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{firewall_policy}/removeRule',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{resource}/setIamPolicy',
                'body' => 'global_set_policy_request_resource',
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
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/firewallPolicies/{resource}/testIamPermissions',
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
