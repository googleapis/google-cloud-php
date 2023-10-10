<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4.EventService' => [
            'CreateClientEvent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Talent\V4\ClientEvent',
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
                'tenant' => 'projects/{project}/tenants/{tenant}',
            ],
        ],
    ],
];
