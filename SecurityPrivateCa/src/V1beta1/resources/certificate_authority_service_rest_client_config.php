<?php

return [
    'interfaces' => [
        'google.cloud.security.privateca.v1beta1.CertificateAuthorityService' => [
            'CreateCertificate' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/certificateAuthorities/*}/certificates',
                'body' => 'certificate',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetCertificate' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*/certificates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCertificates' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/certificateAuthorities/*}/certificates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RevokeCertificate' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*/certificates/*}:revoke',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCertificate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{certificate.name=projects/*/locations/*/certificateAuthorities/*/certificates/*}',
                'body' => 'certificate',
                'placeholders' => [
                    'certificate.name' => [
                        'getters' => [
                            'getCertificate',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ActivateCertificateAuthority' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*}:activate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateCertificateAuthority' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/certificateAuthorities',
                'body' => 'certificate_authority',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DisableCertificateAuthority' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*}:disable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EnableCertificateAuthority' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*}:enable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchCertificateAuthorityCsr' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*}:fetch',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificateAuthority' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCertificateAuthorities' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/certificateAuthorities',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RestoreCertificateAuthority' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*}:restore',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ScheduleDeleteCertificateAuthority' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*}:scheduleDelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCertificateAuthority' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{certificate_authority.name=projects/*/locations/*/certificateAuthorities/*}',
                'body' => 'certificate_authority',
                'placeholders' => [
                    'certificate_authority.name' => [
                        'getters' => [
                            'getCertificateAuthority',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificateRevocationList' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/certificateAuthorities/*/certificateRevocationLists/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCertificateRevocationLists' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/certificateAuthorities/*}/certificateRevocationLists',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCertificateRevocationList' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{certificate_revocation_list.name=projects/*/locations/*/certificateAuthorities/*/certificateRevocationLists/*}',
                'body' => 'certificate_revocation_list',
                'placeholders' => [
                    'certificate_revocation_list.name' => [
                        'getters' => [
                            'getCertificateRevocationList',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetReusableConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/reusableConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListReusableConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/reusableConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
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
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/operations/*}:cancel',
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
