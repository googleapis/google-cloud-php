<?php

return [
    'interfaces' => [
        'google.cloud.datacatalog.v1.PolicyTagManager' => [
            'CreateTaxonomy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/taxonomies',
                'body' => 'taxonomy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteTaxonomy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/taxonomies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTaxonomy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{taxonomy.name=projects/*/locations/*/taxonomies/*}',
                'body' => 'taxonomy',
                'placeholders' => [
                    'taxonomy.name' => [
                        'getters' => [
                            'getTaxonomy',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTaxonomies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/taxonomies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetTaxonomy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/taxonomies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreatePolicyTag' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/taxonomies/*}/policyTags',
                'body' => 'policy_tag',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeletePolicyTag' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/taxonomies/*/policyTags/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePolicyTag' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{policy_tag.name=projects/*/locations/*/taxonomies/*/policyTags/*}',
                'body' => 'policy_tag',
                'placeholders' => [
                    'policy_tag.name' => [
                        'getters' => [
                            'getPolicyTag',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPolicyTags' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/taxonomies/*}/policyTags',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetPolicyTag' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/taxonomies/*/policyTags/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/taxonomies/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/taxonomies/*/policyTags/*}:getIamPolicy',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/taxonomies/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/taxonomies/*/policyTags/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/taxonomies/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/taxonomies/*/policyTags/*}:testIamPermissions',
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
    ],
];
