<?php

return [
    'interfaces' => [
        'google.cloud.kms.inventory.v1.KeyTrackingService' => [
            'GetProtectedResourcesSummary' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Kms\Inventory\V1\ProtectedResourcesSummary',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchProtectedResources' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProtectedResources',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Kms\Inventory\V1\SearchProtectedResourcesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'scope',
                        'fieldAccessors' => [
                            'getScope',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'organization' => 'organizations/{organization}',
                'projectLocationKeyRingCryptoKeyCryptoKeyVersionProtectedResourcesSummary' => 'projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}/cryptoKeyVersions/{crypto_key_version}/protectedResourcesSummary',
                'projectLocationKeyRingCryptoKeyProtectedResourcesSummary' => 'projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}/protectedResourcesSummary',
                'protectedResourcesSummary' => 'projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}/protectedResourcesSummary',
            ],
        ],
    ],
];
