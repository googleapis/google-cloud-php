<?php
/*
 * Copyright 2025 Google LLC
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
        'google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService' => [
            'AddIpOverride' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/keys/*}:addIpOverride',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'AnnotateAssessment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/assessments/*}:annotate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateAssessment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/assessments',
                'body' => 'assessment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateFirewallPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/firewallpolicies',
                'body' => 'firewall_policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/keys',
                'body' => 'key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteFirewallPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/firewallpolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteKey' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/keys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFirewallPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/firewallpolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/keys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetrics' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/keys/*/metrics}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListFirewallPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/firewallpolicies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIpOverrides' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/keys/*}:listIpOverrides',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/keys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRelatedAccountGroupMemberships' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/relatedaccountgroups/*}/memberships',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRelatedAccountGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/relatedaccountgroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MigrateKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/keys/*}:migrate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RemoveIpOverride' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/keys/*}:removeIpOverride',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ReorderFirewallPolicies' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/firewallpolicies:reorder',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RetrieveLegacySecretKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{key=projects/*/keys/*}:retrieveLegacySecretKey',
                'placeholders' => [
                    'key' => [
                        'getters' => [
                            'getKey',
                        ],
                    ],
                ],
            ],
            'SearchRelatedAccountGroupMemberships' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{project=projects/*}/relatedaccountgroupmemberships:search',
                'body' => '*',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'UpdateFirewallPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{firewall_policy.name=projects/*/firewallpolicies/*}',
                'body' => 'firewall_policy',
                'placeholders' => [
                    'firewall_policy.name' => [
                        'getters' => [
                            'getFirewallPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{key.name=projects/*/keys/*}',
                'body' => 'key',
                'placeholders' => [
                    'key.name' => [
                        'getters' => [
                            'getKey',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
