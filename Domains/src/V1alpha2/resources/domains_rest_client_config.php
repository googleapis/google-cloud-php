<?php

return [
    'interfaces' => [
        'google.cloud.domains.v1alpha2.Domains' => [
            'ConfigureContactSettings' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{registration=projects/*/locations/*/registrations/*}:configureContactSettings',
                'body' => '*',
                'placeholders' => [
                    'registration' => [
                        'getters' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'ConfigureDnsSettings' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{registration=projects/*/locations/*/registrations/*}:configureDnsSettings',
                'body' => '*',
                'placeholders' => [
                    'registration' => [
                        'getters' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'ConfigureManagementSettings' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{registration=projects/*/locations/*/registrations/*}:configureManagementSettings',
                'body' => '*',
                'placeholders' => [
                    'registration' => [
                        'getters' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'DeleteRegistration' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha2/{name=projects/*/locations/*/registrations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportRegistration' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{name=projects/*/locations/*/registrations/*}:export',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRegistration' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{name=projects/*/locations/*/registrations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListRegistrations' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/locations/*}/registrations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RegisterDomain' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/locations/*}/registrations:register',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResetAuthorizationCode' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{registration=projects/*/locations/*/registrations/*}:resetAuthorizationCode',
                'body' => '*',
                'placeholders' => [
                    'registration' => [
                        'getters' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'RetrieveAuthorizationCode' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{registration=projects/*/locations/*/registrations/*}:retrieveAuthorizationCode',
                'placeholders' => [
                    'registration' => [
                        'getters' => [
                            'getRegistration',
                        ],
                    ],
                ],
            ],
            'RetrieveRegisterParameters' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{location=projects/*/locations/*}/registrations:retrieveRegisterParameters',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'SearchDomains' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{location=projects/*/locations/*}/registrations:searchDomains',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'UpdateRegistration' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha2/{registration.name=projects/*/locations/*/registrations/*}',
                'body' => 'registration',
                'placeholders' => [
                    'registration.name' => [
                        'getters' => [
                            'getRegistration',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{name=projects/*/locations/*}/operations',
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
                'uriTemplate' => '/v1alpha2/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1alpha2/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1alpha2/{name=projects/*/locations/*/operations/*}:cancel',
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
