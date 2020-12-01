<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.SecurityPolicies' => [
            'AddRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}/addRule',
                'body' => 'security_policy_rule_resource',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}/getRule',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies',
                'body' => 'security_policy_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ListPreconfiguredExpressionSets' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/listPreconfiguredExpressionSets',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}',
                'body' => 'security_policy_resource',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}/patchRule',
                'body' => 'security_policy_rule_resource',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}/removeRule',
                'placeholders' => [
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
