<?php

return [
    'interfaces' => [
        'google.cloud.managedidentities.v1.ManagedIdentitiesService' => [
            'AttachTrust' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/domains/*}:attachTrust',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateMicrosoftAdDomain' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/global}/domains',
                'body' => 'domain',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteDomain' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/domains/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DetachTrust' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/domains/*}:detachTrust',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDomain' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/domains/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDomains' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/global}/domains',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReconfigureTrust' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/domains/*}:reconfigureTrust',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResetAdminPassword' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/domains/*}:resetAdminPassword',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDomain' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{domain.name=projects/*/locations/global/domains/*}',
                'body' => 'domain',
                'placeholders' => [
                    'domain.name' => [
                        'getters' => [
                            'getDomain',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ValidateTrust' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/domains/*}:validateTrust',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
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
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
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
