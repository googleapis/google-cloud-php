<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.EventService' => [
            'CreateClientEvent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Talent\V4beta1\ClientEvent',
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
                'project' => 'projects/{project}',
                'tenant' => 'projects/{project}/tenants/{tenant}',
            ],
        ],
    ],
];
