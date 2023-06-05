<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.ImageFamilyViews' => [
            'Get' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\ImageFamilyView',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'family',
                        'fieldAccessors' => [
                            'getFamily',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
