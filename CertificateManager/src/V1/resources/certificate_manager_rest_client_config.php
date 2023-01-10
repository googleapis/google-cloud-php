<?php

return [
    'interfaces' => [
        'google.cloud.certificatemanager.v1.CertificateManager' => [
            'CreateCertificate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificates',
                'body' => 'certificate',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'certificate_id',
                ],
            ],
            'CreateCertificateIssuanceConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificateIssuanceConfigs',
                'body' => 'certificate_issuance_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'certificate_issuance_config_id',
                ],
            ],
            'CreateCertificateMap' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificateMaps',
                'body' => 'certificate_map',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'certificate_map_id',
                ],
            ],
            'CreateCertificateMapEntry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/certificateMaps/*}/certificateMapEntries',
                'body' => 'certificate_map_entry',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'certificate_map_entry_id',
                ],
            ],
            'CreateDnsAuthorization' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dnsAuthorizations',
                'body' => 'dns_authorization',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'dns_authorization_id',
                ],
            ],
            'DeleteCertificate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCertificateIssuanceConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateIssuanceConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCertificateMap' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateMaps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCertificateMapEntry' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateMaps/*/certificateMapEntries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDnsAuthorization' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dnsAuthorizations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificateIssuanceConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateIssuanceConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificateMap' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateMaps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificateMapEntry' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateMaps/*/certificateMapEntries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDnsAuthorization' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dnsAuthorizations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCertificateIssuanceConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificateIssuanceConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCertificateMapEntries' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/certificateMaps/*}/certificateMapEntries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCertificateMaps' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificateMaps',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCertificates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDnsAuthorizations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dnsAuthorizations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCertificate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{certificate.name=projects/*/locations/*/certificates/*}',
                'body' => 'certificate',
                'placeholders' => [
                    'certificate.name' => [
                        'getters' => [
                            'getCertificate',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCertificateMap' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{certificate_map.name=projects/*/locations/*/certificateMaps/*}',
                'body' => 'certificate_map',
                'placeholders' => [
                    'certificate_map.name' => [
                        'getters' => [
                            'getCertificateMap',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCertificateMapEntry' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{certificate_map_entry.name=projects/*/locations/*/certificateMaps/*/certificateMapEntries/*}',
                'body' => 'certificate_map_entry',
                'placeholders' => [
                    'certificate_map_entry.name' => [
                        'getters' => [
                            'getCertificateMapEntry',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDnsAuthorization' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{dns_authorization.name=projects/*/locations/*/dnsAuthorizations/*}',
                'body' => 'dns_authorization',
                'placeholders' => [
                    'dns_authorization.name' => [
                        'getters' => [
                            'getDnsAuthorization',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*}/locations',
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
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
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
        ],
    ],
];
