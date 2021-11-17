<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.SecurityPolicies' => [
            'AddRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}/addRule',
                'body' => 'security_policy_rule_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'GetRule' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}/getRule',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
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
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'PatchRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}/patchRule',
                'body' => 'security_policy_rule_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'RemoveRule' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/securityPolicies/{security_policy}/removeRule',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'security_policy' => [
                        'getters' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
