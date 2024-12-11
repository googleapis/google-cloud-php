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
        'google.cloud.compute.v1.FirewallPolicies' => [
            'AddAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/addAssociation',
                'body' => 'firewall_policy_association_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'AddRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/addRule',
                'body' => 'firewall_policy_rule_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'CloneRules' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/cloneRules',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'GetAssociation' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/getAssociation',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{resource}/getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetRule' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/getRule',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies',
                'body' => 'firewall_policy_resource',
                'queryParams' => [
                    'parent_id',
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies',
            ],
            'ListAssociations' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/listAssociations',
            ],
            'Move' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/move',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
                'queryParams' => [
                    'parent_id',
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}',
                'body' => 'firewall_policy_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'PatchRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/patchRule',
                'body' => 'firewall_policy_rule_resource',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'RemoveAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/removeAssociation',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'RemoveRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{firewall_policy}/removeRule',
                'placeholders' => [
                    'firewall_policy' => [
                        'getters' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{resource}/setIamPolicy',
                'body' => 'global_organization_set_policy_request_resource',
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
                'uriTemplate' => '/compute/v1/locations/global/firewallPolicies/{resource}/testIamPermissions',
                'body' => 'test_permissions_request_resource',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.compute.v1.GlobalOrganizationOperations' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/locations/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/operations',
            ],
        ],
    ],
];
