<?php

return [
    'interfaces' => [
        'google.cloud.binaryauthorization.v1.SystemPolicyV1' => [
            'GetSystemPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BinaryAuthorization\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'locationPolicy' => 'locations/{location}/policy',
                'policy' => 'projects/{project}/policy',
                'projectPolicy' => 'projects/{project}/policy',
            ],
        ],
    ],
];
