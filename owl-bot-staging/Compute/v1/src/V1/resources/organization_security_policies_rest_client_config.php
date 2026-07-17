<?php
/*
 * Copyright 2026 Google LLC
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
        'google.cloud.compute.v1.OrganizationSecurityPolicies' => [
            'AddAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/addAssociation',
                'body' => 'security_policy_association_resource',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'AddRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/addRule',
                'body' => 'security_policy_rule_resource',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'CopyRules' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/copyRules',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'GetAssociation' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/getAssociation',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'GetRule' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/getRule',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies',
                'body' => 'security_policy_resource',
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies',
            ],
            'ListAssociations' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/listAssociations',
            ],
            'ListPreconfiguredExpressionSets' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/listPreconfiguredExpressionSets',
            ],
            'Move' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/move',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}',
                'body' => 'security_policy_resource',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'PatchRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/patchRule',
                'body' => 'security_policy_rule_resource',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'RemoveAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/removeAssociation',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'RemoveRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/locations/global/securityPolicies/{security_policy}/removeRule',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
