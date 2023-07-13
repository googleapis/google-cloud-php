<?php

return [
    'interfaces' => [
        'google.cloud.kms.inventory.v1.KeyTrackingService' => [
            'GetProtectedResourcesSummary' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/keyRings/*/cryptoKeys/**}/protectedResourcesSummary',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchProtectedResources' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{scope=organizations/*}/protectedResources:search',
                'placeholders' => [
                    'scope' => [
                        'getters' => [
                            'getScope',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
