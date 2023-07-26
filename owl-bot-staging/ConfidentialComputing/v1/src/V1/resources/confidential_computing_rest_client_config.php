<?php

return [
    'interfaces' => [
        'google.cloud.confidentialcomputing.v1.ConfidentialComputing' => [
            'CreateChallenge' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/challenges',
                'body' => 'challenge',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'VerifyAttestation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{challenge=projects/*/locations/*/challenges/*}:verifyAttestation',
                'body' => '*',
                'placeholders' => [
                    'challenge' => [
                        'getters' => [
                            'getChallenge',
                        ],
                    ],
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
    ],
    'numericEnums' => true,
];
