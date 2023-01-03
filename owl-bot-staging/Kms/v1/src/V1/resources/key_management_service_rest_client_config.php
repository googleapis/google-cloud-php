<?php

return [
    'interfaces' => [
        'google.cloud.kms.v1.KeyManagementService' => [
            'AsymmetricDecrypt' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}:asymmetricDecrypt',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'AsymmetricSign' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}:asymmetricSign',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateCryptoKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/keyRings/*}/cryptoKeys',
                'body' => 'crypto_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'crypto_key_id',
                ],
            ],
            'CreateCryptoKeyVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/keyRings/*/cryptoKeys/*}/cryptoKeyVersions',
                'body' => 'crypto_key_version',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateImportJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/keyRings/*}/importJobs',
                'body' => 'import_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'import_job_id',
                ],
            ],
            'CreateKeyRing' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/keyRings',
                'body' => 'key_ring',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'key_ring_id',
                ],
            ],
            'Decrypt' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*}:decrypt',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DestroyCryptoKeyVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}:destroy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'Encrypt' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/**}:encrypt',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateRandomBytes' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{location=projects/*/locations/*}:generateRandomBytes',
                'body' => '*',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'GetCryptoKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCryptoKeyVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetImportJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/importJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetKeyRing' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPublicKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}/publicKey',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportCryptoKeyVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/keyRings/*/cryptoKeys/*}/cryptoKeyVersions:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCryptoKeyVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/keyRings/*/cryptoKeys/*}/cryptoKeyVersions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCryptoKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/keyRings/*}/cryptoKeys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListImportJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/keyRings/*}/importJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListKeyRings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/keyRings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MacSign' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}:macSign',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MacVerify' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}:macVerify',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestoreCryptoKeyVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}:restore',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCryptoKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{crypto_key.name=projects/*/locations/*/keyRings/*/cryptoKeys/*}',
                'body' => 'crypto_key',
                'placeholders' => [
                    'crypto_key.name' => [
                        'getters' => [
                            'getCryptoKey',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCryptoKeyPrimaryVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/*}:updatePrimaryVersion',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCryptoKeyVersion' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{crypto_key_version.name=projects/*/locations/*/keyRings/*/cryptoKeys/*/cryptoKeyVersions/*}',
                'body' => 'crypto_key_version',
                'placeholders' => [
                    'crypto_key_version.name' => [
                        'getters' => [
                            'getCryptoKeyVersion',
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
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*/cryptoKeys/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*/importJobs/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/ekmConfig}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/ekmConnections/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*/cryptoKeys/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*/importJobs/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/ekmConfig}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/ekmConnections/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*/cryptoKeys/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/keyRings/*/importJobs/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/ekmConfig}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/ekmConnections/*}:testIamPermissions',
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
