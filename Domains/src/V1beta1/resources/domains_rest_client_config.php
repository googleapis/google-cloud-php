<?php

return [
    'interfaces' => [
        'google.cloud.domains.v1beta1.Domains' => [
            'ConfigureContactSettings' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{registration=projects/*/locations/*/registrations/*}:configureContactSettings',
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
                'uriTemplate' => '/v1beta1/{registration=projects/*/locations/*/registrations/*}:configureDnsSettings',
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
                'uriTemplate' => '/v1beta1/{registration=projects/*/locations/*/registrations/*}:configureManagementSettings',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/registrations/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/registrations/*}:export',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/registrations/*}',
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
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/registrations',
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
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/registrations:register',
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
                'uriTemplate' => '/v1beta1/{registration=projects/*/locations/*/registrations/*}:resetAuthorizationCode',
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
                'uriTemplate' => '/v1beta1/{registration=projects/*/locations/*/registrations/*}:retrieveAuthorizationCode',
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
                'uriTemplate' => '/v1beta1/{location=projects/*/locations/*}/registrations:retrieveRegisterParameters',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'RetrieveTransferParameters' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{location=projects/*/locations/*}/registrations:retrieveTransferParameters',
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
                'uriTemplate' => '/v1beta1/{location=projects/*/locations/*}/registrations:searchDomains',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'TransferDomain' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/registrations:transfer',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateRegistration' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{registration.name=projects/*/locations/*/registrations/*}',
                'body' => 'registration',
                'placeholders' => [
                    'registration.name' => [
                        'getters' => [
                            'getRegistration',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/registrations/*}:getIamPolicy',
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
                'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/registrations/*}:setIamPolicy',
                'body' => '*',
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
                'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/registrations/*}:testIamPermissions',
                'body' => '*',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*}/operations',
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
