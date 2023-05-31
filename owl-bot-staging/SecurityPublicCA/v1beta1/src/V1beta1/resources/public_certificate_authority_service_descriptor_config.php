<?php

return [
    'interfaces' => [
        'google.cloud.security.publicca.v1beta1.PublicCertificateAuthorityService' => [
            'CreateExternalAccountKey' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Security\PublicCA\V1beta1\ExternalAccountKey',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'externalAccountKey' => 'projects/{project}/locations/{location}/externalAccountKeys/{external_account_key}',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
