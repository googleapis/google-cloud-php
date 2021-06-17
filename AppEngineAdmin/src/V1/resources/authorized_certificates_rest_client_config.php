<?php

return [
    'interfaces' => [
        'google.appengine.v1.AuthorizedCertificates' => [
            'CreateAuthorizedCertificate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=apps/*}/authorizedCertificates',
                'body' => 'certificate',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAuthorizedCertificate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=apps/*/authorizedCertificates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAuthorizedCertificate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=apps/*/authorizedCertificates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAuthorizedCertificates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=apps/*}/authorizedCertificates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAuthorizedCertificate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=apps/*/authorizedCertificates/*}',
                'body' => 'certificate',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=apps/*/locations/*}',
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
                'uriTemplate' => '/v1/{name=apps/*}/locations',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=apps/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=apps/*}/operations',
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
