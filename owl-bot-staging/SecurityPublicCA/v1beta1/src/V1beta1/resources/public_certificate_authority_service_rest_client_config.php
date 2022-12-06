<?php

return [
    'interfaces' => [
        'google.cloud.security.publicca.v1beta1.PublicCertificateAuthorityService' => [
            'CreateExternalAccountKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/externalAccountKeys',
                'body' => 'external_account_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
